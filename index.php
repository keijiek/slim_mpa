<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpForbiddenException;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(false, true, true);


$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write('<a href="/second">Hello world!</a><br /><a href="/classes/">classes</a><br /><a href="/classes/Vite_Manifest_Production.class.php">classes/script</a>');
  return $response;
});

$app->get('/second', function (Request $request, Response $response, $args) {
  $response->getBody()->write('<a href="/">This is Second Page</a>');
  return $response;
});

// カスタムエラーハンドラー
// $errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (Request $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails) use ($app) {
//   $response = $app->getResponseFactory()->createResponse();
//   $response->getBody()->write(file_get_contents(__DIR__ . '/html/error.php'));
//   return $response->withStatus(404);
// });

// $errorMiddleware->setErrorHandler(HttpForbiddenException::class, function (Request $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails) use ($app) {
//   $response = $app->getResponseFactory()->createResponse();
//   $response->getBody()->write(file_get_contents(__DIR__ . '/html/error.php'));
//   return $response->withStatus(403);
// });

$app->run();
