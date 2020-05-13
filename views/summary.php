<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
//session_start();
?>
<!--
  Lewis Scott
  5/1/20
  filename https://lscott.greenriverdev.com/328/dating/views/summary.html
  accessed through https://lscott.greenriverdev.com/328/dating/interests
  Home page view site
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thank you</title>
    <include href="includes/header.html"></include>
    </head>
<body>

<include href="includes/navBar.html"></include>


<div class="container card rounded">

    <div class="row">
        <div class="col-6">
            <p class="card mb-0 ml-3 mt-3 p-2">Name: {{ @SESSION.firstName }} {{ @SESSION.lastName }}</p>
            <p class="card mb-0 ml-3 p-2">Age: {{ @SESSION.age }}</p>
            <p class="card mb-0 ml-3 p-2">Gender: {{ @SESSION.gender }}</p>
            <p class="card mb-0 ml-3 p-2">Phone Number: {{ @SESSION.phone }}</p>
            <p class="card mb-0 ml-3 p-2">E-Mail : {{ @SESSION.email }}</p>
            <p class="card mb-0 ml-3 p-2">State : {{ @SESSION.state }}</p>
            <p class="card mb-0 ml-3 p-2">Seeking : {{ @SESSION.seeking }}</p>
            <p class="card mb-0 ml-3 p-2">Interests :
                <check if="{{ isset(@SESSION.indoorInts) }}">
                    {{ implode(@SESSION.indoorInts, ' ') }}
                </check>
                <check if="{{ isset(@SESSION.outdoorInts) }}">
                    {{ implode(@SESSION.outdoorInts, ' ') }}
                </check>

            </p>
        </div>

        <div class="col-6">
            <img class="img-fluid rounded" src="images/homePageImage.png" alt="image">
            <p>Biography</p>
            <p> {{ @SESSION.bio }}</p>

        </div>
    </div>

    <div class="text-center ml-3 mr-3">
        <!--<form action="#" method="get">-->
            <button class="btn btn-primary text-center m-3" type="submit">Contact Me!</button>
       <!-- </form>-->
    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>