<?php
error_reporting(0);
//session_set_cookie_params(0, "/", $_SERVER["HTTP_HOST"], 0);
set_error_handler(create_function('$a, $b, $c, $d', 'throw new ErrorException($b, 0, $a, $c, $d);'), E_ALL & ~E_NOTICE);
chdir('..');

require_once 'autoload.php';

$application = new Zend_Application(
    'production',
    array(
        'bootstrap' => array(
            'path' => 'Application/Bootstrap/Bootstrap.php',
            'class' => 'Application\Bootstrap\Bootstrap'
        )
    )
);
$application->bootstrap()->run();
