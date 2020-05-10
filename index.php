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
require_once('vendor/autoload.php');

// start session
session_start();

//Create an instance of the Base class
// instantiates the base class of the fat
// free framework
// :: invokes static method
$f3 = Base::instance();

// Define a default route
$f3->route('GET /', function () {
    //echo '<h1>Initial home page check</h1>';
    $view = new Template();
    echo $view->render
    ('views/home.html');

});

// this is the route to personal info page
// GET method when coming from home page
// POST method when submitting form
$f3->route('GET|POST /persInfo', function($f3){
    // if the form has been submitted
    // validate the data
    //display a page called personalInfo.html
    $view = new Template();
    echo $view->render('views/personalInfo.html');
});

//Run fat free
// -> runs class method instance method
$f3->run();