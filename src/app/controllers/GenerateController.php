<?php

use Phalcon\Mvc\Controller;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;


class GenerateController extends Controller
{
    public function indexAction()
    {
        //redirect to view
    }
    public function generateAction()
    {
        $role = $this->request->get('role');
        $passphrase = $this->request->get('phrase');
            $signer  = new Hmac();

            // Builder object
            $builder = new Builder($signer);

            $now        = new \DateTimeImmutable();
            $issued     = $now->getTimestamp();
            $notBefore  = $now->modify('-1 minute')->getTimestamp();
            $expires    = $now->modify('+1 day')->getTimestamp();
            $passphrase = $passphrase;
            // Setup
            $builder
                ->setExpirationTime($expires)               // exp
                ->setId('abcd123456789')                    // JTI id
                ->setIssuedAt($issued)                      // iat
                ->setIssuer('https://phalcon.io')           // iss
                ->setNotBefore($notBefore)                  // nbf
                ->setSubject($role)                // sub
                ->setPassphrase($passphrase)                // password
            ;
            // Phalcon\Security\JWT\Token\Token object
            $tokenObject = $builder->getToken();
            // The token
            $token = $tokenObject->getToken();
            print_r($token);
            echo "<br><br><a href='/decode'>decode token</a>";
            die;
    }
}
