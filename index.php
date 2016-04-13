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
    );

    function appendProxy($value, $full = false) {
        global $url, $base_url;
        $value = $full ? $value : $url . $value;
        return  "$base_url$value";
    }

    array_walk($tags, function($attributeName, $tagName) use ($dom){
      $t = $dom->getElementsByTagName ($tagName);
      foreach($t as $element) {
        $attr = $element->getAttribute($attributeName);
        if (!empty($attr)) {
          $element->setAttribute($attributeName, appendProxy($attr, strpos($attr, 'http') === 0));
        }
      };
    });
    $output = $dom->saveHTML();
  }
  $full_type = $mime_type['full-type'];
  header("Content-type: $full_type");
  echo $output;
