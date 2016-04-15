<?php

namespace Canciella;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/utilHTTP.php';

error_reporting(E_ALL);

$environment = 'development';

$whoops = new \Whoops\Run;
if ($environment !== 'production') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler(function($e){
        echo 'An error ocurred. Mail sent to developer.';
        mail('antonio.sanchez@inia.es', 'Error canciella', $e);
    });
}
$whoops->register();

$base_url = 'http://canciella.net/';

$request = new \Http\HttpRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
$response = new \Http\HttpResponse;

$dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', function() {
        return ['Welcome to canciella proxy', ['content-type' => 'text/html']];
    });
    $r->addRoute('GET', '/{url:.+}', function($url) {
        return proxy($url);
    });
});

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());
switch($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        $content = '404 error';
        $header = ['content-type' => 'none'];
        $response->setStatusCode(404);
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $content = '405 error';
        $header = ['content-type' => 'none'];
        $response->setStatusCode(405);
        break;
    case \FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($content, $content_type) = call_user_func_array($handler, $vars);
        break;
    default:
        $content = 'hola';
        $content_type = 'text/html';
        break;
}

function proxy($uri)
{
global $base_url;

$url = ltrim($uri, '/');
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
    $dom = new \DOMDocument();
    $dom->loadHTML($site_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    $tags = array(
        'link'   => 'href',
        'script' => 'src',
        'a'      => 'href',
        'img'    => 'src',
        'meta'   => 'url',
    );

    function appendProxy($href, $base_url, $url)  
    {
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
                $folder = strrpos($parsed_url['path'], '/') ? 
                    substr($parsed_url['path'], 0, strrpos($parsed_url['path'], '/')) : 
                    $parsed_url['path'];
            } else {
                $folder = "/";
            }
          
            if (strpos($href, "/") === 0) {
                // absolute address in this domain
                return "$base_url$base" . ltrim($href, "/");
            } else {
                // relative address in this domain
                return "$base_url$base$folder/$href";
            }
        }
    }

    array_walk(
        $tags, function($attributeName, $tagName) use ($dom, $base_url, $url) {
            $t = $dom->getElementsByTagName ($tagName);
            foreach($t as $element) {
                $attr = $element->getAttribute($attributeName);
                if (!empty($attr)) {
                    $element->setAttribute($attributeName, appendProxy($attr, $base_url, $url));
                    $element->setAttribute('data-canciella', 'modified');
                }
            };
        }
    );

    $body = $dom->getElementsByTagName('body')->item(0);
    $script_template = file_get_contents(__DIR__ . '/../templates/canciella.js');
    $script_code = str_replace("{{base_url}}", $base_url, $script_template);
    $script_code = str_replace("{{url}}", $url, $script_code);
    $script = $dom->createElement('script', $script_code);
    $script->setAttribute('type', 'application/javascript');
    $script->setAttribute('data-canciella', 'new');
    $body->appendChild($script);
    $output = $dom->saveHTML();
}
if ($mime_type) {
    return [$output, $mime_type['full-type']];
} else {
    return [$output, 'none'];
}
}
$response->addHeader('Content-type', $content_type);
$response->setContent($content);

foreach ($response->getHeaders() as $h) {
    header($h, false);
}
echo $response->getContent();
