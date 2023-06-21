<?php

use Phalcon\Mvc\Controller;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;

class RefreshController extends Controller
{
    public function indexAction()
    {
        //redirect to view
    }
    public function refreshAction(){
        $token = $this->request->get('token');
        $parser = new Parser();
        $tokenObject = $parser->parse($token);
        $now = new \DateTimeImmutable();
        $expirs = $now->getTimestamp();
        $validator = new Validator($tokenObject, 100);
        $validator->validateExpiration($expirs);
        $claims = $tokenObject->getClaims()->getPayload();
        $signer  = new Hmac();

        // Builder object
        $builder = new Builder($signer);

        $now        = new \DateTimeImmutable();
        $issued     = $now->getTimestamp();
        $notBefore  = $now->modify('-1 minute')->getTimestamp();
        $expires    = $now->modify('+1 day')->getTimestamp();
        $passphrase = "girtehgijsdfzxxSGDACKSIHejsflmui5451545";
        // Setup
        $builder
            ->setExpirationTime($expires)               // exp
            ->setId('abcd123456789')                    // JTI id
            ->setIssuedAt($issued)                      // iat
            ->setIssuer('https://phalcon.io')           // iss
            ->setNotBefore($notBefore)                  // nbf
            ->setSubject($claims['sub'])                // sub
            ->setPassphrase($passphrase)                // password
        ;
        // Phalcon\Security\JWT\Token\Token object
        $tokenObject = $builder->getToken();
        // The token
        $token = $tokenObject->getToken();
        print_r($token);
        echo "<br><br><a href='/decode'>decode token</a>";
    }
}