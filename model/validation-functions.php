<?php

/* Define functions to validate data */
function validName($name)
{
    return !empty($name);
}

function validAge($age)
{
    return (is_numeric($age) && $age >= 18 && $age <= 118);
}

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

function validPhone($phoneNum)
{
    //echo $phoneNum;
    return (preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phoneNum) ||
        preg_match("/^[0-9]{10}$/", $phoneNum));
}

function validEMail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        return false;
    }
    return true;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

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

function validState($state)
{
    //$count = (count(array_intersect($_POST['indoorInts'], $indoorInts)));
    $states = getStates();
    return (in_array($state, $states) || ($state == 'none'));
}