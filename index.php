<?php
  $base_url = 'http://10.2.80.33/canciella/';

  $url = $_GET['url'];
  $url = strpos($url, 'http://') !== false ? $url : 'http://' . $url;
  
  libxml_use_internal_errors(true);
  $site = file_get_contents($url, false);
  
  $site = DOMDocument::loadHTMLFile($url);

  $tags = array(
    'link'   => 'href',
    'script' => 'src',
    'a'      => 'href',
    'img'    => 'src',
  );

  function appendProxy($value, $full = false) {
      global $url, $base_url;
      $value = $full ? $value : $url . $value;
      return  "$base_url?url=$value";
  }
   array_walk($tags, function($attributeName, $tagName) use ($site){
     $t = $site->getElementsByTagName ($tagName);
     foreach($t as $element) {
       $attr = $element->getAttribute($attributeName);
         $element->setAttribute($attributeName, appendProxy($attr, strpos($attr, 'http') === 0));
         $attr = $element->getAttribute($attributeName);
    };
   });
  echo $site->saveHTML();;
