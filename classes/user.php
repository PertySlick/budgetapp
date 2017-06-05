<?php

/*
 * File Name: budgetitem.php
 * Author: Timothy Roush
 * Date Created: 6/02/17
 * Assignment: Final Budget App
 * Description: Represents an budget transaction/restriction
 */

/**
 * An object representing a user within the budgetapp site.  This object stores
 * specific data for the currently logged in user.
 *
 * @author Timothy Roush
 * @copyright 2017
 * @version 1.0
 */
class User {


// CONSTRUCTOR
    
    protected $userName;
    protected $id;
    protected $email;

    /**
     * Constructs an instance of this object with the base required information.
     * @param $userName String current user's name
     * @param $id int current user's database record number
     * @param $email String current user's email address
     */
    public function __contruct($userName, $id, $email) {
        $this->setuserName($value);
        $this->setID($id);
        $this->setEmail($email);
    }


// METHODS - SETTERS


    /**
     * Returns the user name value stored for this user.
     * @return String user name
     */
    public function getUserName() {
        return $this->userName;
    }
    
    
    /**
     * Returns the database record number of this user.
     * @return int database record number / user id
     */
    public function getID() {
        return $this->id;
    }
    
    
    /**
     * Returns the email address for this user.
     * @return String user's email address
     */
    public function getEmail() {
        return $this->email;
    }


// METHODS - SETTERS


    /**
     * Sets the user name of this user to the supplied string value.  If a null
     * value is supplied, a default user name of "User" is applied instead.
     * @param $value String user name
     */
    public function setUserName($value) {
        if ($value === null) $value = "User";
        $this->userName = $value;
    }
    
    
    /**
     * Sets the id value for this user to the supplied value.  Supplied value
     * must be a numerical record number from the database.
     * @param $value int database record number for this user
     */
    public function setID($value) {
        if (!is_numeric($value)) die("setID() only accepts a numerical ID value");
        $this->id = $value;
    }
    
    
    /**
     * Sets the email of this user to the supplied value.
     * @param $value String user email address
     */
    public function setEmail($value) {
        $this->email = $value;
    }
}