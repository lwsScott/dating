<?php
/*
 * Premium Member class page for dating website
 * 5/30/20
 * filename https://lscott.greenriverdev.com/328/dating/classes/premiumMember.php
 * @author Lewis Scott
 * @version 1.0
 */

/*
 * Premium Member class for dating website
 * stores additional interests and image information
 * 5/30/20
 * @author Lewis Scott
 * @version 1.0
 */
class PremiumMember extends Member
{

    // premium member fields
    private $_indoorInts;
    private $_outdoorInts;
    private $_imageId;

    // constructor
    public function __construct($fname, $lname, $age, $gender, $phone, $indoorInts = "", $outdoorInts = "", $imageId = "")
    {
        // call the parent constructor
        parent::__construct($fname, $lname, $age, $gender, $phone);

        $this->_indoorInts = $indoorInts;
        $this->_outdoorInts = $outdoorInts;
        $this->_imageId = $imageId;
    }

    /**
     * @return string
     */
    public function getImageId()
    {
        return $this->_imageId;
    }

    /**
     * @param string $imageId
     */
    public function setImageId($imageId)
    {
        $this->_imageId = $imageId;
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
?>