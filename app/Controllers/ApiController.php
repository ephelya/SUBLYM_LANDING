<?php
namespace Controllers;

use \Models\Membres;
use \Models\Admin;
use \Utils\Api;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ApiController {
    public static function getApi($api, $keys) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            // Récupérer le corps de la requête et le décoder
            $inputJSON = file_get_contents('php://input');
            echo $inputJSON; exit();
            $input = json_decode($inputJSON, true); // Convertit en tableau associatif

            // Récupérer les valeurs de 'key' et 'api'
            $keyValue = $input['key'];
            $apiValue = $input['api'];


            // Traitement en fonction des valeurs récupérées
            if(($apiValue)&&($apiValue="csv"))
            {
               $result = self::getCSV($keys);
            }
            else if(($apiValue)&&($keyValue="api"))
            {
                $_SESSION[$apiValue] = strtolower($keyValue);
                $result = array('success' => true, 'message' => "Session $apiValue set to $keyValue");
            }
           
            // Envoyer la réponse en JSON
            echo json_encode($result);
        }
        else // methode get ou autre, l'api est définie en fonction public statique dans Utils/Api.php

        {
            $api = \Utils\Api::$api($keys); 
            return ($api);
        }
}

    public static function get_accounts()
    {
        $get_accounts_api = \Utils\get_accounts;
      //  echo "toupi";
    }
    public function getCSV($type) {
        // Envoyer la réponse en JSON
       // $result = ("on cre le csv $type");
        $data = json_decode(file_get_contents('php://input'), true);
        $tableName = $data['tableName'];
        $filePath = 'UPLOADS/CSV/' . $tableName . '_CSV.csv';        
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Pragma: no-cache');
        // Récupérez le nom de la table à partir de la requête AJAX


        $pdo = \Models\Admin::db();
        try {
            // Récupérer les noms de colonnes de la table
            $stmt = $pdo->query("DESCRIBE $tableName");
            $columns = $stmt->fetchAll(\PDO::FETCH_COLUMN);

            //echo json_encode( $columns); exit();

            // Chemin du fichier CSV à créer
            $path = "../UPLOADS/CSV/";
            $filePath = $path.$tableName."_csv.csv";


            // Créer le fichier CSV
            $file = fopen($filePath, 'w');
            fputcsv($file, $columns);
            fclose($file);

            // Retourner le fichier CSV

            readfile($filePath);
        } catch(\PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Erreur : ' . $e->getMessage()]);
            exit();
        }
        

    }

    public function addSession() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['mode'])) {
                $_SESSION['mode'] = $_POST['mode'];
                echo "Mode de session mis à jour : " . $_SESSION['mode'];
            } else {
                echo "Erreur : Mode non spécifié.";
            }
        } else {
            echo "Erreur : Requête non autorisée.";
        }
    }
}
