<?php
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
        echo "Please start with /admin or /user";
    }
);

$f3->route('GET /admin',
    function() use ($user,$twig){
        $test = $user->find(array());
        $template = $twig->loadTemplate('adminHome.html');
        echo $template->render(array('username' =>  $test));
    }
);

$f3->route('GET /admin/delete/@username/@id',
    function() use ($f3,$user,$twig) {
        $username = strtolower($f3->get('PARAMS.username'));
        $handid = $f3->get('PARAMS.id');
        

        /// ???????????????????????????????????????????????????????????????????
        //db.hc.update({username:"Alex"},{ $pull: { "hands" : { id: 1 } } })
        // ????????????????????????????????????????????????????????????????????????
        $f = array();
        $f['username'] = 'alex';

        $p = array();
        $p['hands'] = array('id'=>1);
        //var_dump($p);
        // $user->update($f,array('$pull'=>$p));

        $user->update( $f, array('$pull' =>$p ));
        exit();
        //$template = $twig->loadTemplate('adminHome.html');
         //echo $template->render(array('username' => $test));
    }
);

$f3->route('GET /admin/create',
    function() use ($twig) {
       $template = $twig->loadTemplate('adminCreate.html');
       echo $template->render(array());
    }
);

$f3->route('POST /admin/create/post',
    function() use ($f3,$user,$twig) {
        
    $username = strtolower(F3::get('REQUEST.username'));
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


    //$handnumber = $??? ++
    // arrary that has to go in board
    //echo $boardcard1;
    //echo $boardcard2;
    //echo $boardcard3;
    //echo $boardcard4;
    //echo $boardcard5;
    $boardarray = array( $boardcard1, $boardcard2, $boardcard3, $boardcard4, $boardcard5);


    //$intcount = $user->count(array("username" => $username));
    //var_dump($intcount);
    $randomint = rand(0,10000);
    $fullarray = array("id" => $randomint,  "yourhand" => $theirarray, "theirhand" => $oparray, "board" => $boardarray);
    


    var_dump($fullarray);

    //????????????????????????????????????????????????????????????????????????????????????
    //????     $user->update("{ 'username' => $username },{ \$push: { hands: $fullarray} }")
    //???? ????????????????????????????????????????????????????????????????????????????????


    //$f3->reroute("/admin");
    // Now i need to insert these arrarys in mongo DB

    }
);

$f3->route('GET /admin/edit/@user/@id',
    function() use ($f3,$user,$twig) {
        $userparam  = $f3->get('PARAMS.user').' This is the user.';
        $idparam = $f3->get('PARAMS.id').' This is the id';
        //$test2 = $user->find(array());

        // Need to find by username "username" =>$userparam & $idparam

        $template = $twig->loadTemplate('adminEdit.html');
        echo $template->render(array());
    }
);

$f3->route('GET /user/@user/@id',
    function() use ($f3,$user,$twig) {
        $userparam  = strtolower($f3->get('PARAMS.user'));
        $idparam = $f3->get('PARAMS.id');
        $handarray = $user->find(array("username" => $userparam,"hands.id" => intval($idparam)));
        $hand =  $handarray[0]['hands'];

        
        //echo "This had to be templated";
        // Need to find by username "username" =>$userparam & $idparam
        //var_dump($test2);
        $template = $twig->loadTemplate('adminTemplate.html');
        echo $template->render(array('hands' =>  $hand));
    }
);

$f3->route("GET /calc/pre/@y1/@y2/@y3/@y4",
    function() use ($f3){
        // Calc preflop

        // Get the params for preflop
        $y1 = $f3->get('PARAMS.y1');
        $y2 = $f3->get('PARAMS.y2');
        $y3 = $f3->get('PARAMS.y3');
        $y4 = $f3->get('PARAMS.y4');
        // If you have pocket AA's

        $c1 = 0;
        if (
            $y1  == "Aceheart" && $y2 == "Acediamond" && $y3 == "Kingheart" && $y4 == "Kingspades" ||  
            $y1 == "Aceheart" && $y2 == "Acediamond" && $y3 == "Kingheart" && $y4 == "Kingdiamond" ||  
            $y1 == "Aceheart" && $y2 == "Acediamond" && $y3 == "Kingheart" && $y4 == "Kingclub" || 
            $y1 == "Aceheart" && $y2 == "Acediamond" && $y3 == "Kingclub" && $y4 == "Kingspade" || 
            $y1 == "Aceheart" && $y2 == "Acediamond" && $y3 == "Kingclub" && $y4 == "Kingdiamond" || 
            $y1 == "Aceheart" && $y2 == "Acediamond" && $y3 == "Kingspade" && $y4 == "Kingdiamond" ||
            $y1 == "Aceheart" && $y2 == "Aceclub" && $y3 == "Kingheart" && $y4 == "Kingspades" || 
            $y1 == "Aceheart" && $y2 == "Aceclub" && $y3 == "Kingheart" && $y4 == "Kingdiamond" || 
            $y1 == "Aceheart" && $y2 == "Aceclub" && $y3 == "Kingheart" && $y4 == "Kingclub" ||
            $y1 == "Aceheart" && $y2 == "Aceclub" && $y3 == "Kingclub" && $y4 == "Kingspade" ||
            $y1 == "Aceheart" && $y2 == "Aceclub" && $y3 == "Kingclub" && $y4 == "Kingdiamond" ||
            $y1 == "Aceheart" && $y2 == "Aceclub" && $y3 == "Kingspade" && $y4 == "Kingdiamond" || 
            $y1 == "Aceheart" && $y2 == "Acespade"  && $y3 == "Kingheart" && $y4 == "Kingspades" ||
            $y1 == "Aceheart" && $y2 == "Acespade"  && $y3 == "Kingheart" && $y4 == "Kingdiamond" || 
            $y1 == "Aceheart" && $y2 == "Acespade"  && $y3 == "Kingheart" && $y4 == "Kingclub" || 
            $y1 == "Aceheart" && $y2 == "Acespade"  && $y3 == "Kingclub" && $y4 == "Kingspade" ||
            $y1 == "Aceheart" && $y2 == "Acespade"  && $y3 == "Kingclub" && $y4 == "Kingdiamond" || 
            $y1 == "Aceheart" && $y2 == "Acespade"  && $y3 == "Kingspade" && $y4 == "Kingdiamond" || 
            $y1 == "Aceclub" && $y2 == "Acespade"  && $y3 == "Kingheart" && $y4 == "Kingspades" || 
            $y1 == "Aceclub" && $y2 == "Acespade"  && $y3 == "Kingheart" && $y4 == "Kingdiamond" ||
            $y1 == "Aceclub" && $y2 == "Acespade"  && $y3 == "Kingheart" && $y4 == "Kingclub" ||
            $y1 == "Aceclub" && $y2 == "Acespade"  && $y3 == "Kingclub" && $y4 == "Kingspade" ||
            $y1 == "Aceclub" && $y2 == "Acespade"  && $y3 == "Kingclub" && $y4 == "Kingdiamond" ||
            $y1 == "Aceclub" && $y2 == "Acespade"  && $y3 == "Kingspade" && $y4 == "Kingdiamond" ||
            $y1 == "Aceclub" && $y2 == "Acediamond"  && $y3 == "Kingheart" && $y4 == "Kingspades" ||
            $y1 == "Aceclub" && $y2 == "Acediamond"  && $y3 == "Kingheart" && $y4 == "Kingdiamond" || 
            $y1 == "Aceclub" && $y2 == "Acediamond"  && $y3 == "Kingheart" && $y4 == "Kingclub" || 
            $y1 == "Aceclub" && $y2 == "Acediamond"  && $y3 == "Kingclub" && $y4 == "Kingspade" ||
            $y1 == "Aceclub" && $y2 == "Acediamond"  && $y3 == "Kingclub" && $y4 == "Kingdiamond" ||
            $y1 == "Aceclub" && $y2 == "Acediamond"  && $y3 == "Kingspade" && $y4 == "Kingdiamond" ||
            $y1 == "Acespade" && $y2 == "Acediamond"  && $y3 == "Kingheart" && $y4 == "Kingspades" ||
            $y1 == "Acespade" && $y2 == "Acediamond"  && $y3 == "Kingheart" && $y4 == "Kingdiamond" || 
            $y1 == "Acespade" && $y2 == "Acediamond"  && $y3 == "Kingheart" && $y4 == "Kingclub" || 
            $y1 == "Acespade" && $y2 == "Acediamond" && $y3 == "Kingclub" && $y4 == "Kingspade" ||
            $y1 == "Acespade" && $y2 == "Acediamond"  && $y3 == "Kingclub" && $y4 == "Kingdiamond" ||
            $y1 == "Acespade" && $y2 == "Acediamond"  && $y3 == "Kingspade" && $y4 == "Kingdiamond") {
            $c1 = 81;
        } elseif ($y1  == "Aceheart" && $y2 == "Kingclubs" && $y3 == "10clubs" && $y4 == "10hearts" ) {
            $c1 = 45;
        }

        //$c2 = $posting ->y2; 
        //$c1 = $_POST["y1"];

        //print_r($y1);

        $ourwin = $c1;
        $theirwin = 100 - $ourwin;

        $winarray = array("value" => $ourwin, "value2" => $theirwin);
        print_r(json_encode($winarray));
        // echo "expression";
    });

$f3->route("GET /calc/flop/@y1/@y2/@y3/@y4/@y5/@y6",
    function() use ($f3){
        // Calc preflop
        print_r("Hi");
        // Get the params for preflop
        $y1 = $f3->get('PARAMS.y1');
        $y2 = $f3->get('PARAMS.y2');
        $y3 = $f3->get('PARAMS.y3');
        $y4 = $f3->get('PARAMS.y4');
        $bc1 = $f3->get('PARAMS.y5');
        $bc2 = $f3->get('PARAMS.y6');
        $bc3 = $f3->get('PARAMS.y7');
        // See on the flop
        $c1 = 0;
        if ($bc1 == "10clubs" || $bc1 == "10hearts" || $bc1 == "10diamonds" || $bc1 == "10hearts" || $bc2 == "10clubs" || $bc2 == "10hearts" || $bc2 == "10diamonds" || $bc2 == "10hearts" || $bc3 == "10clubs" || $bc3 == "10hearts" || $bc3 == "10diamonds" || $bc3 == "10hearts"  ) {
            $c1 = 8;
        };
        $ourwin = $c1;
        $theirwin = 100 - $ourwin;

        $winarray = array("value" => $ourwin, "value2" => $theirwin);
        print_r(json_encode($winarray));
    }
);
$f3->run();
