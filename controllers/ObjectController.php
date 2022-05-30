<?php
require_once "BaseShipTwigController.php";

class ObjectController extends BaseShipTwigController {
     public $template = "__object.twig";

     public function getTemplate(){
        if(isset($_GET['view'])){
           
            if($_GET['view']=='image'){
           return "base_image.twig";
            
            }
            elseif ($_GET['view']=='text') {
           return "base_text.twig";

            }
           
        }
        return parent::getTemplate();
    }

    public function getContext(): array{
        
        $context = parent::getContext();
        

            $query = $this->pdo->prepare("SELECT price, image, text, name, id_ship FROM ship WHERE id_ship= :my_id");
            $query->bindValue("my_id", $this->params['id_ship']); 
            $query->execute();
            $data = $query->fetch();
            $context['id_ship'] = $data['id_ship'];
            $context['name'] = $data['name'];
            

        if(isset($_GET['view'])){
           
            if($_GET['view']=='image'){

            $context['type'] = "image";
            $context['image'] = $data['image'];
            }
            elseif ($_GET['view']=='text') {
            $context['type'] = "text";
            $context['text'] = $data['text'];
            }
           
        }
        else {
           
            //$context['description'] = $data['description'];    
        } 
        $context["my_session_message"] = isset($_SESSION['welcome_message']) ? $_SESSION['welcome_message'] : "";

        $context["messages"] = isset($_SESSION['messages']) ? $_SESSION['messages'] : "";
        return $context;
    }
}