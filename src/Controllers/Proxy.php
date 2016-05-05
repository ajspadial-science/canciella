<?php

namespace Canciella\Controllers;

class Proxy {
    
    private $dom;

    public static $linkable_tags = array(
        'link'   => 'href',
        'script' => 'src',
        'a'      => 'href',
        'img'    => 'src',
        'meta'   => 'url',
        'iframe' => 'src',
        'form' => 'action',
    );

    public function appendProxy($href, $base_url, $url)
    {
        $parsed_href = parse_url($href);
        $href = urldecode($href);
        
        if (strpos($href, '//') === 0) {
            return "{$base_url}http:$href";
        }
        if (isset($parsed_href['scheme']) && isset($parsed_href['host'])) {
            // full html address
            return "$base_url$href";
        } else {
            $parsed_url = parse_url($url);
            $scheme = $parsed_url['scheme'] . "://";
            $host = $parsed_url['host'];
            $port = isset($parsed_url['port']) ? ":" . $parsed_url['port'] : "";
            $base = "$scheme$host$port/";
        
            if (isset($parsed_url['path'])) {
                $folder = strrpos($parsed_url['path'], '/') ? 
                    substr($parsed_url['path'], 1, strrpos($parsed_url['path'], '/')) : 
                    $parsed_url['path'];
            } else {
                $folder = "/";
            }
                  
            if (strpos($href, "/") === 0) {
                // absolute address in this domain
                return "$base_url$base" . ltrim($href, "/");
            } else {
                // relative address in this domain
                return "$base_url$base$folder$href";
            }
        }
    }
    
    public function processUri($uri, $base_url)
    {
        $url = ltrim($uri, '/');
        $url = strpos($url, 'http://') !== false ? $url : 'http://' . $url;
        
        libxml_use_internal_errors(true);
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $site_content = curl_exec($curl);
        $content_type = trim(curl_getinfo($curl, CURLINFO_CONTENT_TYPE));
        curl_close($curl);
        
        $output = $site_content;
        $mime_type = !$content_type ? null : \Canciella\utilHTTP::parseMIME($content_type);
        if ($mime_type && $mime_type['full-type'] === 'text/html') {
            $this->initDOM($site_content);
            $this->linkableElements_walk(
                function($element, $attributeName, $attribute) use ($base_url, $url) {
                    if (!empty($attribute)) {
                        $element->setAttribute($attributeName, $this->appendProxy($attribute, $base_url, $url));
                        $element->setAttribute('data-canciella', 'modified');
                    }
                }
            );

            $body = $this->dom->getElementsByTagName('body')->item(0);
            $script_template = file_get_contents(__DIR__ . '/../../templates/canciella.js');
            $script_code = str_replace("{{base_url}}", $base_url, $script_template);
            $script_code = str_replace("{{url}}", $url, $script_code);
            $script = $this->dom->createElement('script', $script_code);
            $script->setAttribute('type', 'application/javascript');
            $script->setAttribute('data-canciella', 'new');
            $body->appendChild($script);
            $output = $this->dom->saveHTML();
        }
        if ($mime_type) {
            return [$output, $mime_type['full-type']];
        } else {
            return [$output, 'none'];
        }
    }

    public function initDOM($content)
    {
        $this->dom = new \DOMDocument();
        $this->dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    }

    public function linkableElements_walk($fn)
    {
        $linkable_elements = $this->getLinkableElements();
        foreach ($linkable_elements as $l) {
            $attr_name = self::$linkable_tags[$l->tagName];
            $attr = $l->getAttribute($attr_name);
            $fn($l, $attr_name, $attr);
        }
    }

    private function getLinkableElements()
    {
        $linkable_elements = [];
        foreach (self::$linkable_tags as $tag_name => $linkName) {
            $elements = $this->dom->getelementsByTagName($tag_name);
            foreach ($elements as $e) {
                yield $e;
            }
        }
    }
}
