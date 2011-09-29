<?php

$router = Core::DI()['router'];

$router->addRule('/', array('controller' => 'main', 'action' => 'index'));
$router->addRule('/about/', array('controller' => 'main', 'action' => 'about'));
$router->addRule('/contact/', array('controller' => 'main', 'action' => 'contact'));
$router->addRule('/login/', array('controller' => 'main', 'action' => 'login'));
