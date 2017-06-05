<?php

/*
 * File Name: controller.php
 * Author: Timothy Roush
 * Date Created: 5/28/17
 * Assignment: Final Budget App
 * Description: Controller Component Of MVC Architecture
 */

/**
 * Provides a separation of logic and output for the Budget App site.
 * Processes and prepares all data required to produce each view in the routing
 * document
 *
 * @author Timothy Roush
 * @copyright 2017
 * @version 1.0
 * @see DbOperator.php
 * @see index.php
 * @see User.php
 * @see BudgetItem.php
 * @see IncomeItem.php
 * @see ExpenseItem.php
 */
class Controller {


// METHODS - MAIN ROUTE OPERATIONS
    

    /**
     * Handles all logic for the main home page.
     * @param $f3 Fat Free object
     */
    public function home($f3) {
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp',
            'description' => 'Welcome To BudgetApp'
        ));
    }
    
    
    /**
     * Handles all logic for the about us page.
     * @param $f3 Fat Free object
     */
    public function about($f3) {
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: About Us',
            'description' => 'Learn More About BudgetApp'
        ));
    }
    
    
    /**
     * Handles all logic for the user main summary page.
     * @param $f3 Fat Free object
     */
    public function userHome($f3) {
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Your Summary',
            'description' => 'A Summary Of Your Overall Budget'
        ));
    }
    
    
    /**
     * Handles all logic for the user income summary page.
     * @param $f3 Fat Free object
     */
    public function income($f3) {
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Your Income',
            'description' => 'A Summary Of Your Income'
        ));
    }
    /**
     * Handles all logic for the user adding income.
     * @param $f3 Fat Free object
     */
    public function addIncome($f3) {
     $desc = $_POST['description'];
     $type = $_POST['type'];
     $amount = $_POST['amount'];
     $frequency = $_POST['amount'];
     $date = $_POST['date'];
     $user = $_SESSION['user'];
     $userID = $user->getID();
     
     var_dump($desc.$type.$amount.$frequency.$date.$userid);
     echo("userId: ".$userID);
     var_dump($_SESSION);
     
     $operator = new DbOperator();
     $operator->addIncomeByUserID($userID,$desc,$type,$amount,$frequency,$date);
     
     $printStr = $operator->getAllIncomeByUserID($userID);
     
     var_dump($printStr);
  
    }

    
    
    /**
     * Handles all logic for the user expense summary page.
     * @param $f3 Fat Free object
     */
    public function expense($f3) {
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Your Expense',
            'description' => 'A Summary Of Your Expense'
        ));
    }
    
    
    /**
     * Handles all logic for the user budget summary page.
     * @param $f3 Fat Free object
     */
    public function budget($f3) {
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Your Budget',
            'description' => 'A Summary Of Your Budget'
        ));
    }


    /**
     * Handles all logic for new user registration
     * @param $f3 Fat Free object
     */
    public function register($f3) {
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp - New User',
            'description' => 'Join to start budgeting today!'
        ));
    }
    
    
    /**
     * Registration logic after an attempted form submittal
     * @param $f3 Fat Free object
     */
    public function registerSubmit($f3) {
        $this->register($f3);
        $this->validateRegistration($f3);
        
        // If input passed validation add user and reroute
        if (!$f3->get('isErrors')) {
            $operator = new DbOperator();
            
            $id = $operator->addUser($f3->get('userName'),
                                     $f3->get('email'),
                                     $f3->get('password'));
            
            $newUser = new User($f3->get('userName'), $id, $f3->get('email'));
            $_SESSION['userStatus'] = true;
            $_SESSION['user'] = $newUser;
            $f3->reroute('login');
        }
    }
    
    
    /**
     * Handles all logic for user authentication and "logging in" to the site.
     * Email and password values entered by user are checked against the users
     * table in the database.  If a matching email is found with a matching
     * password, the user is tagged as "authenticated" and a User object with
     * their data is stored in the SESSION.
     */
    public function login($f3) {
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp - User Login',
            'description' => 'Login to get budgeting!'
        ));
        
        // If user is already logged in, redirect
        if ($this->checkLogin($f3)) $f3->reroute('/');

        // If POST data indicates login attempt:
        if (isset($_POST['action']) && $_POST['action'] == "Log In") {
            // Instantiate database operator
            $operator = new DbOperator();
            
            // Verify entered credentials
            $email = $_POST['email'];
            $password = sha1($_POST['password']);
            $result = $operator->checkCredentials($email, $password);
            
            // If credentials are valid
            if ($result) {
                $userName = $result['userName'];
                $id = $result['id'];
                $email = $result['password'];
                
                // Create a user object and store in SESSION
                $newUser = new User($userName, $id, $email);
                $_SESSION['user'] = $newUser;
                
                // Set user status toggle in SESSION
                $_SESSION['userStatus'] = true;
                
                // Reroute user after successfull login
                $f3->reroute('userHome');
            }
        }
        
        // If authentication failed, make email field "sticky"
        if (isset($_POST['email'])) {
            $f3->set('email', $_POST['email']);
        }
    }
    
    
    /**
     * Handles all logic for user log out.  Destroys SESSION and all values
     * stored within, thus de-authenticating the user.
     * @param $f3 Fat Free object
     */
    public function logout($f3) {
        session_destroy();
    }


    /**
     * Update the fat-free object to reflect the visitor's current member
     * status.  If the user is logged in, set a toggle and store Blogger data
     * @param $f3 Fat Free object
     */
    public function checkLogin($f3) {
        if ($_SESSION['userStatus'] === true) {
            $f3->set('userStatus', true);
            return true;
        } else {
            $f3->set('userStatus', false);
            return false;
        }
    }


// METHODS - SECONDARY


    private function validateRegistration($f3) {
        $fields = array("userName", "password", "verify", "email");
        
        // Build initial data and error tokens while sanitizing values
        foreach ($fields as $field) {
            ${$field . "Error"} = "";
            $$field = $this->sanitize($_POST[$field]);
            $f3->set($field, $$field);
        }

        // Email field validation
        if (!$this->validEmail($email)) {
            $f3->set( 'isErrors', true );
            $f3->set( 'emailError', 'This is not a valid email format');
        } else {
            if (!$this->uniqueEmail($email)) {
                $f3->set( 'isErrors', true );
                $f3->set( 'emailError', 'Email has already been registered');
            }
        }
        
        // Make sure password and verify are equal
        if (!$this->fieldsMatch($password, $verify)) {
            $f3->set( 'isErrors', true );
            $f3->set( 'passwordError', 'Password and Verify values must match');
            $f3->set( 'verifyError', 'Password and Verify values must match');
        }
        
        // Make sure all required fields have values
        $this->checkRequired($f3, $fields);

    }


// METHODS - SUB-ROUTINES (SERVER-SIDE VALIDATION)


    // Clean input of all dangerous characters
    private function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    
    // Make sure all required fields have values.
    // $fields is an array of strings (field names)
    private function checkRequired($f3, $fields) {
        foreach ($fields as $field) {
            if (empty($f3->get($field))) {
                $f3->set( 'isErrors', true );
                $f3->set( $field . "Error", "This is a required field");
            }
        }
    }
    
    
    // Make sure email format is valid
    private function validEmail($email) {
        $pattern = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
        else return true;
    }
    
    
    // Make sure email is not already registered
    private function uniqueEmail($email) {
        $operator = new DbOperator();

        if (($operator->emailExists($email))) return false;
        else return true;
    }
    
    
    // Make sure two non-empty values match each other (password/verify)
    private function fieldsMatch($field1, $field2) {
        return $field1 == $field2;
    }
}