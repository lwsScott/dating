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
require_once ('model/data-layer.php');

// start session
session_start();

//Create an instance of the Base class
// instantiates the base class of the fat
// free framework
// :: invokes static method
$f3 = Base::instance();
$f3->set ('states',getStates());


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
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $valid = true;
        //Validate the data
        /*
        if (empty($_POST['firstName']))
        {
            $valid = false;
            echo "Please supply a first name<br>";
        }
        if (empty($_POST['lastName']))
        {
            $valid = false;
            echo "Please supply a last name<br>";
        }
        if (empty($_POST['age']))
        {
            $valid = false;
            echo "Please enter your age<br>";
        }
        if (empty($_POST['gender']))
        {
            $valid = false;
            echo "Please enter your gender<br>";
        }
        if (empty($_POST['phone']))
        {
            $valid = false;
            echo "Please enter your phone number<br>";
        }
        */
        if ($valid)
        {
            //Data is valid

            //***Add the form data to the session
            $_SESSION['firstName'] = $_POST['firstName'];
            $_SESSION['lastName'] = $_POST['lastName'];
            $_SESSION['age'] = $_POST['age'];
            $_SESSION['gender'] = $_POST['gender'];
            $_SESSION['phone'] = $_POST['phone'];

            //Redirect to the profile route
            $f3->reroute("profile");
            session_destroy();
        }

    }

    //display a page called personalInfo.html
    $view = new Template();
    echo $view->render('views/personalInfo.html');
});

// this is the route to profile info page
// GET method when coming from persInfo page
// POST method when submitting form
$f3->route('GET|POST /profile', function($f3)
{
    // if the form has been submitted
    // validate the data
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $valid = true;
        //Validate the data
        /*
        if (empty($_POST['email']))
        {
            $valid = false;
            echo "Please supply a valid e-mail address<br>";
        }
        if (empty($_POST['state']) || $_POST['state'] == 'none')
        {
            $valid = false;
            echo "Please choose a State<br>";
        }
        if (empty($_POST['seeking']))
        {
            $valid = false;
            echo "Please enter what you're seeking<br>";
        }
        if (empty($_POST['bio']))
        {
            $valid = false;
            echo "Please tell us a little about yourself<br>";
        }
        */

        if ($valid)
        {
            //Data is valid

            //***Add the form data to the session
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['state'] = $_POST['state'];
            $_SESSION['seeking'] = $_POST['seeking'];
            $_SESSION['bio'] = $_POST['bio'];

            //Redirect to the summary route
            $f3->reroute("interests");
            session_destroy();
        }
    }

    //display a page called personalInfo.html
    $view = new Template();
    echo $view->render('views/profile.html');
});

// this is the route to interests page
// GET method when coming from profile page
// POST method when submitting form
$f3->route('GET|POST /interests', function($f3){
    // if the form has been submitted
    // validate the data
    $indoorInts = getIndoorInts();
    $outdoorInts = getOutdoorInts();
    $f3->set ('indoorInts', $indoorInts);
    $f3->set ('outdoorInts', $outdoorInts);
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        var_dump($_POST);
        // validate the data
        /*
        if (count(array_intersect($_POST['indoorInts'], $indoorInts)) == 0 &&
           (count(array_intersect($_POST['outdoorInts'], $outdoorInts)) == 0)   )
        {
            echo "<p>Please enter a valid interest</p>";
        }
        // data is valid
        else
        {
        */
            // store the data in the session array
            $_SESSION['outdoorInts'] = $_POST['outdoorInts'];
            $_SESSION['indoorInts'] = $_POST['indoorInts'];

            // redirect to summary page
            $f3->reroute('summary');
            session_destroy();
        //}
    }

    //display a page called personalInfo.html
    $view = new Template();
    echo $view->render('views/interests.html');
});

// Define a summary route
$f3->route('GET /summary', function () {
    //echo '<h1>Initial home page check</h1>';
    $view = new Template();
    echo $view->render
    ('views/summary.php');
    session_destroy();

});

//Run fat free
// -> runs class method instance method
$f3->run();