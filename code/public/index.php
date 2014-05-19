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
        //echo 'Hello, This is the admin page';
        $test = $user->find(array());
       // var_dump($test['2']['hands']);
        $template = $twig->loadTemplate('adminHome.html');
        echo $template->render(array('username' =>  $test));
    }
);

$f3->route('GET /admin/delete/@username/@id',
    function() use ($f3,$user,$twig) {
        $username = $f3->get('PARAMS.username');
        $handid = $f3->get('PARAMS.id');
       // $test = $user->update(array("username" => $username, $pull: { "hands" : { id: $handid } };
        
        //db.hc.update({username:"Alex"},{ $pull: { "hands" : { id: 1 } } })


       // var_dump($test['2']['hands']);
        $template = $twig->loadTemplate('adminHome.html');
         echo $template->render(array('username' => $test));
    }
);

$f3->route('GET /admin/create',
    function() use ($twig) {
       $template = $twig->loadTemplate('adminCreate.html');
       echo $template->render(array());
    }
);

$f3->route('POST /admin/create/post',
    function() use ($f3) {
        

    // Variables for their hand
    $tcard1 = F3::get('REQUEST.c1'); 
    $tcard1suit = F3::get('REQUEST.c1suit');
    $tcard2 = F3::get('REQUEST.c2'); 
    $tcard2suit = F3::get('REQUEST.c2suit2');

    $card1 =  $tcard1 . $tcard1suit;
    $card2 = $tcard2 . $tcard2suit; 

    //echo $card1;
    //echo $card2;

    // Arrary for opponents hands
    $theirarray = array( $card1, $card2);

    // Variables for opponent hand
    $ocard1 = F3::get('REQUEST.theirc1'); 
    $ocard1suit = F3::get('REQUEST.theirc1suit') ;
    $ocard2 = F3::get('REQUEST.theirc1'); 
    $ocard2suit = F3::get('REQUEST.theirc2suit'); 

    $ocard1 = $ocard1 . $ocard1suit;
    $ocard2 = $ocard2 . $ocard2suit;

    //echo $ocard1;
    //echo $ocard2;

    // Arrary for opponents hands
    $oparray = array( $ocard1, $ocard2);

    // Variables for board hand
    $bcard1 = F3::get('REQUEST.bc1'); 
    $bcard1suit = F3::get('REQUEST.bc1suit') ;
    $bcard2 = F3::get('REQUEST.bc2'); 
    $bcard2suit = F3::get('REQUEST.bc2suit') ;
    $bcard3 = F3::get('REQUEST.bc3'); 
    $bcard3suit = F3::get('REQUEST.bc3suit') ;
    $bcard4 = F3::get('REQUEST.bc4'); 
    $bcard4suit = F3::get('REQUEST.bc4suit') ;
    $bcard5 = F3::get('REQUEST.bc5'); 
    $bcard5suit = F3::get('REQUEST.bc5suit') ;

    $boardcard1 = $bcard1 . $bcard1suit;
    $boardcard2 = $bcard2 . $bcard2suit;
    $boardcard3 = $bcard3 . $bcard3suit;
    $boardcard4 = $bcard4 . $bcard4suit;
    $boardcard5 = $bcard5 . $bcard5suit;

    // arrary that has to go in board
    //echo $boardcard1;
    //echo $boardcard2;
    //echo $boardcard3;
    //echo $boardcard4;
    //echo $boardcard5;
    $boardarray = array( $boardcard1, $boardcard2, $boardcard3, $boardcard4, $boardcard5);


    // Now i need to insert these arrarys in mongo DB

    }
);

$f3->route('GET /user/@user/@id',
    function() use ($f3,$user,$twig) {
        $userparam  = $f3->get('PARAMS.user').' This is the user.';
        //echo $f3->get('PARAMS.id').' This is the id';
        $test2 = $user->find(array());
        $test = $user->find(array("username" =>$userparam ));
        var_dump($test2);
        $template = $twig->loadTemplate('adminTemplate.html');
        echo $template->render(array('user' =>  $test));
    }
);


$f3->run();
