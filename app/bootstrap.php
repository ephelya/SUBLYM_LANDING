<?php
//error_reporting (E_ALL ^ E_NOTICE);

use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

// Load config
$development = false;
require_once __DIR__ . '/config.php';

// Create app
$app = AppFactory::create();

/**
 * The routing middleware should be added earlier than the ErrorMiddleware
 * Otherwise exceptions thrown from it will not be handled by the middleware
 * @url https://www.slimframework.com/docs/v4/
 */
$app->addRoutingMiddleware();

/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware($development, $development, $development);

// Create Twig
if ($development) {
    $twigOptions = ['cache' => false];
} else {
    $twigOptions = ['cache' => __DIR__ . '/../cache'];
}
$twig = Twig::create(__DIR__ . '/views', $twigOptions);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));


// Load our routes
require_once __DIR__ . '/routes.php';

$app->run();
