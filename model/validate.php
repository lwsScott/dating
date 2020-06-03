<?php
/*
 * Validation Class for dating website
 * provides validation functions
 * 5/30/20
 * filename https://lscott.greenriverdev.com/328/dating/model/validate.php
 * @author Lewis Scott
 * @version 1.0
 */

/**
 * Class Validate
 * Contains the validation methods for my app
 * @author Lewis Scott
 * @version 1.0
 */
class Validate
{
    /* Define functions to validate data */
    function validName($name)
    {
        return !empty($name);
    }

    // validate Age between 18 and 118 inclusive
    function validAge($age)
    {
        return (is_numeric($age) && $age >= 18 && $age <= 118);
    }

    // validate Gender (it's binary)
    function validGender($gender)
    {
        if ($gender != 'male' && $gender != 'female')
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    // validate phone number either 10 digits or 3-3-4 digits
    function validPhone($phoneNum)
    {
        //echo $phoneNum;
        return (preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phoneNum) ||
            preg_match("/^[0-9]{10}$/", $phoneNum));
    }

    // validate e-mail using php function
    function validEMail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }
        return true;
    }

    // future functionality
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // validate outdoor interests - not required, just in allowed list
    function validOutdoor($outdoorInts)
    {
        //$count = (count(array_intersect($_POST['outdoorInts'], $outdoorInts)));
        $ints = getOutdoorInts();
        //echo implode(', ', $outdoorInts);
        //echo "the count is " . count(array_diff($indoorInts, $ints));
        if (!empty($outdoorInts)) {
            //echo "here in ";
            if (count(array_diff($outdoorInts, $ints)) != 0) {
                return false;
            }
        }
        return true;
    }

    // validate indoor interests - not required, just in allowed list
    function validIndoor($indoorInts)
    {
        //$count = (count(array_intersect($_POST['indoorInts'], $indoorInts)));
        //var_dump($_POST);
        $ints = getIndoorInts();
        //echo implode(', ', $ints). "<br>";
        //echo implode(', ', $indoorInts) . "<br>";
        //echo implode(',', array_diff($indoorInts, $ints)). "<br>";
        //echo "the count is " . count(array_diff($indoorInts, $ints)). "<br>";
        if (!empty($indoorInts)) {
            //echo "here in ";
            if (count(array_diff($indoorInts, $ints)) != 0) {
                return false;
            }
        }
        return true;
    }

    // validate state - not required, just in allowed list
    function validState($state)
    {
        //$count = (count(array_intersect($_POST['indoorInts'], $indoorInts)));
        $states = getStates();
        return (in_array($state, $states) || ($state == 'none'));
    }
}