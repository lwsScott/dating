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
require_once 'model/validation-functions.php';

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
        var_dump($_POST);
        // validate first name
        if (!validName($_POST['firstName'])) {
            $valid = false;
            $f3->set('errors["fName"]', "Please provide a first name");
        }
        else {
            $f3->set('selectedFname', $_POST['firstName']);
        }

        // validate last name
        if (!validName($_POST['lastName'])) {
            $valid = false;
            $f3->set('errors["lName"]', "Please provide a last name");
        }
        else {
            $f3->set('selectedLname', $_POST['lastName']);
        }

        // validate age
        if (!validAge($_POST['age'])) {
            $valid = false;
            $f3->set('errors["age"]', "Please provide your age");
        }
        else {
            $f3->set('selectedAge', $_POST['age']);
        }

        // validate phone
        if (!validPhone($_POST['phone'])) {
            $valid = false;
            $f3->set('errors["phone"]', "Please provide a valid phone number");
        }
        else {
            $f3->set('selectedPhone', $_POST['phone']);
        }

        // check if membership selected
        if (isset($_POST['membership'])) {
            $f3->set('membership', $_POST['membership']);
        }

        $f3->set('selectedGender', $_POST['gender']);

        if ($valid) {
            //Data is valid
            //***Add the form data to the session
            $_SESSION['firstName'] = $_POST['firstName'];

            $_SESSION['lastName'] = $_POST['lastName'];

            $_SESSION['age'] = $_POST['age'];

            $_SESSION['gender'] = $_POST['gender'];

            $_SESSION['phone'] = $_POST['phone'];

            //Redirect to the profile route
            $f3->reroute("profile");
            //session_destroy();
        }

    }

    // if method is get - display a page called personalInfo.html
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
        // validate e-mail
        if (!validEMail($_POST['email']))
        {
            $valid = false;
            $f3->set('errors["email"]', "Please provide a valid Email");
        }
        else {
            $f3->set('selectedEmail', $_POST['email']);
        }

        // validate state - only if provided is not a state
        if (!validState($_POST['state']))
        {
            $valid = false;
            $f3->set('errors["state"]', "State is incorrect");
        }
        else {
            $f3->set('selectedState', $_POST['state']);
        }

        $f3->set('selectedGender', $_POST['seeking']);
        $f3->set('selectedBio', $_POST['bio']);


        if ($valid)
        {
            //Data is valid

            //***Add the form data to the session
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['state'] = $_POST['state'];
            $_SESSION['seeking'] = $_POST['seeking'];
            $_SESSION['bio'] = $_POST['bio'];

            //Redirect to the interests route
            $f3->reroute("interests");
            //session_destroy();
        }
    }

    // if method is get display a page called profile.html
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
    $f3->set('indoorInts', $indoorInts);
    $f3->set('outdoorInts', $outdoorInts);
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //var_dump($_POST);
        // validate the data
        $valid = true;
        if (!validIndoor($_POST['indoorInts']))
        {
            $valid = false;
            $f3->set('errors["indoorInts"]', "Invalid choice(s)");
            // make the valid ones sticky
            $f3->set('selectedIndoor', $_POST['indoorInts']);
        } else {
            $f3->set('selectedIndoor', $_POST['indoorInts']);
        }

        if (!validOutdoor($_POST['outdoorInts']))
        {
            $valid = false;
            $f3->set('errors["outdoorInts"]', "Invalid choice(s)");
            // make the valid ones sticky
            $f3->set('selectedOutdoor', $_POST['outdoorInts']);
        } else {
            $f3->set('selectedOutdoor', $_POST['outdoorInts']);
        }

        if ($valid) {
            // store the data in the session array
            $_SESSION['outdoorInts'] = $_POST['outdoorInts'];
            $_SESSION['indoorInts'] = $_POST['indoorInts'];

           //redirect to summary page
            $f3->reroute('summary');
            session_destroy();
        }
    }

    //if method is get display a page called interests.html
    $view = new Template();
    echo $view->render('views/interests.html');
});

// Define a summary route
$f3->route('GET /summary', function () {
    // display the summary page
    $view = new Template();
    echo $view->render
    ('views/summary.php');
    $_SESSION = array();
    session_destroy();
});

//Run fat free
// -> runs class method instance method
$f3->run();