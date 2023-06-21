<?php

use Phalcon\Mvc\Controller;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;


class LoginController extends Controller
{
    public function indexAction()
    {
        //redirect to view
    }
    public function loginAction()
    {
        $email = $this->request->getPost('email');
        $pswd = $this->request->getPost('pswd');
        $res = $this->mongo->findOne(['email'=>$email,'pswd'=>$pswd]);
        if ($res->name) {
            $signer  = new Hmac();

            // Builder object
            $builder = new Builder($signer);

            $now        = new \DateTimeImmutable();
            $issued     = $now->getTimestamp();
            $notBefore  = $now->modify('-1 minute')->getTimestamp();
            $expires    = $now->modify('+1 day')->getTimestamp();
            $passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';
            // Setup
            $builder
                ->setExpirationTime($expires)               // exp
                ->setId('abcd123456789')                    // JTI id
                ->setIssuedAt($issued)                      // iat
                ->setIssuer('https://phalcon.io')           // iss
                ->setNotBefore($notBefore)                  // nbf
                ->setSubject('user')                // sub
                ->setPassphrase($passphrase)                // password
            ;
            // Phalcon\Security\JWT\Token\Token object
            $tokenObject = $builder->getToken();
            // The token
            $token = $tokenObject->getToken();
            $this->session->set('token', $token);
            print_r($this->session->get('token'));
        }
        else{
            $this->response->redirect('login');
        }
    }
}
