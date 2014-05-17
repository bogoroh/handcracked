<?php
//$mb = $mongo->selectDb("handcracked")->selectCollection("hc");
require_once '../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('views/');
$twig = new Twig_Environment($loader, array(
));


$f3 = require('../lib/base.php');

$db=new DB\Mongo('mongodb://localhost:27017','handcracked');
$user=new DB\Mongo\Mapper($db,'hc');

$f3->route('GET /',
    function() use ($user) {
        //echo 'Hello, world!';
        $test = $user->find(array());
        //echo $test[1]['username'];
        //echo $test[0]['hands']['yourhand'][0];
    }
);

$f3->route('GET /admin',
    function() use ($user,$twig){
        echo 'Hello, This is the admin page';
        $test = $user->find(array());
        $template = $twig->loadTemplate('adminHome.html');
        echo $template->render(array('username' => $test));
    }
);

$f3->route('GET /user',
    function() {
        echo 'Hello, This is the user main page';
    }
);

$f3->route('GET /user/@count',
    function($f3) {
        echo 'Hello, This is the user main page';
        echo $f3->get('PARAMS.count').' bottles of beer on the wall.';
    }
);


$f3->run();
