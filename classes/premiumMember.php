<?php

class PremiumMember extends Member
{

    // premium member fields
    private $_indoorInts;
    private $_outdoorInts;

    // constructor
    public function __construct($fname, $lname, $age, $gender, $phone, $indoorInts = "", $outdoorInts = "")
    {
        // call the parent constructor
        parent::__construct($fname, $lname, $age, $gender, $phone);

        $this->_indoorInts = $indoorInts;
        $this->_outdoorInts = $outdoorInts;
    }

    /**
     * @param string $indoorInts
     */
    public function setIndoorInts($indoorInts)
    {
        $this->_indoorInts = $indoorInts;
    }

    /**
     * @param string $outdoorInts
     */
    public function setOutdoorInts($outdoorInts)
    {
        $this->_outdoorInts = $outdoorInts;
    }

    // additional getters
    // getters for other fields are inherited
    /**
     * @return mixed
     */
    public function getIndoorInts()
    {
        return $this->_indoorInts;
    }

    /**
     * @return mixed
     */
    public function getOutdoorInts()
    {
        return $this->_outdoorInts;
    }
}