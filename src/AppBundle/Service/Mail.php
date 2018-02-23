<?php 

 namespace AppBundle\Service; 
  
 use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface; 
 use Twig\Environment; 
  
  
 class Mail 
 { 
     const EMAIL = 'newsletter@ceorangeso.com'; 
  
     private $twig; 
     private $mailer; 
  
     public function __construct(Environment $twig, \Swift_Mailer $mailer) 
     { 
         $this->twig = $twig; 
         $this->mailer =$mailer; 
     } 
   
  
     public function sendMail($command, $mail) 
     { 
         
         
         $message = (new \Swift_Message('Louvre')) 
             ->setFrom(self::EMAIL) 
             ->setTo($mail) 
             ->setBody( 
                 $this->twig->render('louvre/bill.html.twig', [ 
                     'command'=>$command 
                 ]), 
                 'text/html' 
             ); 
         $this->mailer->send($message); 
     } 
 } 