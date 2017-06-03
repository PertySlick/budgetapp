<?php

/*
 * File Name: index.php
 * Author: Timothy Roush & Jeff Pratt
 * Date Created: 5/28/17
 * Assignment: Final Budget App
 * Description:  Main Routing Component Of MVC Architecture
 */

/**
 * Defines all routes and makes all calls to the Controller object to complete
 * them.
 *
 * @author Timothy Roush
 * @author Jeff Pratt
 * @copyright 2017
 * @version 1.0
 */

    // Dependancy And Session Initialization
    require_once ('vendor/autoload.php');
    session_start();
    
    // Initiate fat-free, and Controller objects and set defaults
    $f3 = Base::instance();                 // Instance of Fat Free object
    $f3->set('DEBUG', 3);                   // Set Fat Free debug level
    $controller = new Controller();         // MVC Controller object
    $f3->set('fontAwesome', false);         // Should include load fontAwesome?

    // Check if visitor is logged in
    $controller->checkLogin($f3);
    
    
    // Begin Route Definitions

    
    // Default route - main home page
    $f3->route('GET /', function($f3) use ($controller) {
      $controller->home($f3);
      echo \Template::instance()->render('view/home.html');
    });
    
    // User log in and authentication
    $f3->route('GET|POST /login', function($f3) use ($controller) {
      $controller->login($f3);
      echo \Template::instance()->render('view/login.html');
    });
    
    // User log out and de-authentication
    $f3->route('GET /logout', function($f3) use ($controller) {
        $controller->logout($f3);
        $f3->reroute('/');
    });
    
    // Allow user to create a new expense item
    $f3->route('GET /addexpense', function($f3) use ($controller) {
      $controller->home($f3);
      echo \Template::instance()->render('view/addexpense.html');
    });
    
    // Allow user to create a new income item
    $f3->route('GET /addincome', function($f3) use ($controller) {
      $controller->home($f3);
      echo \Template::instance()->render('view/addincome.html');
    });
    
    // Allow visitor to register as a new user
    $f3->route('GET|POST /signup', function($f3) use ($controller) {
      $controller->register($f3);
      echo \Template::instance()->render('view/signup.html');
    });
        
      
    // Execute Route
    
    
    $f3->run();