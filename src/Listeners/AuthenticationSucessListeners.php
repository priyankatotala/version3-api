<?php
namespace App\Listeners;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationSuccessListeners {
private $secure = false;
private $tokenttl;

    public function __construct($tokenTtl)
    {
        $this->tokenttl   = $tokenttl;
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event) {
        $response = $event->getResponse();
        $data = $event->getData();

        $token = $data['token'];
        unset($data['token']);
        $event = setData($data);

        $response->headers->setCookie(
            new Cookie($token, 
            (new \DateTime())
                ->add(new \DateInterval('PT' .$this->tokenttl. 'S'))
            ), '/', null, $this->secure, name: 'BEARER'
        );
    }
}