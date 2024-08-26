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
  $html = (new FrontPageController())->html();
  $response->getBody()->write($html);
  return $response;
});

$app->get('/second', function (Request $request, Response $response, $args) {
  ob_start();
  require_once(__DIR__ . '/html/second-page.php');
  $html = ob_get_clean();
  $response->getBody()->write($html);
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
