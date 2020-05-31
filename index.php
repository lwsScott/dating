<?php
/*
 * Lewis Scott
 * 4/17/20
 * filename https://lscott.greenriverdev.com/328/dating/index.php
 * Controller page for dating website
 * provides routes to various views and runs fat free
 */
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require the autoload file
require_once 'vendor/autoload.php';
require_once 'model/data-layer.php';
//require_once 'model/validation-functions.php';

// start session
session_start();

//Create an instance of the Base class
// instantiates the base class of the fat
// free framework
// :: invokes static method
$f3 = Base::instance();
$f3->set ('states',getStates());
$f3->set('DEBUG', 3);

// construct a new Database
// which creates a new PDO connection
$db = new Database();

// construct a new validator
$validator = new Validate();

// create a new controller
$controller = new MemberController($f3, $validator);

// Define a default route
$f3->route('GET /', function () {
    //echo '<h1>Initial home page check</h1>';
    //$view = new Template();
    //echo $view->render
    //('views/home.html');
    $GLOBALS['controller']->home();
});

// this is the route to personal info page
// GET method when coming from home page
// POST method when submitting form
$f3->route('GET|POST /persInfo', function($f3){
    // if the form has been submitted
    $GLOBALS['controller']->persInfo();

});

// this is the route to profile info page
// GET method when coming from persInfo page
// POST method when submitting form
$f3->route('GET|POST /profile', function($f3)
{
    $GLOBALS['controller']->profile();

});

// this is the route to interests page
// GET method when coming from profile page
// POST method when submitting form
$f3->route('GET|POST /interests', function($f3){
    $GLOBALS['controller']->interests();
});

// Define a summary route
$f3->route('GET /summary', function () {
    $GLOBALS['controller']->summary();

});

//Run fat free
// -> runs class method instance method
$f3->run();