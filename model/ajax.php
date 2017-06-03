<?php

/*
 * File Name: ajax.php
 * Author: Timothy Roush
 * Date Created: 6/2/17
 * Assignment: Final Budget App
 * Description:  Model MVC Component - Handles Database Operations For AJAX Calls
 */

 // Database connection object
 $conn = constructPDO();
 
if (isset($_POST['action']) && !empty($_POST['action'])) {
   $action = $_POST['action'];
   $action($conn);
}



function constructPDO() {
    // Require Configuration File
    // IMPORTANT: For this assignment store credentials in the following path:
    //      home/username/secure/credentials_budgetapp.inc.php
    require_once '../../../../secure/credentials_budgetapp.inc.php';
    
    // Establish Database Connection And Set Attributes
    try {
        $newConnection = new PDO( DB_DSN, DB_USER, DB_PASSWORD );
        $newConnection->setAttribute( PDO::ATTR_PERSISTENT, true );
        $newConnection->setAttribute(
            PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
        );
    } catch ( PDOException $e ) {
        die( "(!) Error - Connection Failed: " . $e->getMessage() );
    }
    
    return $newConnection;
    }


function emailExists($conn) {
    $stmt = $conn->prepare('SELECT COUNT(*) as count FROM users WHERE email=:email');
    $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($results['count'] > 0) echo 'true';
    else echo 'false';
}

