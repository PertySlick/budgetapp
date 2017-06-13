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
    
    // Logged in user's main summary page by time period
    $f3->route('GET /userHome/@year/@month', function($f3, $params) use ($controller) {
        $controller->userHomeParams($f3, $params);
        echo \Template::instance()->render('view/summary.html');
    });
    
    // Logged in user's income summary
    $f3->route('GET /income', function($f3) use ($controller) {
        $controller->incomeoverview($f3);
        echo \Template::instance()->render('view/incomeoverview.html');
    });
    
    // Logged in user's expense summary
    $f3->route('GET /expense', function($f3) use ($controller) {
        $controller->expenseoverview($f3);
        echo \Template::instance()->render('view/expenseoverview.html');
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
        $controller->addExpense($f3);
        echo \Template::instance()->render('view/transaction.html');
    });
    
    // Allow user to create a new expense item
    $f3->route('POST /addexpense', function($f3) use ($controller) {
        $controller->addExpenseSubmit($f3);
        echo \Template::instance()->render('view/transaction.html');
    });
    
    //remove an expense
    $f3->route('GET /removeExpense/id=@id', function($f3,$params) use ($controller) {
        $controller->removeExpense($f3,$params);
        $f3->reroute('/expense');
    });
     
    //edit an expense
    $f3->route('GET /editExpense/id=@id', function($f3,$params) use ($controller) {
        $controller->editExpense($f3,$params);
        echo \Template::instance()->render('view/transaction.html');
    });

    //edit an expense
    $f3->route('POST /editExpense/id=@id', function($f3,$params) use ($controller) {
        $controller->editExpenseSubmit($f3,$params);
        echo \Template::instance()->render('view/transaction.html');
    });
    
    // Allow user to create a new income item
    $f3->route('GET /addincome', function($f3) use ($controller) {
        $controller->addIncome($f3);
        echo \Template::instance()->render('view/transaction.html');
    });
    
    //Posting new income item
    $f3->route('POST /addincome', function($f3) use ($controller) {
        $controller->addIncomeSubmit($f3);
        echo \Template::instance()->render('view/transaction.html');
    });
    
    // Allow user to edit an income item
    $f3->route('GET /editincome/id=@id', function($f3,$params) use ($controller) {
        $controller->editIncome($f3,$params);
        echo \Template::instance()->render('view/transaction.html');
    });
    
    // Allow user to edit an income item
    $f3->route('POST /editincome/id=@id', function($f3,$params) use ($controller) {
        $controller->editIncomeSubmit($f3,$params);
        echo \Template::instance()->render('view/transaction.html');
    });
    
    //remove an income record and reroute to income overview
    $f3->route('GET /removeIncome/id=@id', function($f3,$params) use ($controller) {
        $controller->removeIncome($f3,$params);
        $f3->reroute('/income');
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
        echo \Template::instance()->render('view/aboutus.html');
    });
        
      
    // Execute Route
    
    
    $f3->run();