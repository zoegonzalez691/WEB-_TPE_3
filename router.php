<?php
require_once 'libs/router.php';

$router = new Router();




// rutea
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);