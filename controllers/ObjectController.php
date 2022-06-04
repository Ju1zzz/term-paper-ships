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
        

            $query = $this->pdo->prepare("SELECT price, image, text, name, fk_id_tech, id_ship FROM ship WHERE id_ship= :my_id");
            $query->bindValue("my_id", $this->params['id']); 
            $query->execute();
            $data = $query->fetch();
            $context['id_ship'] = $data['id_ship'];
            
            $context['name'] = $data['name'];
            $context['tech_id']=$data['fk_id_tech'];
            //var_dump($data);
            
            $query2 = $this->pdo->prepare("SELECT * FROM tech_text WHERE id_tech = :my_tech_id");
            $query2->bindValue("my_tech_id",  $context['tech_id']); 
            $query2->execute();
            $data1 = $query2->fetch();
            $context['speed'] = $data1['speed'];
            $context['rooms'] = $data1['rooms'];
            $context['size'] = $data1['size'];
            $context['capacity'] = $data1['capacity'];


            $query1 = $this->pdo->prepare("SELECT * FROM schedule where ship_id = :my_id");
            $query1->bindValue("my_id", $this->params['id']); 
            $query1->execute();
    
            $context['events'] = $query1->fetchAll();
            //var_dump($context['events']);
            
            
            include 'Calendar.php';
            $calendar = new Calendar();
            for ($i = 0; $i < count( $context['events']); $i++) {
               // print_r( $context['events'][$i][1]);
                $calendar->add_event('Арендован',  $context['events'][$i][1], 1);
              }
            
              print_r($calendar);
            
            
            
            
        if(isset($_GET['view'])){
           
            if($_GET['view']=='image'){

            $context['type'] = "image";
            $context['image'] = $data['image'];
            }
            elseif ($_GET['view']=='text') {
            $context['type'] = "text";
            $context['info'] = $data['text'];
            }
           
        }
        else {
           
            $context['description'] = $data['price'];    
        } 
       
        
        return $context;
    }
}