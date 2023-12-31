<?php 

namespace App\Events;

use App\Entity\User;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Symfony\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface{
    
    protected $encoder;
    public function __construct( UserPasswordHasherInterface $encoder){
        $this->encoder = $encoder;
    }
    public static function getSubscribedEvents(){
        //on se retrouve au moment ou API PLAFORM a fini de désérialiser le JSON et il s'apprête à l'envoyer à la base de données
        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]
        ];
    }

    public function encodePassword(ViewEvent $event){

        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if($result instanceof User && $method === "POST"){
            $hash = $this->encoder->hashPassword($result, $result->getPassword());
            $result->setPassword($hash);
            
        }
    }
}