<?php
namespace Models;

class Admin {
    
    public static function db()
    {
        $db = "../app/config.php";
        include($db);
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
                $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
                $pdo = new \PDO($dsn, $user, $pass);
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                return $pdo;
        }
            catch (\PDOException $e) {
                // Gérez les erreurs de connexion ici
                error_log ('Erreur de connexion à la base de données : ' . $e->getMessage());
                return null;
            }
    }

    public static  function envoyerEmail($destinataire, $nomDestinataire, $sujet, $message, $expediteur = 'noreply@votredomaine.com', $nomExpediteur = 'Nom par défaut') {
        // En-têtes
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ' . $nomExpediteur . ' <' . $expediteur . '>' . "\r\n";

        // Envoi de l'email
        if(mail($nomDestinataire . ' <' . $destinataire . '>', $sujet, $message, $headers)) {
            return true;
        } else {
            return false;
        }

    }

    public static function navigation_links()
    {
       
        $array = [
            [  "id" => "accueil",  "label" => "Accueil" ,  "url"=> HOME ] ,
            [ "id" => "contacts" , "label" => "Contacts" ,  "url"=> HOME."contacts"  ],
            [ "id" => "finances" ,  "label" => "Finances" ,  "url"=> HOME."finances"  ],
            ["id" => "projets" , "label" => "Projets" ,  "url"=> HOME ."projets" ]
        ];
        
        return $array;
    }


    #       DATES       #
    public static function getdate($day, $format, $lang)
    {   
        date_default_timezone_set('Europe/Paris');
        setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr', 'fra', 'french');
       // echo "time ".date('d F Y');
        
        $date = new \DateTime($day);
    
        $formatter = new \IntlDateFormatter(
            'fr_FR',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::NONE,
            'Europe/Paris',
            \IntlDateFormatter::GREGORIAN,
            $format  // Utilisez le format ici
        );
    
        // Formattez et affichez la date
        $formattedDate = $formatter->format($date);
       // echo "date formatée: $format $formattedDate";
    
        return $formattedDate;
    }
    
    public static function getweekdate($date)
    {
        // Trouver le lundi de cette semaine
        $monday = clone $date;
        $monday->modify('Monday this week');
        $mondayString = $monday->format('d/m');

        // Trouver le vendredi de cette semaine
        $friday = clone $monday;
        $friday->modify('Friday this week');
        $fridayString = $friday->format('d/m');

        // Obtenir le numéro de la semaine
        $weekNumber = $date->format('W');

        // Formatter la chaîne de sortie
        $output["week"] = "Lun $mondayString - Ven $fridayString";
        $output["weeknb"] = $weekNumber;
        return $output;
    }

}