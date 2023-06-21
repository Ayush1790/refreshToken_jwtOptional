<?php
// listener class for event handling
namespace handler\Listener;

use Exception;
use Phalcon\Di\Injectable;
use Phalcon\Mvc\Application;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;

class Listener extends Injectable
{
    public function beforeHandleRequest(Event $event, Application $app, Dispatcher $dis)
    {
        if (empty($dis->getControllerName())) {
            $controller = 'index';
        } else {
            $controller = $dis->getControllerName();
        }
        if ($controller == 'index' || $controller == 'login' || $controller == 'signup') {
            //accessible
        } else {
            if ($this->session->get('token')) {
                try {
                    $parser = new Parser();
                    $tokenObject = $parser->parse($this->session->get('token'));
                    $now = new \DateTimeImmutable();
                    $expirs = $now->getTimestamp();
                    $validator = new Validator($tokenObject, 100);
                    $validator->validateExpiration($expirs);
                    $claims = $tokenObject->getClaims()->getPayload();
                    if($claims['sub']=='user'){
                        //authenticated
                    }else {
                        echo "You are not authenticated ! ";
                        echo "<a href='login'>Authenticate Yourself...</a>";
                        die;
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                    echo "You are not authenticated !";
                    echo "<a href='login'>Authenticate Yourself..</a>";
                    die;
                }
            } else {
                echo "You are not authenticated ! ";
                echo "<a href='login'>Authenticate Yourself..</a>";
                die;
            }
        }
    }
}
