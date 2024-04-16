<?php
namespace Controllers;

use \Models\Pages;
use \Models\Sublym_Membres;
use \Models\Membres;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController {

    public function getHomePageData() {
        $user = \Models\Sublym_Membres::getUser($_SESSION["userId"]);
        $pageData["page"] = "accueil";
        $pageData["hometwig"] = \Models\Pages::home_content();
        $pageData["twig"] = "home_content.twig";
        $pageData["test"] = $user -> getAvatarParams($user -> idMembre);
        $pageData["button_subsc"]= "Abonnements";
        $pageData["button_more"]= "En savoir plus";
        $pageData["accroche1"] = "Vous n'avez plus d'excuse pour ne pas avoir déjà manifesté vos désirs.";
        $pageData["accroche2"] = "<span class='bot'>Anna : </span> Quel est le rêve que vous regretterez le plus de ne pas avoir réalisé ?";

        $botFilePath= APPDIR . "/views/bot.twig";
        $botExists = file_exists($botFilePath); //if ($botExists) { echo "tw "; } else {echo "no";}
        $chatbot = $botExists ? "bot.twig" : "chatbot.twig";
        $pageData["chatbot"] = $chatbot;


        return ($pageData);
    }
}
