<?php

use Phalcon\Mvc\Controller;
use Phalcon\Escaper;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;

class SignupController extends Controller
{
    public function indexAction()
    {
        //redirect to view
    }

    public function registerAction()
    {
        $escaper = new Escaper();
        $user = new Users();
        $array = [
            'name' => $escaper->escapeHtml($this->request->getPost('name')),
            'email' => $escaper->escapeHtml($this->request->getPost('email')),
            'pswd' => $escaper->escapeHtml($this->request->getPost('pswd')),
            'role' => $this->request->getPost('role'),
        ];

        $user->assign(
            $array,
            ['name', 'email', 'pswd', 'role']
        );
        $success = $user->save();
        if ($success) {
            // Defaults to 'sha512'
            $signer  = new Hmac();
            // Builder object
            $builder = new Builder($signer);
            $now        = new DateTimeImmutable();
            $issued     = $now->getTimestamp();
            $notBefore  = $now->modify('-1 minute')->getTimestamp();
            $expires    = $now->modify('+1 day')->getTimestamp();
            $passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';
            // Setup
            $builder
                ->setContentType('application/json')        // cty - header
                ->setExpirationTime($expires)               // exp
                ->setId('abcd123456789')                    // JTI id
                ->setIssuedAt($issued)                      // iat
                ->setIssuer('https://phalcon.io')           // iss
                ->setNotBefore($notBefore)                  // nbf
                ->setSubject($array['role'])                // sub
                ->setPassphrase($passphrase);               // password
            $tokenObject = $builder->getToken();
            //token
            $token= $tokenObject->getToken();
            $this->cookies->set('token', $token);
        } else {
            print_r($user->getMessages());
        }
    }
}
