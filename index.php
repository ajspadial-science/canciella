<?php
  include ('utilHTTP.php');

  $base_url = 'http://canciella.net/';

  $url = ltrim($_SERVER['REQUEST_URI'], '/');
  $url = strpos($url, 'http://') !== false ? $url : 'http://' . $url;

  libxml_use_internal_errors(true);

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $site_content = curl_exec($curl);
  $content_type = trim(curl_getinfo($curl, CURLINFO_CONTENT_TYPE));
  curl_close($curl);

  $output = $site_content;
  $mime_type = !$content_type ? null : parseMIME($content_type);
  if ($mime_type && $mime_type['full-type'] === 'text/html') {
    $dom = new DOMDocument();
    $dom->loadHTML($site_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    $tags = array(
      'link'   => 'href',
      'script' => 'src',
      'a'      => 'href',
      'img'    => 'src',
      'meta'   => 'url',
    );

    function appendProxy($href) {
        global $url, $base_url;
        $parsed_href = parse_url($href);

        if (isset($parsed_href['scheme']) && isset($parsed_href['host'])) {
          // full html address
          return "$base_url$href";
        }
        else {
          $parsed_url = parse_url($url);
          $scheme = $parsed_url['scheme'] . "://";
          $host = $parsed_url['host'];
          $port = isset($parsed_url['port']) ? ":" . $parsed_url['port'] : "";
          $base = "$scheme$host$port/";

          if (isset($parsed_url['path'])) {
            $folder = strrpos($parsed_url['path'], '/') ? substr($parsed_url['path'], 0, strrpos($parsed_url['path'], '/')) : $parsed_url['path'];
          }
          else {
            $folder = "/";
          }
          
          if (strpos($href, "/") === 0) {
            // absolute address in this domain
            return "$base_url$base" . ltrim($href, "/");
          }
          else {
            // relative address in this domain
            return "$base_url$base$folder/$href";
          }
        }
    }

    array_walk($tags, function($attributeName, $tagName) use ($dom){
      $t = $dom->getElementsByTagName ($tagName);
      foreach($t as $element) {
        $attr = $element->getAttribute($attributeName);
        if (!empty($attr)) {
          $element->setAttribute($attributeName, appendProxy($attr));
        }
      };
    });
    $output = $dom->saveHTML();
  }
  $full_type = $mime_type['full-type'];
  echo $output;
