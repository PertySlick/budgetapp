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
        // TODO
    }


    /**
     * Update the fat-free object to reflect the visitor's current member
     * status.  If the user is logged in, set a toggle and store Blogger data
     * @param $f3 fat-free instance to operate with
     */
    public function checkLogin($f3) {
        if ($_SESSION['user'] === true) {
            $f3->set('user', true);
            $f3->set('current', $_SESSION['current']);
        } else {
            $f3->set('user', false);
        }
    }
}