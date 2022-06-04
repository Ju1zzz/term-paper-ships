<?php

require_once "BaseShipTwigController.php"; 

class MainController extends BaseShipTwigController {
    public $template = "main.twig";
    public $title = "Главная";

    public function getContext() : array
    {
       
        $context = parent::getContext(); 
    
       if (isset($_GET['type'])) {
       $query = $this->pdo->prepare("SELECT * FROM ship WHERE fk_id_type = :type");
       $query->bindValue("type", $_GET['type']);
       $query->execute();
      
    }
    else {
       $query = $this->pdo->query("SELECT * FROM ship");
    }
    
                         
    
    $context['ships'] = $query->fetchAll();
    $context["messages"] = isset($_SESSION['messages']) ? $_SESSION['messages'] : "";
    return $context;
    }
    
}