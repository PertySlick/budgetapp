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
 * @see CLASS
 * @see CLASS
 */
class Controller {


// METHODS - MAIN ROUTE OPERATIONS


    /**
     * TODO
     */
    public function home($f3) {
        $f3->mSet(array(
            'title' => 'BudgetApp',
            'description' => 'Welcome To BudgetApp'
        ));
    }
    
    
    public function login($f3) {
        // If user is already logged in, redirect
        if ($this->checkLogin($f3)) $f3->reroute('/');

        // If POST data indicates login attempt:
        if (isset($_POST['action']) && $_POST['action'] == "Log In") {
            $operator = new DbOperator();
            
            $email = $_POST['email'];
            $password = sha1($_POST['password']);
            $result = $operator->checkCredentials($email, $password);
            
            if ($result) {
                $userName = $result['userName'];
                $id = $result['id'];
                $email = $result['password'];
                $newUser = new User($userName, $id, $email);
                
                $_SESSION['userStatus'] = true;
                $_SESSION['user'] = $newUser;
                
                $f3->reroute('/');
            } else {
                echo "NOPE!";
            }
        }
    }
    
    
    public function logout($f3) {
        $f3->set('userStatus', false);
        session_destroy();
    }


    /**
     * Update the fat-free object to reflect the visitor's current member
     * status.  If the user is logged in, set a toggle and store Blogger data
     * @param $f3 fat-free instance to operate with
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
}