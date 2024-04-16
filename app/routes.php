<?php
session_start();
//print_r($_SESSION);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

require_once __DIR__ . '/../vendor/autoload.php'; // Chemin vers le fichier autoload de Composer
//echo $twig->getLoader()->getPaths()[0]; // Affiche le chemin de base configuré dans Twig



// Fonction pour rendre une page avec des données
function renderPage(Request $request, Response $response, $args, $twig, $pageData) {
    //print_r($_SESSION);
    $page = $pageData["page"];
    $baseData = \Models\Pages::baseData($page); 
    $combinedData = array_merge($baseData, $pageData);
    //echo " routes ";
   //print_r($combinedData);
    $model =  $combinedData["twig"]; 
    return $twig->render($response,  $model, $combinedData);
}


// Route pour la page d'accueil
$app->get('/', function (Request $request, Response $response, $args) use ($twig) {
    $homeController = new \Controllers\HomeController();
    $pageData = $homeController->getHomePageData();// 
    //print_r($pageData);

    return renderPage($request, $response, $args, $twig, $pageData);
});


// Routes génériques pour l'api
$app->post('/api/{api}', function (Request $request, Response $response, $args) use ($twig) {

    $api = $args['api']; 
    $api = new \Controllers\ApiController;
    $api = $api -> getApi("api", $api);
    return $response;
  
});

$app->get('/api/{api}', function (Request $request, Response $response, $args) use ($twig) {
    $api_value = $args['api']; 
    $keys = isset($_GET['keys']) ? $_GET['keys'] : '';
    $api = new \Controllers\ApiController;
    $api = $api -> getApi($api_value, $keys);
    return $response;
});






// Route générique pour les autres pages
$app->get('/{page}', function (Request $request, Response $response, $args) use ($twig) {
    $pageIdent = $args['page'];
    $page = ucfirst($pageIdent) . "Controller";
    $controllerClass = "\\Controllers\\" . $page;

    if (class_exists($controllerClass)) {
        //echo "ok $controllerClass";
        $controller = new $controllerClass();
        if (method_exists($controller, 'getPageData')) {
            $pageData = $controller->getPageData($pageIdent);
            $otherData = $controller->getPageData("page");
            foreach ($otherData as $key => $value) {
                $pageData[$key] = $value;
            }
            $pageData["page"] = $pageIdent;
            return renderPage($request, $response, $args, $twig, $pageData);
        } else {
            throw new HttpNotFoundException($request, "Méthode getPageData non trouvée pour le contrôleur " . $controllerClass);
        }
    } elseif (class_exists('\\Controllers\\PageController')) {
        //echo "nok $controllerClass";

        $controller = new \Controllers\PageController();
        if (method_exists($controller, 'getPageData')) {
            $pageData = $controller->getPageData($page);
            $otherData = $controller->getPageData($pageIdent);
            foreach ($otherData as $key => $value) {
                $pageData[$key] = $value;
            }
            $pageData["page"] = $pageIdent;
            return renderPage($request, $response, $args, $twig, $pageData);
        } else {
            throw new HttpNotFoundException($request, "Méthode getPageData non trouvée pour le contrôleur PageController");
        }
    } else {
        throw new HttpNotFoundException($request, "Contrôleur " . $controllerClass . " non trouvé");
    }
});


// ... Vos autres routes spécifiques ...

// Route pour gérer les URL non trouvées
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});
