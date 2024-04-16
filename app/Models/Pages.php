<?php

namespace Models;

class Pages {
    public $id;
    public $propriete;

    public static function getpage($pageName)
    {
        $pdo = \Models\Admin::db();
        $sql = "SELECT * FROM Pages WHERE name = '$pageName'"; //echo $sql;
        $sql = "SELECT * FROM Pages WHERE name = :name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $pageName, \PDO::PARAM_STR);
        $stmt->execute();

        $page = $stmt->fetchAll(\PDO::FETCH_OBJ)[0]; // laisser 0 
        return $page;
    }

    public static function baseData ($pageName)
    {
       // echo "home ".$appPath = dirname(realpath(__DIR__));

        $page = \Models\Pages::getpage($pageName );
        $pageTitle = $page -> title;
        $pageFollow = $page -> follow;
        $pageDescription = $page -> description;
        $pageName = $page -> name;
        $pageMenus = \Models\Menus::getMenus($pageName);

        $headerFilePath = APPDIR . "/views/" . $pageName . "_header.twig"; //echo $headerFilePath;
        $twigFilePath= APPDIR . "/views/" . $pageName . "_content.twig";
        $sectionTemplatePath =  APPDIR . "/views/" .$pageName . "_sections.twig";

        $headerExists = file_exists($headerFilePath);
        $twigExists = file_exists($twigFilePath); //if ($twigExists) { echo "tw "; } else {echo "no";}
        $sectionTemplateExists = file_exists($sectionTemplatePath);//if ($sectionTemplateExists) { echo "st "; } else {echo "no";}

        $headertwig = $headerExists ? $pageName . "_header.twig" : "_header.twig";
        $pagetwig = $twigExists ? $pageName . "_content.twig" : "page_content.twig";
        $sectionTwig = $sectionTemplateExists ? $pageName . "_sections.twig" : "_sections.twig";

        $sections = self::getsectionList($page -> name); //print_r($sections);
        foreach ($sections as $section)
        {
            $name = $section["name"];
            $content = $section["section_content"];
            $id = $section["id"];
        }
 
        $google_ident = "G-XXXX";
        $protocol = 'https://';
        $pageurl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        
        $pageData = [
            'page_name' => $pageName ,
            'page_title' => $pageTitle ,
            'page_description' => $pageDescription ,
            'page_follow' => $pageFollow,
            'share_img' => '', //url de l'image à partager
            "headertwig" => $headertwig,
            "twig" => $pagetwig,
            "sectionTemplateName" => $sectionTwig,
            'google_ident' => $google_ident,
            'page_url' => $pageurl,
            "TemplatePath" => $twigFilePath,
            "sections" => $sections,
            "logo_svg_url" => "css/img/logo.svg",
            "logo_jpg_url" => "css/img/logo.jpg"
        ];

        foreach ($pageMenus as $menu)
        {
            $menu_links = $menu -> getMenusLinks();
            $menu_name = $menu -> name;
            $pageData["menus"][$menu_name]["links"] = $menu_links;
            $pageData["menus"][$menu_name]["id"] = $menu -> id;
        }

        return $pageData;
    }

    public static function pageCreate($name, $title, $description, $status)
    {
        $pdo = \Models\Admin::db();
        $sql = "INSERT INTO Pages (name, title, description, status) VALUES (:name, :title, :description, :status)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
        $stmt->execute();

        return $pdo->lastInsertId();
    }

    public static function pageDelete($pageId)
    {
        $pdo = \Models\Admin::db(); 
        $sql = "DELETE FROM Pages WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $pageId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount(); // Retourne le nombre de lignes affectées
    }

    public static function pageEdit($pageId, $name, $title, $description, $status)
    {
        $pdo = \Models\Admin::db();
        $sql = "UPDATE Pages SET name = :name, title = :title, description = :description, status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $pageId, \PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, \PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount(); // Retourne le nombre de lignes affectées
    }

    public static function getsectionList($pageIdent)
    {
        $pdo = \Models\Admin::db();
        $sql = "SELECT Sections.id, Sections.sectionName name, CONCAT('_S_', Sections.sectionName, '_content.twig') section_content  
        FROM Sections JOIN Pages ON Sections.pageId = Pages.id WHERE Pages.name = '$pageIdent'"; //echo $sql;
        $sql = "SELECT Sections.id, Sections.sectionName name, CONCAT('_S_', Sections.sectionName, '_content.twig') section_content  
        FROM Sections JOIN Pages ON Sections.pageId = Pages.id WHERE Pages.name = :pageIdent";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pageIdent', $pageIdent, \PDO::PARAM_STR);
        $stmt->execute();

        $sections = $stmt->fetchAll(\PDO::FETCH_ASSOC); 
        return $sections;
    }

    public static function home_content()
    {
        $homecontent = "landing1.twig";
        return $homecontent;
    }
}

?>
