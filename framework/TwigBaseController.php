<?php
require_once "BaseController.php"; 
class TwigBaseController extends BaseController {
    public $title = ""; 
    public $template = ""; 
    protected \Twig\Environment $twig; 
    
    public function setTwig($twig) {
        $this->twig = $twig;
    }
    
    public function getTemplate(){
        return $this->template;
    }

    public function getContext() : array
    {
        $context = parent::getContext();
        $context['title'] = $this->title;  
        $context["messages"] = isset($_SESSION['messages']) ? $_SESSION['messages'] : "";
        return $context;
    }

    public function get(array $context) { 
        echo $this->twig->render($this->getTemplate(), $context); 
    }
}