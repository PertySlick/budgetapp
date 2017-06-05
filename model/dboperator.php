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
        $stmt = $this->_conn->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
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
    
    
    /**
     * Determines if the supplied email address exists in the database.
     * Intended to be used as a registration form check to make sure email
     * entered is unique.
     * @param $email String email address to search database for
     */
    public function emailExists($email) {
        $stmt = $this->_conn->prepare('SELECT COUNT(*) as count FROM users WHERE email=:email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($results['count'] > 0) return true;
        else return false;
    }
    
    
    /**
     * Creates a new user record in the database with the supplied information.
     */
    public function addUser($userName, $email, $password) {
        $stmt = $this->_conn->prepare('INSERT INTO users ' .
                                      '(userName, email, password) ' .
                                      'VALUES (:userName, :email, :password) ');
        $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', sha1($password), PDO::PARAM_STR);
        
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die ("(!) There was an error adding " . $userName . " to the database... " . $e);
        }
        
        return $this->_conn->lastInsertId();
    }


// METHODS - TRANSACTION OPERATIONS

    /**
     * Creates a new income record for user
     */
    public function addIncomeByUserID($userID,$desc,$type,$amount,$frequency,$date){
        $stmt = $this->_conn->prepare('INSERT INTO incomeDtl ' .
                                      '(description, incometype, amount,frequency,user_userID, effectivedate) ' .
                                      'VALUES (:desc, :type, :amount, :frequency, :user_userID, :effectivedate) ');
        $stmt->bindParam(':desc', $desc , PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindParam(':frequency', $frequency, PDO::PARAM_STR);
        $stmt->bindParam(':user_userID', $userID, PDO::PARAM_STR);
        $stmt->bindParam(':effectivedate', $date, PDO::PARAM_STR);
        
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die ("(!) There was an error adding income of amount " . $amount . " to the database... " . $e);
        }        
        return $this->_conn->lastInsertId();
    }
    
    /**
     * Retrieves all income records for user
     */
    public function getAllIncomeByUserID($userID){
        $stmt = $this->_conn->prepare('SELECT * FROM incomeDtl WHERE user_userID = :user_userID');
        $stmt->bindParam(':user_userID', $userID, PDO::PARAM_STR);
        
        try {
            $results = $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $resultArray =  [];
            foreach($results as $row){
                //assign properties of class to variable
                $incomeID = $row['incomeid'];
                $desc = $row['description'];
                $incomeType = $row['incometype'];
                $amount = $row['amount'];
                $userID = $row['user_userID'];
                $effectiveDate = $row['effectiveDate'];                
                //create new incomeitem object 
                $income = new incomeItem ($amount,$incomeType,date('m-d-Y'),$effectiveDate);
                //add object to array
                $resultArray.push($income);                
            }
            
            return $resultArray;
        
        } catch (PDOException $e) {
            die ("(!) There was an error adding income of amount " . $amount . " to the database... " . $e);
        }        
        return $this->_conn->lastInsertId();
        
    }

}