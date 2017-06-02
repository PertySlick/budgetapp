<?php

/*
 * File Name: dboperator.php
 * Author: Timothy Roush
 * Date Created: 5/28/17
 * Assignment: Final Budget App
 * Description:  Model MVC Component - Handles Database Operations
 */

/**
 * DbOperator represents an instance of a "model" component of the MVC style
 * architecture.  This class handles any and all database interaction
 * operations at the request of the controller component.  Class employs PDO
 * SQL queries and statements to sanitize inputs as they are entered into the
 * database.  Operator designed to always be passing either system determined
 * integer values or CLASS/CLASS objects to and from methods where ever
 * possible.  This operator will only work with the CLASS and CLASS classes.
 *
 * @author Timothy Roush
 * @copyright 2017
 * @version 1.0
 * @see CLASS
 * @see CLASS
 */
class DbOperator
{


// FIELDS - CONSTANTS AND OBJECTS


    private $_conn;                 // Database Connection Object


// CONSTRUCTOR


    /**
     * Creates an instance of a database interaction object.  Requires access
     * to an externally stored credentials file for accessing the database.
     * @throws PDOException if error encountered while establishing connection
     */
    public function __construct()
    {
        // Require Configuration File
        // IMPORTANT: For this assignment store credentials in the following path:
        //      home/username/secure/credentials_budgetapp.inc.php
        require_once '../../../secure/credentials_budgetapp.inc.php';
        
        // Establish Database Connection And Set Attributes
        try {
            $this->_conn = new PDO( DB_DSN, DB_USER, DB_PASSWORD );
            $this->_conn->setAttribute( PDO::ATTR_PERSISTENT, true );
            $this->_conn->setAttribute(
                PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
            );
        } catch ( PDOException $e ) {
            die( "(!) Error - Connection Failed: " . $e->getMessage() );
        }
    }


// METHODS - USER OPERATIONS


    /**
     * Checks the supplied credential against the records stored in th users
     * database.  If a record is found with a matching email address, the data
     * for that record is retrieved.  The password values are then compared. If
     * they match, an array of user data is then returned for Controller use.
     * @param $email String email used in login attempt
     * @param $password String hashed value of password used in login attempt
     * @return array of user data if validated, null otherwise
     */
    public function checkCredentials($email, $password) {
        echo $email . $password;
        $stmt = $this->_conn->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo 'Password entered: ' . $password . "Password stored: " . $result['password'];
            if ($password === $result['password']) {
                return array(
                'userName' => $result['userName'],
                'id' => $result['id'],
                'email' => $result['email']
                );
            }
        }
        return null;
    }


// METHODS - TRANSACTION OPERATIONS

}