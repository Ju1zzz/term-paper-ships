<?php
require_once "BaseShipTwigController.php";
 class SearchController extends BaseShipTwigController{
     public $template = "search.twig";

     public function getContext(): array{
         $context = parent::getContext();


         $type = isset($_GET['type']) ? $_GET['type'] : '';
         $title = isset($_GET['title']) ? $_GET['title'] : '';
         $text = isset($_GET['text']) ? $_GET['text'] : '';

        if($type=="все"){
            $sql =<<<EOL
            SELECT * 
            from ship
            WHERE (:name=''OR name like CONCAT('%',:name,'%')) and (:text=''OR text like CONCAT('%',:text,'%'))
        EOL;
        }else{
            $sql =<<<EOL
            SELECT * 
            from ship
            WHERE (:name=''OR name like CONCAT('%',:name,'%')) and (fk_id_type=:type) and (:text=''OR text like CONCAT('%',:text,'%'))
        EOL;
        }
        $query = $this->pdo->prepare($sql);

        $query->bindValue("name", $title);
        $query->bindValue("type", $type);
        $query->bindValue("text", $text);
        $query->execute();

        $context['ships'] = $query->fetchAll();
        return $context;
    }
 }