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
}

$response->addHeader('Content-type', $content_type);
$response->setContent($content);

foreach ($response->getHeaders() as $h) {
    header($h, false);
}
echo $response->getContent();
