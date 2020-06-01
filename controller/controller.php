<?php

/**
 * Class MemberController
 */
class MemberController
{
    private $_f3; //router
    private $_validator; //validation object

    /**
     * Controller constructor.
     * @param $f3
     */
    public function __construct($f3, $validator)
    {
        $this->_f3 = $f3;
        $this->_validator = $validator;
    }

    /**
     * Display the default route
     */
    public function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    /**
     * Process the view Recipes route
     */
    public function persInfo()
    {
        // validate the data
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $valid = true;
            //var_dump($_POST);
            // validate first name
            if (!$this->_validator->validName($_POST['firstName'])) {
                $valid = false;
                $this->_f3->set('errors["fName"]', "Please provide a first name");
            }
            else {
                $this->_f3->set('selectedFname', $_POST['firstName']);
            }

            // validate last name
            if (!$this->_validator->validName($_POST['lastName'])) {
                $valid = false;
                $this->_f3->set('errors["lName"]', "Please provide a last name");
            }
            else {
                $this->_f3->set('selectedLname', $_POST['lastName']);
            }

            // validate age
            if (!$this->_validator->validAge($_POST['age'])) {
                $valid = false;
                $this->_f3->set('errors["age"]', "Please provide your age");
            }
            else {
                $this->_f3->set('selectedAge', $_POST['age']);
            }

            // validate phone
            if (!$this->_validator->validPhone($_POST['phone'])) {
                $valid = false;
                $this->_f3->set('errors["phone"]', "Please provide a valid phone number");
            }
            else {
                $this->_f3->set('selectedPhone', $_POST['phone']);
            }

            // check if membership selected
            if (isset($_POST['membership'])) {
                $this->_f3->set('membership', $_POST['membership']);
            }

            // set the selected gender
            if (isset($_POST['gender'])) {
                $this->_f3->set('selectedGender', $_POST['gender']);
            }

            if ($valid) {
                //Data is valid
                // create the member object
                if (isset($_POST['membership'])) {
                    $member = new PremiumMember($_POST['firstName'], $_POST['lastName'],
                        $_POST['age'], $_POST['gender'], $_POST['phone']);
                }
                else {
                    $member = new Member($_POST['firstName'], $_POST['lastName'],
                        $_POST['age'], $_POST['gender'], $_POST['phone']);
                }
                //Add the form data to the session
                $_SESSION['member'] = $member;
                /*
                $_SESSION['firstName'] = $_POST['firstName'];

                $_SESSION['lastName'] = $_POST['lastName'];

                $_SESSION['age'] = $_POST['age'];

                $_SESSION['gender'] = $_POST['gender'];

                $_SESSION['phone'] = $_POST['phone'];
               */
                //Redirect to the profile route
                $this->_f3->reroute("profile");
                //session_destroy();

            }

        }

        // if method is get - display a page called personalInfo.html
        $view = new Template();
        echo $view->render('views/personalInfo.html');
    }

    /**
     * Display the profile
     */
    public function profile()
    {
        // if the form has been submitted
        // validate the data
        echo get_class($_SESSION['member']);
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $valid = true;
            //Validate the data
            // validate e-mail
            if (!$this->_validator->validEMail($_POST['email']))
            {
                $valid = false;
                $this->_f3->set('errors["email"]', "Please provide a valid Email");
            }
            else {
                $this->_f3->set('selectedEmail', $_POST['email']);
            }

            // validate state - only if provided is not a state
            if (!$this->_validator->validState($_POST['state']))
            {
                $valid = false;
                $this->_f3->set('errors["state"]', "State is incorrect");
            }
            else {
                $this->_f3->set('selectedState', $_POST['state']);
            }

            $this->_f3->set('selectedGender', $_POST['seeking']);
            $this->_f3->set('selectedBio', $_POST['bio']);


            if ($valid)
            {
                //Data is valid

                //***Add the form data to the session
                //$_SESSION['email'] = $_POST['email'];
                //$_SESSION['state'] = $_POST['state'];
                //$_SESSION['seeking'] = $_POST['seeking'];
                //$_SESSION['bio'] = $_POST['bio'];
                $_SESSION['member']->setEmail($_POST['email']);
                $_SESSION['member']->setState($_POST['state']);
                $_SESSION['member']->setSeeking($_POST['seeking']);
                $_SESSION['member']->setBio($_POST['bio']);


                //Redirect to the interests route
                $this->_f3->reroute("interests");
                //session_destroy();
            }
        }

        // if method is get display a page called profile.html
        $view = new Template();
        echo $view->render('views/profile.html');
    }

    /**
     * Display the individual recipe
     */
    public function interests()
    {
        // if the form has been submitted
        // validate the data
        $indoorInts = getIndoorInts();
        $outdoorInts = getOutdoorInts();
        $this->_f3->set('indoorInts', $indoorInts);
        $this->_f3->set('outdoorInts', $outdoorInts);
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //var_dump($_POST);
            // validate the data
            $valid = true;
            if (!$this->_validator->validIndoor($_POST['indoorInts']))
            {
                $valid = false;
                $this->_f3->set('errors["indoorInts"]', "Invalid choice(s)");
                // make the valid ones sticky
                $f3->set('selectedIndoor', $_POST['indoorInts']);
            } else {
                $this->_f3->set('selectedIndoor', $_POST['indoorInts']);
            }

            if (!$this->_validator->validOutdoor($_POST['outdoorInts']))
            {
                $valid = false;
                $this->_f3->set('errors["outdoorInts"]', "Invalid choice(s)");
                // make the valid ones sticky
                $this->_f3->set('selectedOutdoor', $_POST['outdoorInts']);
            } else {
                $this->_f3->set('selectedOutdoor', $_POST['outdoorInts']);
            }

            if ($valid) {
                // store the data in the session array
                //$_SESSION['outdoorInts'] = $_POST['outdoorInts'];
                //$_SESSION['indoorInts'] = $_POST['indoorInts'];
                $_SESSION['member']->setIndoorInts($_POST['indoorInts']);
                $_SESSION['member']->setOutdoorInts($_POST['outdoorInts']);

                //redirect to summary page
                $this->_f3->reroute('summary');
                session_destroy();
            }
        }

        //if method is get display a page called interests.html
        $view = new Template();
        echo $view->render('views/interests.html');
    }

    /**
     *
     */
    public function summary()
    {
        // display the summary page
        $view = new Template();
        echo $view->render
        ('views/summary.php');
        $_SESSION = array();
        session_destroy();
    }

}