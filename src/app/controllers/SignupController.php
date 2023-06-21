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
        $array = [
            'name' => $escaper->escapeHtml($this->request->getPost('name')),
            'email' => $escaper->escapeHtml($this->request->getPost('email')),
            'pincode' => $escaper->escapeHtml($this->request->getPost('pincode')),
            'pswd' => $escaper->escapeHtml($this->request->getPost('pswd')),
        ];
        $this->mongo->insertOne($array);
        $this->response->redirect('login');
        
    }
}
