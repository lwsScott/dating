<?php


/* Define functions to validate contact data */

function validName($name)
{
    return !empty($name);
}

function Age($age)
{
    return (is_numeric($age) && $age > 0);
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

/*
function validLinkedIn($linkedIn)
{
    $website = test_input($linkedIn);

    if (!preg_match("/\b(?:(?:http?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
        return false;
    }
}
*/

function phoneNum($phoneNum)
{
    return (preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $phoneNum));
}

function validFormat($validFormat)
{
    if ($validFormat != "html" && $validFormat != "text")
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


$isValid = true;

//var_dump($_POST);

$errors = [];   //Initialize an errors array


if(validName($_POST['firstName']))
{
    $fname = $_POST['firstName'];
}
else
{
    $errors[] = 'First name is required';
    //echo "<p>First name is required<br></p>";
    $isValid = false;
}

if(validName($_POST['lastName']))
{
    $lname = $_POST['lastName'];
}
else
{
    $errors[] = 'Last name is required';
    //echo "<p>Last name is required</p>";
    $isValid = false;
}


// check Email if Mailing List is checked
if (isset($_POST['mailList']))
{
    if (validEMail($_POST['Email']))
    {
        $Email = $_POST['Email'];
    } else
    {
        $errors[] = 'A valid Email is required to be put on the Mailing List';
        //echo "<p>A valid Email is required to be put on the Mailing List.</p>";
        $isValid = false;
    }
}
else
{
    $Email = $_POST['Email'];
    if($Email != "")
    {
        if (!validEMail($Email))
        {
            $errors[] = 'Email is not a valid address';
            //echo "<p>Email is not a valid address</p>";
            $isValid = false;
        }
    }
}

if ($_POST['linkedIn'] != "")
{
    if (validLinkedIn($_POST['linkedIn']))
    {
        $linkedIn = $_POST['linkedIn'];
    } else
    {
        $errors[] = 'LinkedIn is invalid address';
        //echo "<p>LinkedIn is invalid address</p>";
        $isValid = false;
    }
}
else
{
    $linkedIn = "";
}


if (isset($_POST['met']) && validMet($_POST['met']))
{
    $met = $_POST['met'];
}
else
{
    $errors[] = 'Please tell me how we met.  It\'s required';
    //echo "<p>Please tell me how we met.  It's required</p>";
    $isValid = false;

}

if (validFormat($_POST['format']))
{
    $format = $_POST['format'];
}
else
{
    $errors[] = 'Valid formats are HTML and Text';
    //echo "<p>Valid formats are HTML and Text</p>";
    $isValid = false;
}

