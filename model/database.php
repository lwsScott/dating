<?php
/*
 * Database Class for dating website
 * provides connection to database
 * additional functions will be to store and retrieve from database
 * 5/30/20
 * filename https://lscott.greenriverdev.com/328/dating/model/database.php
 * @author Lewis Scott
 * @version 1.0
 */

//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '/home2/lscottgr/config.php';


/*
 * Class Database
 * constructs database object
 * additional functions will include storage and retrieval methods
 * 5/30/20
 * @author Lewis Scott
 * @version 1.0
 */
class Database
{
    //PDO object
    private $_dbh;

    function __construct()
    {
        try {
            //Create a new PDO connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected!";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



}