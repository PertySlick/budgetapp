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
    
    // Logged in user's main summary page
    $f3->route('GET /userHome', function($f3) use ($controller) {
      $controller->userHome($f3);
      echo \Template::instance()->render('view/summary.html');
    });
    
    // Logged in user's income summary
    $f3->route('GET /income', function($f3) use ($controller) {
      $controller->income($f3);
      echo \Template::instance()->render('view/home.html');
    });
    
    // Logged in user's expense summary
    $f3->route('GET /expense', function($f3) use ($controller) {
      $controller->expense($f3);
      echo \Template::instance()->render('view/home.html');
    });
    
    // Logged in user's budget summary
    $f3->route('GET /budget', function($f3) use ($controller) {
      $controller->budget($f3);
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
      echo \Template::instance()->render('view/addexpense.html');
    });
    
    //post method to add expense
      $f3->route('POST /addexpense', function($f3) use ($controller) {
      $controller->addExpense($f3);
      echo \Template::instance()->render('view/addexpense.html');
    });
     
    
    // Allow user to create a new income item
    $f3->route('GET /addincome', function($f3) use ($controller) { 
      echo \Template::instance()->render('view/addincome.html');
    });
    
 
    
    //Posting new income item
    $f3->route('POST /addincome', function($f3) use ($controller) {
    $controller->addIncome($f3);
     echo \Template::instance()->render('view/addincome.html');
    });
    
    // Allow user to create a new income item
    $f3->route('GET /editincome/@id', function($f3,$params) use ($controller) {
    $controller->editIncome($f3,$params);
    echo \Template::instance()->render('view/editincome.html');
    });

    //show income overview page
     $f3->route('GET @incomeOverview: /incomeoverview', function($f3) use ($controller) {
    $controller->incomeOverview($f3);
    echo \Template::instance()->render('view/incomeoverview.html');
    });
    
    //remove an income record and reroute to income overview
    $f3->route('GET /removeIncome/id=@id', function($f3,$params) use ($controller) {
    $controller->removeIncome($f3,$params);
    $f3->reroute('@incomeOverview');
    });

    

    // Allow visitor to register as a new user
    $f3->route('GET /signup', function($f3) use ($controller) {
      $controller->register($f3);
      echo \Template::instance()->render('view/signup.html');
    });
    
    // Registration form after a submit attempt
    $f3->route('POST /signup', function($f3) use ($controller) {
      $controller->registerSubmit($f3);
      echo \Template::instance()->render('view/signup.html');
    });
    
    // Site visitors want to learn more about us
    $f3->route('GET /about', function($f3) use ($controller) {
      $controller->about($f3);
      echo \Template::instance()->render('view/home.html');
    });
        
      
    // Execute Route
    
    
    $f3->run();