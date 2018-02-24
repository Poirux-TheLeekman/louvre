<?php 

 namespace AppBundle\Service; 
  
 use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface; 
 use Twig\Environment; 
  
  
 class Mail 
 { 
     //const EMAIL = 'newsletter@ceorangeso.com'; 
    const EMAIL = 'contact@projet4.yuqi.fr';
     private $twig; 
     private $mailer; 
  
     public function __construct(Environment $twig, \Swift_Mailer $mailer) 
     { 
         $this->twig = $twig; 
         $this->mailer =$mailer; 
     } 
   
  
     public function sendMail($command, $mail) 
     { 
         
         
         $message = (new \Swift_Message('Votre billet du Louvre.')) 
             ->setFrom(self::EMAIL) 
             ->setTo($mail) 
             ->setBody( 
                 $this->twig->render('louvre/mail.html.twig', [ 
                     'command'=>$command 
                 ]), 
                 'text/html' 
             ); 
         $this->mailer->send($message); 
     } 
 } 