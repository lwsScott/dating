<?php
/*
 * Lewis Scott
 * 4/17/20
 * filename https://lscott.greenriverdev.com/328/dating/controller/controller.php
 * Controller page for dating website
 * provides routes to various views and runs fat free
 */
require '/home2/lscottgr/config.php';

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

            if (isset($_POST['seeking'])) {
                $this->_f3->set('selectedGender', $_POST['seeking']);
            }
            if (!empty($_POST['bio'])) {
                $this->_f3->set('selectedBio', $_POST['bio']);
            }


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


                //Redirect to the interests route if premium member
                if (get_class($_SESSION['member']) == "PremiumMember")
                {
                    $this->_f3->reroute("interests");
                }
                else {
                    //redirect to summary page
                    $this->_f3->reroute('summary');
                }
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
            if (isset($_POST['indoorInts']))
            {
                $selectedIndoor = $_POST['indoorInts'];
            }
            else
            {
                $selectedIndoor = "";
            }
            if (isset($_POST['outdoorInts']))
            {
                $selectedOutoor = $_POST['outdoorInts'];
            }
            else
            {
                $selectedOutoor = "";
            }

            // validate the data
            $valid = true;
            if (!$this->_validator->validIndoor($selectedIndoor))
            {
                $valid = false;
                $this->_f3->set('errors["indoorInts"]', "Invalid choice(s)");
                // make the valid ones sticky
                $this->_f3->set('selectedIndoor', $selectedIndoor);
            } else {
                $this->_f3->set('selectedIndoor', $selectedIndoor);
            }

            if (!$this->_validator->validOutdoor($selectedOutoor))
            {
                $valid = false;
                $this->_f3->set('errors["outdoorInts"]', "Invalid choice(s)");
                // make the valid ones sticky
                $this->_f3->set('selectedOutdoor', $selectedOutoor);
            } else {
                $this->_f3->set('selectedOutdoor', $selectedOutoor);
            }

            if ($valid) {
                // store the data in the session array
                //$_SESSION['outdoorInts'] = $_POST['outdoorInts'];
                //$_SESSION['indoorInts'] = $_POST['indoorInts'];
                $_SESSION['member']->setIndoorInts($selectedIndoor);
                $_SESSION['member']->setOutdoorInts($selectedOutoor);

                //redirect to image page
                $this->_f3->reroute('image');
                //session_destroy();
            }
        }

        //if method is get display a page called interests.html
        $view = new Template();
        echo $view->render('views/interests.html');
    }

    /**
     * Display the profile image route
     * establish database connection and store image
     * to a folder and its filename to a database if chosen
     * route to summary
     */
    public function image()
    {
        try {
            //Create a new PDO connection
            $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected!";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        //echo "here in the controller image";
        $dirName = '../uploader/uploads/';
        $_SESSION['dirName'] = $dirName;
        //$target_file = $dirName . basename($_FILES["fileToUpload"]["name"]);
        //$uploadOk = 1;

        //echo realpath("test.txt");

        //echo $dirName;
        //var_dump($_FILES['fileToUpload']);
        //If file has been submitted
        if (isset($_FILES['fileToUpload'])) {

            $file = $_FILES['fileToUpload'];
            $_SESSION['member']->setImageId($file['name']);
            //echo $file['name'];

            //echo $file['name'].'<br>';
            //echo $file['type'].'<br>';
            //echo $file['tmp_name'].'<br>';
            //echo $file['error'].'<br>';
            //echo $file['size'].'<br>';

            // 264.JPG
            // image/jpeg
            // /tmp/phpCSZfKz
            // 0
            // 2632637

            //Define valid file types
            $validTypes = array('image/jpeg', 'image/jpg', 'image/png');

            //Check file size - 3 MB maximum
            if ($_SERVER['CONTENT_LENGTH'] > 3000000) {
                echo "<p class='error'>File is too large. Maximum file size is 3 MB.</p>";
            } //Check file type
            else if (in_array($file['type'], $validTypes)) {

                if ($file['error'] > 0)
                    echo "<p class='error'>Return Code: {$file['error']}</p>";

                //Check for duplicate file
                if (file_exists($dirName . $file['name'])) {
                    echo "<p class='error'>Error uploading: ";
                    echo $file['name'] . " already exists.</p>";
                } else {
                    //Move file to upload directory
                    move_uploaded_file($file['tmp_name'], $dirName . $file['name']);
                    echo "<p class='success'>Uploaded {$file['name']} successfully!</p> ";

                    // store the file name in the database
                    $sql = "INSERT INTO uploads(filename) VALUES ('{$file['name']}')";
                    $dbh->exec($sql);

                    // establish the $id number of the last insert
                    $id = $dbh->lastInsertId();
                    $_SESSION['id'] = $id;

                    //echo $id;

                    //echo $dir;

                    //Get names of files
                    //$sql = "SELECT * FROM uploads
                    //        WHERE file_id = $id";
                    //echo $sql;
                    //$result = $dbh->query($sql);
                    //var_dump($result);
                    //$img = $result['filename'];
                    //$_SESSION['img'] = $img;
                    //echo $file['name'];
                    //$_SESSION['member']->setImageId($file['name']);

                    //var_dump($result);
                    //redirect to image page
                    $this->_f3->reroute('summary');

                }
            }
            //Invalid file type
            else {
                echo "<p class='error'>Invalid file type. Allowed types: gif, jpg, png</p>";
            }
        }
        /*
         * Show each image
         */
        /*


        //Display images
        if (sizeof($result) >= 1) {
            foreach ($result as $row) {
                $img = $row['filename'];
                echo "<img class='img-thumbnail' src='$dirName$img' alt=''>";
            }
        }
        */

        $view = new Template();
        //var_dump($view);
        echo $view->render('views/imageUpload.php');
    }

    /**
     *
     */
    public function summary()
    {


        //Open file directory
        $dir = opendir($_SESSION['dirName']);
        //$id = $_SESSION['id'];
        //$img = $_SESSION['member']->getImageId();
        //$dirName = $_SESSION['dirName'];
        //echo "<img class='img-thumbnail' src='$dirName$img' alt=''>";

        // display the summary page
        $view = new Template();
        echo $view->render
        ('views/summary.php');
        session_destroy();
    }

}