<?php

/* getMeals
 returns an array of meal options
 @return array
*/

function getIndoorInts()
{
    // create an array called indoorInts
    // set the hive variables
    $indoorInts = array('tv','puzzles','movies','reading','cooking','playing cards',
    'board games','video games');
    return $indoorInts;
}

function getOutdoorInts()
{
    // create an array called outdoorInts
    // set the hive variables
    $outdoorInts = array('hiking','walking','biking','climbing','swimming','collecting');
    return $outdoorInts;
}

function getStates()
{
    $states = array('Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado',
        'Connecticut', 'Delaware', 'District of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois',
        'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan',
        'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey',
        'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania',
        'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia',
        'Washington', 'West Virginia', 'Wisconsin', 'Wyoming',);

    return $states;
}