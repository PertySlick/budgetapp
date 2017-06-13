<?php

/*
 * File Name: controller.php
 * Author: Timothy Roush and Jeff Pratt
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
 * @see IncomeItem.php
 * @see ExpenseItem.php
 */
class Controller {


// METHODS - MAIN ROUTE OPERATIONS
    

    /**
     * Handles all logic for the main home page.
     * @param $f3 Fat Free object
     */
    public function home($f3)
    {
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
        // Set array of months
        $months = array(
            'January' => '1',
            'February' => '2' ,
            'March' => '3',
            'April' => '4',
            'May' => '5',
            'June' => '6',
            'July' => '7',
            'August' => '8',
            'September' => '9',
            'October' => '10',
            'November' => '11',
            'December' => '12'
        );
        
        // Set array of years from 2016 to next year
        $years = array();
        for ($i = 2017; $i < date("Y") + 2; $i++) array_push($years, $i);
    
        if(empty($f3->get('currentYear'))) $f3->set('currentYear', date('Y'));
        if(empty($f3->get('currentMonth'))) $f3->set('currentMonth', date('m'));
        $currentMonth = $f3->get('currentMonth');
        $currentYear = $f3->get('currentYear');
        
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Your Summary',
            'description' => 'A Summary Of Your Overall Budget',
            'months' => $months,
            'years' => $years,
            'monthString' => date('F', strtotime('2000-' . $currentMonth . '-01'))
        ));
        
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('login');
        
        $operator = new DbOperator();
        
        $id = $_SESSION['user']->getID();
        
        // Grab total income by date
        $totalIncome = $operator->getTotalIncomeByDate($id, $currentMonth, $currentYear);
        $totalIncome = round($totalIncome);
        $f3->set('totalIncome', $totalIncome?$totalIncome:0);
        
        // Grab total expense by date
        $totalExpense = $operator->getTotalExpenseByDate($id, $currentMonth, $currentYear);
        $totalExpense = round($totalExpense);
        $f3->set('totalExpense', $totalExpense?$totalExpense:0);
        
        // Set Remaining amount (difference between income and expense)
        $f3->set('remaining', $totalIncome - $totalExpense);
        
        // Calculate bar graph width from income and expenses
        if ($totalExpense > 0 && $totalIncome > 0) {
            $f3->set('percentage', round(100 * ($totalExpense / $totalIncome)));
        } else {
            $f3->set('percentage', 0);
        }
        
        // Grab category totals
        $categoryTotals = $operator->getTotalExpenseByCategory($id, $currentMonth, $currentYear);
        if (!empty($categoryTotals)) {
            $f3->set('categoryTotals', $categoryTotals);
        } else {
            $categoryTotals = array(
                0 => array(
                    'expensetype' => 'No categories set for this period',
                    'total' => ''
                ));
            $f3->set('categoryTotals', $categoryTotals);
        }
        
        // Grab last 5 transactions
        $last5Entries = $operator->getTopFiveTransactionsByUserID($id);
        $f3->set('last5', $last5Entries);
        
        // Grab Last 3 expenses
        $last3Expenses = $operator->getTopThreeExpenseByUserID($id);
        $f3->set('last3Expenses', $last3Expenses);
        
        // Grab Last 3 incomes
        $last3Incomes = $operator->getTopThreeIncomesByUserID($id);
        $f3->set('last3Incomes', $last3Incomes);
    }
    
    
    /**
     * Processes a change in the requested time period of transaction data to
     * display.  If the month and year values are deemed valid they are set
     * to the fat free object before calling the main userHome() method.
     * 
     * @param $f3 Fat Free object
     * @param $params array of parameter values
     */
    public function userHomeParams($f3, $params) {
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('login');
        
        $month = $params['month'];
        $year = $params['year'];

        if ($year >= 2017 && $year <= date('Y') + 2) {
            $f3->set('currentYear', $params['year']);
            if ($month >= 1 && $month <= 12) {
                $f3->set('currentMonth', $params['month']);
            }
        }
        
        $this->userHome($f3);
    }
    
    
// METHODS - USER LOG IN/OUT OPERATIONS


// METHODS - INCOME TRANSACTION OPERATIONS


    /**
     *Get  all the income transactions and return as array of incomeItems to view
     */
    public function incomeOverview($f3){
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('login');
        
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Your Income',
            'description' => 'A Summary Of Your Income'
        ));
        
        $user = $_SESSION['user'];
        $userID = $user->getID();
        $operator = new DbOperator();        
        $results = $operator->getAllIncomeByUserID($userID);
        
        $f3->set("records",$results); 
    }


    /**
     * Handles all logic for the user adding income.
     * @param $f3 Fat Free object
     */
    public function addIncome($f3) {
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('login');
        
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Add An Income',
            'description' => 'Add A New Income',
            'action' => 'Create',
            'transactionType' => 'Income'
        ));
    }


    /**
     * Performs input santitation and validation when user submits form to add
     * an income transaction.  If validation succeeds the transaction is
     * creation completes and the user is rerouted to the user summary page.
     * Otherwise the same sticky form is loaded so that they may try again.
     */
    public function addIncomeSubmit($f3) {
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('login');
        
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Add An Income',
            'description' => 'Add A New Income',
            'action' => 'Create',
            'transactionType' => 'Income',
            'isErrors' => false
        ));
        
        // Set arrays of fields that must be alpha or numeric
        $alphas = array('description', 'type');
        $numerics = array('amount');
        
        // Grab User's ID
        $userID = $_SESSION['user']->getID();
        // Grab User input from POST
        $desc = $this->sanitize($_POST['description']);
        $type = $this->sanitize($_POST['type']);
        $amount = $this->sanitize($_POST['amount']);
        $date = $this->sanitize($_POST['date']);
        
        // Validate alpha and numeric fields
        $this->isAlpha($f3, $alphas);
        $this->isNumeric($f3, $numerics);

        // If no errors, move forward and reroute
        if ($f3->get('isErrors') === false) {
            $operator = new DbOperator();
            $record = $operator->addIncomeByUserID($userID,$desc,$type,$amount,$date);
            $f3->reroute('/income');
        } else {                            // Errors found, produce sticky form
            $transaction = array(
                'description' => $desc,
                'type' => $type,
                'date' => $date,
                'amount' => $amount);
            $f3->set('transaction', $transaction);
        }
    }


    /**
     * The initial modify transaction page before submittal.
     * 
     * Pulls the specified transaction record from the database and places the
     * current values into a sticky form for the user to modify as they wish.
     * 
     * @param $f3 Fat Free routing object
     * @param $params array of parameters passed via GET
     */
    public function editIncome($f3,$params){
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('login');
        
        $operator = new DbOperator();
        
        // Make sure transaction belongs to user
        $userID = $_SESSION['user']->getID();
        $transactionID = $params['id'];
        $isValid = $operator->validTransactionUser('income', $transactionID, $userID);
        if ($isValid === false) {
            die('(!) The requested record does not belong to you...');
        }
        
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Modify Income',
            'description' => 'Edit An Existing Income',
            'action' => 'Edit',
            'transactionType' => 'Income'
        ));
        
        // Grab transaction record from database
        $incomeID = $params['id'];
        $result = $operator->getIncomeByIncomeID($incomeID);
        
        $transaction = array(
            'description' => $result->getDescription(),
            'type' => $result->getCategory(),
            'date' => $result->getDateApplied(),
            'amount' => $result->getAmount());
        $f3->set('transaction', $transaction);
    }
    
    
    /**
     * Performs input santitation and validation when user submits form to edit
     * an income transaction.  If validation succeeds the transaction
     * modification completes and the user is rerouted to the user summary page.
     * Otherwise the same sticky form is loaded so that they may try again.
     * 
     * @param $f3 Fat Free routing object
     * @param $params array of parameters passed via GET
     */
    public function editIncomeSubmit($f3,$params){
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('login');
        
        $operator = new DbOperator();
        
        // Make sure transaction belongs to user
        $userID = $_SESSION['user']->getID();
        $transactionID = $params['id'];
        $isValid = $operator->validTransactionUser('income', $transactionID, $userID);
        if ($isValid === false) {
            die('(!) The requested record does not belong to you...');
        }
        
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Modify Income',
            'description' => 'Edit An Existing Income',
            'action' => 'Edit',
            'transactionType' => 'Income',
            'isErrors' => false
        ));
        
        // Set arrays of fields that must be alpha or numeric
        $alphas = array('description', 'type');
        $numerics = array('amount');
        
        // Grab POST and other necessary data
        $incomeID = $this->sanitize($params['id']);         // ID of transaction to edit
        $desc = $this->sanitize($_POST['description']);
        $type = $this->sanitize($_POST['type']);
        $amount = $this->sanitize($_POST['amount']);
        $date = $this->sanitize($_POST['date']);
        $user = $_SESSION['user'];          // Access SESSION User object
        $userID = $user->getID();           // Store User's ID
        
        // Validate alpha and numeric fields
        $this->isAlpha($f3, $alphas);
        $this->isNumeric($f3, $numerics);

        // If no errors, move forward and reroute
        if ($f3->get('isErrors') === false) {
            $record = $operator->editIncomeByIncomeID($incomeID, $desc, $type, $amount, $date);
            $f3->reroute('/income');
        } else {                            // Errors found, produce sticky form
            $transaction = array(
                'description' => $desc,
                'type' => $type,
                'date' => $date,
                'amount' => $amount);
            $f3->set('transaction', $transaction);
        }
    }


    /**
     *Remove the income record by incomeID
     */
    public function removeIncome($f3,$params){
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('login');
        
        $incomeID = $params['id'] ;
        $operator = new DbOperator();        
        $results = $operator->removeIncomeByID($incomeID);         
    }


// METHODS - EXPENSE TRANSACTION OPERATIONS


    /**
     *Getall the expense transactions and return as array of ExpenseItem to view
     */
    public function expenseOverview($f3){
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('login');
        
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Your Expenses',
            'description' => 'A Summary Of Your Expenses'
        ));
        
        $user = $_SESSION['user'];
        $userID = $user->getID();
        $operator = new DbOperator();        
        $results = $operator->getAllExpenseByUserID($userID);
        
        $f3->set("records",$results); 
    }


    /**
     * Handles all logic for the user adding income.
     * @param $f3 Fat Free object
     */
    public function addExpense($f3) {
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('login');
        
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Add An Expense',
            'description' => 'Add A New Expense',
            'action' => 'Create',
            'transactionType' => 'Expense'
        ));
    }


    /**
     * Performs input santitation and validation when user submits form to add
     * an expense transaction.  If validation succeeds the transaction is
     * creation completes and the user is rerouted to the user summary page.
     * Otherwise the same sticky form is loaded so that they may try again.
     */
    public function addExpenseSubmit($f3) {
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('login');
        
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Add An Expense',
            'description' => 'Add A New Expense',
            'action' => 'Create',
            'transactionType' => 'Expense',
            'isErrors' => false
        ));
        
        // Set arrays of fields that must be alpha or numeric
        $alphas = array('description', 'type');
        $numerics = array('amount');
        
        // Grab User's ID
        $userID = $_SESSION['user']->getID();
        // Grab User input from POST
        $desc = $this->sanitize($_POST['description']);
        $type = $this->sanitize($_POST['type']);
        $amount = $this->sanitize($_POST['amount']);
        $date = $this->sanitize($_POST['date']);
        
        // Validate alpha and numeric fields
        $this->isAlpha($f3, $alphas);
        $this->isNumeric($f3, $numerics);

        // If no errors, move forward and reroute
        if ($f3->get('isErrors') === false) {
            $operator = new DbOperator();
            $record = $operator->addExpenseByUserID($userID,$desc,$type,$amount,$date);
            $f3->reroute('/expense');
        } else {                            // Errors found, produce sticky form
            $transaction = array(
                'description' => $desc,
                'type' => $type,
                'date' => $date,
                'amount' => $amount);
            $f3->set('transaction', $transaction);
        }
    }


    /**
     * The initial modify transaction page before submittal.
     * 
     * Pulls the specified transaction record from the database and places the
     * current values into a sticky form for the user to modify as they wish.
     * 
     * @param $f3 Fat Free routing object
     * @param $params array of parameters passed via GET
     */
    public function editExpense($f3,$params){
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('/login');
        
        $operator = new DbOperator();
        
        // Make sure transaction belongs to user
        $userID = $_SESSION['user']->getID();
        $transactionID = $params['id'];
        $isValid = $operator->validTransactionUser('expense', $transactionID, $userID);
        if ($isValid === false) {
            die('(!) The requested record does not belong to you...');
        }
        
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Modify Expense',
            'description' => 'Edit An Existing Expense',
            'action' => 'Edit',
            'transactionType' => 'Expense'
        ));
        
        // Grab transaction record from database
        $expenseID = $params['id'];
        $result = $operator->getExpenseByExpenseID($expenseID);
        
        $transaction = array(
            'description' => $result->getDescription(),
            'type' => $result->getCategory(),
            'date' => $result->getDateApplied(),
            'amount' => $result->getAmount());
        $f3->set('transaction', $transaction);
    }


    /**
     * Performs input santitation and validation when user submits form to edit
     * an expense transaction.  If validation succeeds the transaction
     * modification completes and the user is rerouted to the user summary page.
     * Otherwise the same sticky form is loaded so that they may try again.
     * 
     * @param $f3 Fat Free routing object
     * @param $params array of parameters passed via GET
     */
    public function editExpenseSubmit($f3, $params) {
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('/login');
        
        $operator = new DbOperator();
        
        // Make sure transaction belongs to user
        $userID = $_SESSION['user']->getID();
        $transactionID = $params['id'];
        $isValid = $operator->validTransactionUser('expense', $transactionID, $userID);
        if ($isValid === false) {
            die('(!) The requested record does not belong to you...');
        }
        
        // Set environment tokens
        $f3->mSet(array(
            'title' => 'BudgetApp: Modify Expense',
            'description' => 'Edit An Existing Expense',
            'transactionType' => 'Expense',
            'isErrors' => false
        ));
        
        // Set arrays of fields that must be alpha or numeric
        $alphas = array('description', 'type');
        $numerics = array('amount');
        
        // Grab POST and other necessary data
        $expenseID = $this->sanitize($params['id']);         // ID of transaction to edit
        $desc = $this->sanitize($_POST['description']);
        $type = $this->sanitize($_POST['type']);
        $amount = $this->sanitize($_POST['amount']);
        $date = $this->sanitize($_POST['date']);
        $user = $_SESSION['user'];          // Access SESSION User object
        $userID = $user->getID();           // Store User's ID
        
        // Validate alpha and numeric fields
        $this->isAlpha($f3, $alphas);
        $this->isNumeric($f3, $numerics);

        // If no errors, move forward and reroute
        if ($f3->get('isErrors') === false) {
            $record = $operator->editExpenseByExpenseID($expenseID, $desc, $type, $amount, $date);
            $f3->reroute('/expense');
        } else {                            // Errors found, produce sticky form
            $transaction = array(
                'description' => $desc,
                'type' => $type,
                'date' => $date,
                'amount' => $amount);
            $f3->set('transaction', $transaction);
        }
    }


    /**
     *Remove the income record by incomeID
     */
    public function removeExpense($f3,$params){
        // If user is not already logged in, redirect
        if (!$this->checkLogin($f3)) $f3->reroute('{{ $f3->get("BASE") . "/login" }}');
        
        $incomeID = $params['id'] ;
        $operator = new DbOperator();        
        $results = $operator->removeExpenseByID($incomeID);         
    }


// METHODS - USER OPERATIONS


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
                $email = $result['email'];
                
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
     * Handles all logic for new user registration
     * @param $f3 Fat Free object
     */
    public function register($f3) {
        // If user is already logged in, redirect
        if ($this->checkLogin($f3)) $f3->reroute('userHome');
        
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
        // If user is already logged in, redirect
        if ($this->checkLogin($f3)) $f3->reroute('userHome');
        
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


// METHODS - SUB-ROUTINES (SERVER-SIDE VALIDATION)


    // Handles all validation of the registration form
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
            $this->postError($f3, 'email', 'This is not a valid email format');
        } else {
            if (!$this->uniqueEmail($email)) {
                $this->postError($f3, 'email', 'Email has already been registered');
            }
        }
        
        // Make sure password and verify are equal
        if (!$this->fieldsMatch($password, $verify)) {
            $this->postError($f3, 'password', 'Password and Verify values must match');
            $f3->set( 'isErrors', true );
            $f3->set( 'passwordError', 'Password and Verify values must match');
            $f3->set( 'verifyError', 'Password and Verify values must match');
        }
        
        // Make sure all required fields have values
        $this->checkRequired($f3, $fields);

    }


    // Clean input of all dangerous characters
    private function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    
    // Make sure all required fields have values.
    private function checkRequired($f3, $fields) {
        foreach ($fields as $field) {
            if (empty($f3->get($field))) {
                $this->postError($f3, $field, 'This is a required field');
            }
        }
    }


    // Validate fields that need numerical values
    private function isNumeric($f3, $fields) {
        foreach ($fields as $field) {
            if (!is_numeric($_POST[$field])) {
                $this->postError($f3, $field, 'This field may only contain numeric characters');
            }
        }
    }


    // Validate fields that need alphabetical values
    private function isAlpha($f3, $fields) {
        foreach ($fields as $field) {
            if (!ctype_alpha(str_replace(' ', '', $_POST[$field]))) {
                $this->postError($f3, $field, 'This field may only contain alphabetic characters');
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


    // Set Fat Free error status with error message
    private function postError($f3, $field, $message) {
        $f3->mSet(array(
            'isErrors' => true,
            $field . 'Error' => $message
            ));
    }
}