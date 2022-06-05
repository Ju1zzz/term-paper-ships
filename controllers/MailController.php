<?php 
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require_once "BaseShipTwigController.php"; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception; 
//require 'vendor\autoload.php';
class MailController extends BaseShipTwigController {
    public $template = "form.twig";
    public $title = "Отправить письмо";

    public function post(array $context) {

      
        $query = $this->pdo->prepare("SELECT email, ship.name FROM ship, landlord WHERE id_ship =:my_id AND fk_id_land = id_land");
        $query->bindValue("my_id", $this->params['id']); 
        $query->execute();
        $data = $query->fetch();
        //var_dump($data);

        $to = $data['email']; // this is your Email address
        $ship=$data['name']; 

        $from = 'kuznetsova1yulia@yandex.ru'; // this is the sender's Email address
        $name = $_POST['name'];
        $date = $_POST['date'];
        $subject = "Аренда корабля ". $ship . " на " . $date;
        
        $message = $name . "\n\n" . " Сообщение: " . $_POST['message'] . "\n\n" ."Контакт для связи: " . $_POST['email'];
        
    
        
       
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.yandex.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'kuznetsova1yulia@yandex.ru';                     //SMTP username
    $mail->Password   = 'Fuckyou20';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('kuznetsova1yulia@yandex.ru', 'Аренда корабля');
    $mail->addAddress($to);     //Add a recipient

   

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    //var_dump($mail);

    $mail->send();
    echo "Письмо отправлено. Спасибо, " . $name . ", с вами скоро свяжутся";

          
            
           
      
            $this->get($context);
    }
         
    
}




