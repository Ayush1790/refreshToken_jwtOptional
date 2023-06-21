<?php


use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        echo "<a href='generate' class='btn btn-outline-primary'>Generate Token</a>";
        echo "<a href='decode' class='btn btn-outline-secondary'>Decode Token</a>";
        echo "<a href='refresh' class='btn btn-outline-secondary'>Refresh Token</a>";
    }
}
