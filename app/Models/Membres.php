<?php
namespace Models;
use \Models\Admin;
use Models\Membres as ModelsMembres;
use Utils\Forms;

class Membres {
    public $idMembre;
    public $dreams;
    public $sentences;
    public $profile_photos;
    public $portfolio;
    public $details;
    public $creas;
    public $orders;
    public $active;
    public $prenom;

    public $identifiant;
    public $dnaiss;
    public $nom;
    public $user_email;
    public $user_registered;
    public $keyvalid;
    public $siret;
    public $sexe;
    public $taille;
    public $corpulence;
    public $nationalite;


    public function __construct($data) {
       //print_r($data);
        if  ((!is_object($data))&&(!is_array($data)))
        {  
           // echo "noobject Membres.php";
            $id = $data;  
        }
        else 
        {
           // echo "isobject Membres.php";
            foreach ($data as $key => $value) {//on envie un membre
                $this->$key = $value;
            }
            $id = $data -> idMembre;
        }
        $this -> profile_photos =  $this -> getUserPhotos($id)["profile_photos"];
       
/*         $this -> profile_photos =  $this -> getUserPhotos($id)["profile_photos"];
        $this -> portfolio =  $this -> getUserPhotos($id)["portfolio"];
        $this -> details =  $this -> getUserPhotos($id)["details"];
        $this -> creas =  $this -> getUserPhotos($id)["creas"];
        $this -> orders =  $this -> getUserOrders($id);
        $this -> sentences = $this -> getSentences ($id);
        $this -> dreams = $this ->  getUserDreams ($id); */
    }

    public static function getUser_Confirm($keyvalid)
    { //echo "session ".$_SESSION['userId'];
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM Membres WHERE keyvalid = $keyvalid"; //echo $query;
        $stmt = $pdo->prepare('SELECT * FROM Membres WHERE keyvalid = :keyvalid');
        $stmt->bindParam(':keyvalid', $keyvalid, \PDO::PARAM_INT);
        $stmt->execute();
        $user = new Membres($stmt->fetch(\PDO::FETCH_OBJ)); //print_r($user);
        if (!empty($user))  {return $user;} else { return false; }
    }

    public static function getUser($userId)
    { //echo "session ".$_SESSION['userId'];
        if ((empty($userId)||(!isset($userId))))
        {  
            if ((!isset($_SESSION["userId"]))||($_SESSION["userId"]==''||($_SESSION["userId"]==0)) )
            { return false; }
            else 
            { $userId = $_SESSION["userId"]; }
        }  
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM Membres WHERE idMembre = $userId"; //echo $query;
        $stmt = $pdo->prepare('SELECT * FROM Membres WHERE idMembre = :userId');
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        if (empty(self::getPhotosByUserId($userId)))
       { $user = new Membres($result);}
       else { $user = new Sublym_Membres($result);} //print_r($user);
        if (!empty($user))  {return $user;} else { return false; }
    }

    public function getUserPhotos ($userId)
    {
        $Userphotos = array (
            "profile_photos" => self::getPhotosByUserId($userId), //photos de profil du membre
            "details" => array(), //précisions apportées par le membre pour ses rêves
            "creas"  => array(), // photos créées pour le membre (active ou non)
            "portfolio"  => array(), //photos ajoutées pour construire le rêve
        );
        return $Userphotos;
    }

    public static function getPhotosUser() {
        $photosformConfig = [
            'formId'   =>  'form_userCapture',
            "capture" => 1,
            'method' => "enctype",
            'size' => "large",
            'float' => 1,
            'label' => "down",
            'trait' => "#",
            'fields' => [
                ["id" => "valid_userCapture", 'name' => "valid_userCapture", 'type' => 'hidden'],
                ["id" => "faceCap", 'name' => "faceCap", 'type' => 'text', 'data-instructions' => "1/4 Prenez une photo de face", 'hidden' => 1],
                ["id" => "profilCap", 'name' => "profilCap", 'type' => 'text', 'data-instructions' => "2/4 Prenez une photo de profil", 'hidden' => 1],
                ["id" => "upCap", 'name' => "upCap", 'type' => 'text', 'data-instructions' => "3/4 Prenez une photo tête vers le bas (plongée)",'hidden' => 1],
                ["id" => "dwnCap", 'name' => "dwnCap", 'type' => 'text', 'data-instructions' => "4/4 Prenez une photo tête vers le haut (contre-plongée)", 'hidden' => 1],
                ['label' => 'Photo de face', "id" => "faceUp", 'name' => "faceUp", 'type' => 'file', "required" => 0],
                ['label' => 'Photo de profil', "id" => "profilUp", 'name' => "profilUp", 'type' => 'file', "required" => 0],
                ['label' => 'Photo en plongée (tête tournée vers le bas)', "id" => "upUp", 'name' => "upUp", 'type' => 'file', "required" => 0],
                ['label' => 'Photo en contre-plongée (tête tournée vers haut)', "id" => "dwnUp", 'name' => "dwnUp", 'type' => 'file', "required" => 0],
               ["value" => "Prev", 'class' => 'prev',  'data' =>'data-action =\'prev\'', 'type' => 'submit'],
               ["value" => "Suivant", 'class' => 'next', 'data' =>'data-action =\'next\'', 'type' => 'submit', 'disabled'],           
            ]
        ];

        return Forms::generateForm($photosformConfig);
    }


    public static  function getPhotoUpload() {
        //print_r($_SESSION);
        //print_r($this -> dreamsTitles);
            $formconfig = [
                'formId'   =>  "form_photoCapture",
                'method' => "enctype",
                'size' => "large",
                'float' => 1,
                'label' => "down",
                'trait' => "#",
                'fields' => [
                    ['label' => 'Photo de référence (facultatif)', "id" => "photoass", 'name' => "photoass", 'type' => 'file', "required" => 0],
                    ["value" => "Prev", 'class' => 'prev',  'data' =>'data-action =\'prev\'', 'type' => 'submit'],
                    ["value" => "Ajouter", 'class' => 'validdreamsdetails', 'data' =>'data-action =\'next\'', 'type' => 'submit'],
                ]
            ];
    
            return Forms::generateForm($formconfig);
    }

    public static function getPhotosByUserId($userId)
    {
        $pdo = \Models\Admin::db();  // Utiliser la fonction db() pour obtenir l'objet PDO
        try {
            // Préparer la requête SQL pour sélectionner les photos
            $stmt = $pdo->prepare("SELECT * FROM PhotosMembres WHERE userId = ? AND `status` = 'prop'");
            $stmt->execute([$userId]);

            // Récupérer toutes les lignes retournées par la requête
            $photos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if ($photos) {
                return $photos; // Retourner les données des photos si trouvées
            } 
        } catch (\PDOException $e) {
            echo "Erreur : " . $e->getMessage(); // Affiche l'erreur en cas d'échec
            return false; // Retourner false en cas d'erreur
        }
    }

    public static function isactive()
    {
        $member = self::getUser(''); //print_r($member);
        if (($member)&&($member -> active ==1  )) { return true; } else { return false; }
    }

    public function memberActive()
    {
        $pdo = \Models\Admin::db();
        $userid = $this -> idMembre ;
        $stmt = $pdo->prepare("UPDATE Membres SET `active` = 1 WHERE idMembre= :userid");
        $stmt->bindParam(':userid', $userid, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function sendmail($mail)
    {
        $destinataire = $this -> user_email; 
        $nomDestinataire =  $this -> identifiant; 
        switch($mail)
        {
            case "welcome":
                $sujet = "sujet du mail (MMembres)";
                $message = "mess";
            break;
        }
        \Models\Admin::envoyerEmail($destinataire, $nomDestinataire, $sujet, $message, $expediteur = 'noreply@votredomaine.com', $nomExpediteur = 'Sublym Attraction');
    }

    public static function add_member($data) {
        $pdo = \Models\Admin::db();
        $errors = [];
    
        // Vérification combinée de l'email et de l'identifiant
        $stmtAccount = $pdo->prepare("SELECT COUNT(*) FROM Membres WHERE user_email = :user_email AND identifiant = :identifiant");
        $stmtAccount->bindParam(':user_email', $data['user_email']);
        $stmtAccount->bindParam(':identifiant', $data['identifiant']);
        $stmtAccount->execute();
        if ($stmtAccount->fetchColumn() > 0) {
            $errors["dbl_account"] = "Ce compte est déjà enregistré, vous pouvez connecter. <a href=''>Mot de pase oublié ?</a>";
        }
    
        // Vérification de l'email
        $stmtEmail = $pdo->prepare("SELECT COUNT(*) FROM Membres WHERE user_email = :user_email");
        $stmtEmail->bindParam(':user_email', $data['user_email']);
        $stmtEmail->execute();
        if ($stmtEmail->fetchColumn() > 0) {
            $errors["dbl_email"] = "Cette adresse e-mail est déjà présente dans la base de données, vous pouvez connecter. <br>
            Vous avez perdu votre identifiant ou votre mot de passe ?<a href=''>Cliquez ici</a> pour créer un nouveau mot de passe</a>";
        }
    
        // Vérification de l'identifiant
        $stmtIdentifiant = $pdo->prepare("SELECT COUNT(*) FROM Membres WHERE identifiant = :identifiant");
        $stmtIdentifiant->bindParam(':identifiant', $data['identifiant']);
        $stmtIdentifiant->execute();
        if ($stmtIdentifiant->fetchColumn() > 0) {
            $errors["dbl_login"] = "Cet identifiant est déjà utilisé, merci d'en choisir un autre.";
        }
    
        // Si des erreurs ont été détectées, retournez-les
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
    
        // Insertion des données dans la base de données
        $sql = "INSERT INTO Membres (identifiant, prenom, nom, user_email, user_registered, keyvalid) 
                VALUES (:identifiant, :prenom, :nom, :user_email, :user_registered, :keyvalid)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':identifiant', $data['identifiant']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':user_email', $data['user_email']);
        $stmt->bindParam(':user_registered', $data['user_registered']);
        $stmt->bindParam(':keyvalid', $data['keyvalid']);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => "Inscription réussie!"];
        } else {
            // Log de l'erreur pour le débogage
            $error = $stmt->errorInfo();
            error_log("Erreur d'insertion PDO : " . $error[2]);
            return ['success' => false, 'message' => "Erreur lors de l'inscription."];
        }
    }
    

    public static function nationalite()
    {
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM `Caracs_nationalite`  ORDER BY main DESC, valeur ASC";  
        $stmt = $pdo->prepare($query);  // Utiliser la variable $table pour la table
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);  // Retourner les résultats
    }

    public static function taille()
    {
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM `Caracs_taille`  ORDER BY id DESC";  
        $stmt = $pdo->prepare($query);  // Utiliser la variable $table pour la table
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);  // Retourner les résultats
    }


    public static function corpulence()
    {
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM `Caracs_corpulence`  ORDER BY id ASC";  
        $stmt = $pdo->prepare($query);  // Utiliser la variable $table pour la table
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);  // Retourner les résultats
    }
    
    public static function lunettes()
    {
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM `Caracs_lunettes`  ORDER BY id ASC";  
        $stmt = $pdo->prepare($query);  // Utiliser la variable $table pour la table
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);  // Retourner les résultats
    }

    public static function hairlong()
    {
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM `Caracs_longueur_cheveux`  ORDER BY id ASC";  
        $stmt = $pdo->prepare($query);  // Utiliser la variable $table pour la table
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);  // Retourner les résultats
    }

    public static function eyecolor()
    {
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM `Caracs_couleur_yeux`  ORDER BY id ASC";  
        $stmt = $pdo->prepare($query);  // Utiliser la variable $table pour la table
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);  // Retourner les résultats
    }

    public static function haircolor()
    {
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM `Caracs_couleur_cheveux`  ORDER BY id ASC";  
        $stmt = $pdo->prepare($query);  // Utiliser la variable $table pour la table
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);  // Retourner les résultats
    }

    public static function skincolor()
    {
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM `Caracs_couleur_peau`  ORDER BY id ASC";  
        $stmt = $pdo->prepare($query);  // Utiliser la variable $table pour la table
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);  // Retourner les résultats
    }
    
    public static function hairtype()
    {
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM `Caracs_type_cheveux`  ORDER BY id ASC";  
        $stmt = $pdo->prepare($query);  // Utiliser la variable $table pour la table
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);  // Retourner les résultats
    }

    public static function beard()
    {
        $pdo = \Models\Admin::db();
        $query = "SELECT * FROM `Caracs_barbe_moustache`  ORDER BY id ASC";  
        $stmt = $pdo->prepare($query);  // Utiliser la variable $table pour la table
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);  // Retourner les résultats
    }
    
    



    public static function getMemberbyToken($token) {
        $pdo = \Models\Admin::db();
        $stmt = $pdo->prepare('SELECT * FROM Membres WHERE keyvalid = :token');
        $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        
        if ($data) {
            $membre = new Membres($data);
            $_SESSION["userId"] =  $membre -> idMembre;
            $_SESSION["login"] =  $membre -> identifiant;
            return $membre;
        } else {
            return false;
        }
    }
    

    public function isMember ($userId)
    {
        $ismember = false; 
        if ((empty($userId)||(!isset($userId))))
        {  
            if ((!isset($_SESSION["userId"]))||($_SESSION["userId"]==''||($_SESSION["userId"]==0)) )
            { return false; } else { $userId = $_SESSION['userId']; $user = self::getUser($userId); }

        } 
        if ($userId) { $member = $user;  }
        return $ismember;
    }
    
    public function getSentences ($userId)
    {
        $sentences = array();
        return $sentences;
    }
    

    public function getUserOrders ($userId)
    {
        $orders = array();
        return $orders;
    }

    public static function getAvatarParams($userId) 
    {
        $pdo = \Models\Admin::db();
    
        // Préparer la requête SQL pour obtenir les paramètres associés à l'ID de l'abonnement de l'utilisateur
        $sql = "SELECT d.param, d.value 
                FROM AvatarAboParams d
                JOIN MembresAbo ma ON d.SubscrId = ma.aboId
                WHERE ma.membreId = :userId";
    
        // Préparer la déclaration SQL
        $stmt = $pdo->prepare($sql);  
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_STR);
        $stmt->execute();
        $avatar = $stmt->fetchAll(\PDO::FETCH_ASSOC); // print_r($avatar);
    
        // Initialiser un tableau pour stocker les paramètres
        $params = array();
        
        // Boucler sur les résultats pour les ajouter au tableau
        foreach ($avatar as $param => $value) {
            $params[$param] = $value;
        }
    
        // Retourner le tableau des paramètres
        return $params;
    }
    
    public static function getDreamsParams($userId) {
        // Créer une connexion à la base de données
        $pdo = \Models\Admin::db();
    
        // Préparer la requête SQL pour obtenir les paramètres associés à l'ID de l'abonnement de l'utilisateur
        $sql = "SELECT d.param, d.value 
                FROM DreamsAboParams d
                JOIN MembresAbo ma ON d.SubscrId = ma.aboId
                WHERE ma.membreId = :userId";
    
        // Préparer la déclaration SQL
        $stmt = $pdo->prepare($sql);  
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_STR);
        $stmt->execute();
        $dreams = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        // Initialiser un tableau pour stocker les paramètres
        $params = array();
        
        // Boucler sur les résultats pour les ajouter au tableau
        foreach ($dreams as $param => $value) {
            $params[$param] = $value;
        }
    
        // Retourner le tableau des paramètres
        return $params;
    }


}

