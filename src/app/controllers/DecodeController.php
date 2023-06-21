<?php

use Phalcon\Mvc\Controller;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;

class DecodeController extends Controller
{
    public function indexAction()
    {
        //redirect to view
    }

    public function decodeAction(){
        $token = $this->request->get('token');
        $parser = new Parser();
        $tokenObject = $parser->parse($token);
        $now = new \DateTimeImmutable();
        $expirs = $now->getTimestamp();
        $validator = new Validator($tokenObject, 100);
        $validator->validateExpiration($expirs);
        $claims = $tokenObject->getClaims()->getPayload();
        print_r($claims['sub']);die;
    }
}