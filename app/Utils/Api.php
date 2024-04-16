<?php 
namespace Utils;

require_once("../buxfer_api.php"); // Assurez-vous que le chemin d'accès est correct

class Api {
    private static $username = "nathalie.brigitte@gmail.com"; // Défini comme propriété statique de la classe
    private static $password = "Zorbec_24"; // Défini comme propriété statique de la classe
    private static $base = "https://www.buxfer.com/api"; // Défini ici ou dans buxfer_api.php

    public static function get_accounts()
    {
        $token = getApiToken(self::$username, self::$password); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        $url = self::$base."/accounts?token=$token";
    
        $response = makeApiRequest($url, $token); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        print_r($response);
        return $response['accounts'];
    }

    public static function get_transactions()
    {
        $token = getApiToken(self::$username, self::$password); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        $url = self::$base."/transactions?token=$token";
        $response = makeApiRequest($url, $token); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        //print_r($response);
        return $response['transactions']; 
        //tableau de transactions (id, descripion, date, type, transactionTyppe, amount,accountId ,accountName, tagNames(array), status  )
    }

    public static function get_tags()
    {
        $token = getApiToken(self::$username, self::$password); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        $url = self::$base."/tags?token=$token";
        $response = makeApiRequest($url, $token); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        //print_r($response);
        return $response['tags']; 
        //tableau de transactions (id, descripion, date, type, transactionTyppe, amount,accountId ,accountName, tagNames(array), status  )
    }

    public static function get_budgets()
    {
        $token = getApiToken(self::$username, self::$password); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        $url = self::$base."/budgets?token=$token";
        $response = makeApiRequest($url, $token); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        print_r($response);
        return $response['budgets']; 
        //tableau de transactions (id, descripion, date, type, transactionTyppe, amount,accountId ,accountName, tagNames(array), status  )
    }

    public static function get_loans()
    {
        $token = getApiToken(self::$username, self::$password); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        $url = self::$base."/loans?token=$token";
        $response = makeApiRequest($url, $token); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        //print_r($response);
        return $response['loans']; 
    }

    public static function get_contacts()
    {
        $token = getApiToken(self::$username, self::$password); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        $url = self::$base."/contacts?token=$token";
        $response = makeApiRequest($url, $token); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        //print_r($response);
        return $response['contacts']; 
    }

    public static function get_groups()
    {
        $token = getApiToken(self::$username, self::$password); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        $url = self::$base."/groups?token=$token";
        $response = makeApiRequest($url, $token); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        //print_r($response);
        return $response['groups']; 
    }

    public static function get_reminders()
    {
        $token = getApiToken(self::$username, self::$password); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        $url = self::$base."/reminders?token=$token";
        $response = makeApiRequest($url, $token); // Assurez-vous que cette fonction est définie dans buxfer_api.php
        print_r($response);
        return $response['reminders']; 
    }

    public static function add_transaction($keys)
    {
        // Récupération du token
        $token = getApiToken(self::$username, self::$password);

        // Préparation de l'URL pour l'ajout de la transaction
        $url = self::$base . "/transaction_add";
        foreach($keys as $key => $val) { $$key = $val;}
        // Préparation des données de la transaction
        $postData = array(
            'description' => 'Virement test',
            'amount' => $amount,
            'type' => "transfer",
            'fromAccountId' => $from,
            'toAccountId' => $to
        );

        // Appel de la fonction makeApiRequest pour exécuter la requête POST
        $response = self::makeApiRequest($url, $token, $postData, 'POST');
        // Vérification de la réponse
        if (!$response || isset($response['error'])) {
            // Gestion de l'erreur si la réponse est null ou contient une erreur
            echo "Erreur lors de l'ajout de la transaction. Réponse : ";
            //print_r($response);
        } else {
            // Traitement de la réponse réussie
            echo "Transaction ajoutée avec succès. Réponse : ";
            //print_r($response);
        }

        return $response;
    }

    public static function makeApiRequest($url, $token, $data = null, $method = 'GET') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url . "?token=$token");
    
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
    
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
    
        if (curl_error($ch)) {
            return ['error' => curl_error($ch)];
        }
    
        checkError($response);
    
        return $response;
    }

    public static function suggest_api()
    {
        // Récupérer la requête de l'utilisateur
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Obtenir les suggestions de tags basées sur la recherche de l'utilisateur
        $suggestions = \Models\Tags::searchTags($search);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($suggestions);
    }

    public static function get_tags_by_type() {
        header('Content-Type: application/json; charset=utf-8');
        $typeNames = isset($_GET['typeNames']) ? $_GET['typeNames'] : '';
        $tagslist = \Models\Tags::getTagsByType($typeNames);
        echo json_encode($tagslist);  
        exit();
    }


        public static function searchDataByTag_api() {
            header('Content-Type: application/json; charset=utf-8');
            $tag = isset($_GET['tags']) ? $_GET['tags'] : '';
            $organizedResults = \Models\Datas::searchDataByTag($tag);
            echo json_encode($organizedResults);    
        }

        public static function getTagTypeDefinitions()
        {
            header('Content-Type: application/json; charset=utf-8');
            $tagTypes = \Models\Tags::getTagTypeDefinitions();
            echo json_encode($tagTypes);
        }

        public static function getTagSuggestions()
        {
            header('Content-Type: application/json; charset=utf-8');
            $existingTags = isset($_GET['existingTags']) ? $_GET['existingTags'] : '';
            $tagsList = \Models\Tags::getTagSuggestions($existingTags);
            echo json_encode($tagsList);
        }

        public static function addNewTag()
        {
            header('Content-Type: application/json; charset=utf-8');

            $tagName = isset($_GET['tagName']) ? $_GET['tagName'] : '';
            $tagType = isset($_GET['tagType']) ? $_GET['tagType'] : '';
            $isType = isset($_GET['isType']) ? $_GET['isType'] : '';
            $classifier = isset($_GET['isClassifier']) ? $_GET['isClassifier'] : '';

            $addtag = \Models\Tags::addTag($tagName, $tagType, $classifier, $isType);
            echo json_encode($addtag);
        }




        function getTagTypes_api()
        {
            header('Content-Type: application/json; charset=utf-8');
            $typeTags = \Models\Tags::getTagTypes();
            echo json_encode($typeTags);
        }


}
