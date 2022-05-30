<?php
require_once "BaseShipTwigController.php";

class TypeController extends BaseShipTwigController {
     public $template = "type.twig";// указываем шаблон

    public function getContext(): array{
        
        $context = parent::getContext();
        

        $query = $this->pdo->query("SELECT  * FROM type_2 ORDER BY 1");
        $types = $query->fetchAll();
        $context['types'] = $types;
            
        return $context;
    }
}