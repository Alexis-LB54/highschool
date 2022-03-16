<?php

namespace App\EventListener;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordEncoder implements EventSubscriberInterface
{

    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder) 
    {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents() 
    {
        return [
            KernelEvents::VIEW => ["encodePassword", EventPriorities::PRE_WRITE],
        ];
    }

    public function encodePassword(ViewEvent $event)
    {
        $instanceOfUserClass = $event->getControllerResult();

        if ($instanceOfUserClass instanceof User) {
            $passwordHash = $this->encoder->hashPassword($instanceOfUserClass, $instanceOfUserClass->getPassword());
            $instanceOfUserClass->setPassword($passwordHash);
        }

    }

}
