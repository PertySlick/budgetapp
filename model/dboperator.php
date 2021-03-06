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
     * @param $userID ID of user stored in session.
     * @param $desc String  description of income
     * @param $type String description of type of income.
     * @param $frequency String how frequent the income is obtained.
     * @param $date Date the date of the income posted.
     * @return $ 
     */
    public function addIncomeByUserID($userID,$desc,$type,$amount,$date){
        $today = date('Y-m-d H:i:s');
        $stmt = $this->_conn->prepare('INSERT INTO incomeDtl ' .
                                      '(description, incometype, amount,user_userID, effectivedate, createdate) ' .
                                      'VALUES (:desc, :type, :amount, :user_userID, :effectivedate, :createdate) ');
        $stmt->bindParam(':desc', $desc , PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindParam(':user_userID', $userID, PDO::PARAM_STR);
        $stmt->bindParam(':effectivedate', $date, PDO::PARAM_STR);
        $stmt->bindParam(':createdate', $today, PDO::PARAM_STR);
        
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die ("(!) There was an error adding income: " . $desc . " " . $amount . " - " . $e);
        }        
        return $this->_conn->lastInsertId();
    }
    
    /**
     * Retrieves all income records for 
     * @param $userID ID of user stored in session.
     * @return $resultArray array of all income transactions for user.
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
                $effectiveDate = $row['effectivedate'];                
                $createDate = $row['createdate'];  
                //create new incomeitem object 
                $income = new IncomeItem ($amount,$incomeType,$createDate,$effectiveDate,$incomeID);
                $income->setDescription($desc);
                //add object to array
                array_push($resultArray,$income);                
            }
            
            return $resultArray;
        
        } catch (PDOException $e) {
            die ("(!) There was an error adding income of amount " . $amount . " to the database... " . $e);
        }        
        return $this->_conn->lastInsertId();
        
    }
    
    /**
     *Retrieve a single income record by IncomeID
     *@param $incomeID int The incomeID of the income record
     *@return $resultArray the associative array containing the income record
     */
     public function getIncomeByIncomeID($incomeID){
        $stmt = $this->_conn->prepare('SELECT * FROM incomeDtl WHERE incomeid = :incomeid');
        $stmt->bindParam(':incomeid', $incomeID, PDO::PARAM_INT);
       
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die ("(!) There was an error getting income: " . $incomeID . " - " . $e);
        }
        
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        //assign properties of class to variable
        $desc = $results['description'];
        $category = $results['incometype'];
        $amount = $results['amount'];
        $userID = $results['user_userID'];
        $applyDate = $results['effectivedate'];
        $createDate = $results['createdate'];                
        //create new expenseitem object 
        $income = new IncomeItem($amount,$category,$createdate,$applyDate,$incomeID);
        $income->setDescription($desc);
        
        return $income;
        /*
        $stmt = $this->_conn->prepare('SELECT * FROM incomeDtl WHERE incomeid = :incomeID');
        $stmt->bindParam(':incomeID', $incomeID, PDO::PARAM_STR);
        
        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $resultArray =  [];
            foreach($results as $row){
                //assign properties of class to variable
                $incomeID = $row['incomeid'];
                $desc = $row['description'];
                $incomeType = $row['incometype'];
                $amount = $row['amount'];
                $userID = $row['user_userID'];
                $effectiveDate = $row['effectivedate'];                
                $createDate = $row['createdate'];  
                //create new incomeitem object 
                $income = new IncomeItem ($amount,$incomeType,$createDate,$effectiveDate,$incomeID);
                $income->setDescription($desc);
                //add object to array
                array_push($resultArray,$income);                
            }
            
            return $resultArray;
        
        } catch (PDOException $e) {
            die ("(!) There was an error adding income of amount " . $amount . " to the database... " . $e);
        }        
        return $this->_conn->lastInsertId();*/   
    }
    
      /**
     * Retrieves top 3 income records for user BY id
     * @param $userID ID of user stored in session.
     * @return $resultArray array of top 3 income transactions for user.
     */
    public function getTopThreeIncomesByUserID($userID){
        $stmt = $this->_conn->prepare(
                'SELECT * ' .
                'FROM incomeDtl ' .
                'WHERE user_userID = :user_userID ' .
                'AND effectivedate > CURRENT_DATE() ' .
                'ORDER BY effectivedate ASC ' .
                'LIMIT 3');
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
                $effectiveDate = $row['effectivedate'];
                $createDate = $row['createdate'];  
                //create new incomeitem object 
                $income = new IncomeItem ($amount,$incomeType,$createDate,$effectiveDate,$incomeID);
                $income->setDescription($desc);
                //add object to array
                array_push($resultArray,$income);                
            }
            
            return $resultArray;
        
        } catch (PDOException $e) {
            die ("(!) There was an error adding income of amount " . $amount . " to the database... " . $e);
        }        
        return $this->_conn->lastInsertId();
        
    }
    
    
        /**
     * Remove income record by incomeID
     */
    public function removeIncomeByID($incomeID){
        
        try{
            $stmt = $this->_conn->prepare('DELETE FROM incomeDtl WHERE incomeID = :incomeID');
            $stmt->bindParam(':incomeID', $incomeID, PDO::PARAM_INT);
            $stmt->execute();
        }      
        catch (PDOException $e) {
            die ("(!) There was an error removing expense with id: " . $incomeID . " from the database... " . $e);
        }
        
        
    }
       
    
     /**
     * Creates a new expense record for user
     * @param $userID ID of user stored in session.
     * @param $desc String  description of income
     * @param $type String description of type of income.
     * @param $frequency String how frequent the income is obtained.
     * @param $date Date the date of the income posted.
     */
    public function addExpenseByUserID($userID,$desc,$type,$amount,$date){
        $today = date('Y-m-d H:i:s');
        $stmt = $this->_conn->prepare('INSERT INTO expenseDtl ' .
                                      '(description, expensetype, amount,user_userID, duedate, createdate) ' .
                                      'VALUES (:desc, :type, :amount, :user_userID, :duedate, :createdate) ');
        $stmt->bindParam(':desc', $desc , PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindParam(':user_userID', $userID, PDO::PARAM_STR);
        $stmt->bindParam(':duedate', $date, PDO::PARAM_STR);
        $stmt->bindParam(':createdate', $today, PDO::PARAM_STR);
        
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die ("(!) There was an error adding expense of amount " . $amount . " to the database... " . $e);
        }        
        return $this->_conn->lastInsertId();
    }
    
    
    /**
     * Edits an expense record for user.
     * @param $desc String  description of income
     * @param $type String description of type of income.
     * @param $frequency String how frequent the income is obtained.
     * @param $date Date the date of the income posted.
     */
    public function editExpenseByExpenseID($expenseID,$desc,$type,$amount,$date){
     
        $stmt = $this->_conn->prepare('UPDATE expenseDtl ' .
                                      'SET description = :desc , expensetype = :type , amount = :amount , duedate = :duedate ' .
                                      'WHERE expenseID = :expenseID');
        $stmt->bindParam(':desc', $desc , PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindParam(':expenseID', $expenseID, PDO::PARAM_INT);
        $stmt->bindParam(':duedate', $date, PDO::PARAM_STR);   
        
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die ("(!) There was an error editing expense of amount " . $amount . " and id: " . $expenseID . "in the database... " . $e);
        }        
    }


    /**
     * Edits an income record for user.
     * @param $desc String  description of income
     * @param $type String description of type of income.
     * @param $frequency String how frequent the income is obtained.
     * @param $date Date the date of the income posted.
     */
    public function editIncomeByIncomeID($incomeID,$desc,$type,$amount,$date){
     
        $stmt = $this->_conn->prepare('UPDATE incomeDtl ' .
                                      'SET description = :desc , incometype = :type , amount = :amount , effectivedate = :duedate ' .
                                      'WHERE incomeID = :incomeID');
        $stmt->bindParam(':desc', $desc , PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindParam(':incomeID', $incomeID, PDO::PARAM_INT);
        $stmt->bindParam(':duedate', $date, PDO::PARAM_STR);   
        
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die ("(!) There was an error editing income transaction: " . $incomeID . " - " . $e);
        }        
    }

    
    
     public function getAllExpenseByUserID($userID){
        $stmt = $this->_conn->prepare('SELECT expenseid,description,amount,expensetype,frequency,duedate,user_userID,createdate
                                      FROM expenseDtl WHERE user_userID = :user_userID');
        $stmt->bindParam(':user_userID', $userID, PDO::PARAM_STR);
        
        try {
            $results = $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $resultArray =  [];
            foreach($results as $row){
                //assign properties of class to variable
                $expenseID = $row['expenseid'];
                $desc = $row['description'];
                $expenseType = $row['expensetype'];
                $amount = $row['amount'];
                $userID = $row['user_userID'];
                $duedate = $row['duedate'];
                $createdate = $row['createdate'];
                
                //create new incomeitem object 
                $expense = new ExpenseItem($amount,$expenseType,$createdate,$duedate,$expenseID);
                $expense->setDescription($desc);
                //add object to array
                array_push($resultArray,$expense);                
            }
            
            return $resultArray;
        
        } catch (PDOException $e) {
            die ("(!) There was an error adding income of amount " . $amount . " to the database... " . $e);
        }        
        return $this->_conn->lastInsertId();
        
    }
    
      /**
     * Retrieves top 3 expense records for user by id
     * @param $userID ID of user stored in session.
     * @return $resultArray array of top 3 expense transactions for user.
     */
      
    public function getTopThreeExpenseByUserID($userID){
        $stmt = $this->_conn->prepare(
            'SELECT expenseid,description,amount,expensetype,frequency,duedate,user_userID,createdate ' .
            'FROM expenseDtl ' .
            'WHERE user_userID = :user_userID ' .
            'AND duedate > CURRENT_DATE() ' .
            'ORDER BY duedate ASC ' .
            'LIMIT 3'
            );
        
        $stmt->bindParam(':user_userID', $userID, PDO::PARAM_INT);
        
        try {
            $results = $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $resultArray =  [];
            foreach($results as $row){
                //assign properties of class to variable
                $expenseID = $row['expenseid'];
                $desc = $row['description'];
                $expenseType = $row['expenseType'];
                $amount = $row['amount'];
                $userID = $row['user_userID'];
                $duedate = $row['duedate'];
                $createdate = $row['createdate'];
                
                //create new incomeitem object 
                $expense = new ExpenseItem($amount,$expenseType,$createdate,$duedate,$expenseID);
                $expense->setDescription($desc);
                //add object to array
                array_push($resultArray,$expense);                
            }
            
            return $resultArray;
        
        } catch (PDOException $e) {
            die ("(!) There was an error pulling the last 3 transactions... " . $e);
        }        
    
        
    }
    
     /**
     * Retrieves expense record by ExpeneseID 
     * @param $expenseID ID of the expense record.
     * @return $resultArray array expense record.
     */      
    public function getExpenseByExpenseID($expenseID){
        $stmt = $this->_conn->prepare('SELECT * FROM expenseDtl WHERE expenseID = :expenseID');
        $stmt->bindParam(':expenseID', $expenseID, PDO::PARAM_INT);
       
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die ("(!) There was an error editing expense: " . $$expenseid . " - " . $e);
        }
        
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        //assign properties of class to variable
        $expenseID = $results['expenseid'];
        $desc = $results['description'];
        $expenseType = $results['expensetype'];
        $amount = $results['amount'];
        $userID = $results['user_userID'];
        $applyDate = $results['duedate'];
        $createDate = $results['createdate'];                
        //create new expenseitem object 
        $expense = new ExpenseItem($amount,$expenseType,$createdate,$applyDate,$expenseID);
        $expense->setDescription($desc);
        
        return $expense;
    }  
    
    /**
     *Get the top 5 transacions for a user.
     *@param $userID int id of the user stored in session.
     *
     */
    
    public function getTopFiveTransactionsByUserID($userID){       
        
        $stmt = $this->_conn->prepare(
            'SELECT description, date, amount ' .
            'FROM ' .
                '((SELECT e.description, e.duedate as date, e.amount ' .
                'FROM expenseDtl AS e ' .
                'WHERE e.user_userID = ' . $userID . ' ) ' .
                'UNION ' .
                '(SELECT i.description, i.effectivedate as date, i.amount ' .
                'FROM incomeDtl AS i ' .
                'WHERE i.user_userID = ' . $userID . ' ))' .
            'AS t ' .
            'WHERE date <= CURRENT_DATE() ' .
            'ORDER BY date DESC ' .
            'LIMIT 5 '
            
            );
        
        try {
            $results = $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $resultArray =  [];
            foreach($results as $row){
                //assign properties of class to variable
                $expenseID = $row['expenseid'];
                $desc = $row['description'];
                $expenseType = $row['expenseType'];
                $amount = $row['amount'];
                $userID = $row['user_userID'];
                $dueDate = $row['date'];
                $createDate = $row['createdate'];
                
                //create new incomeitem object 
                $income = new ExpenseItem($amount,$expenseType,$createDate,$dueDate,$expenseID);
                $income->setDescription($desc);
                //add object to array
                array_push($resultArray,$income);
            }
            
            return $resultArray;
        
        } catch (PDOException $e) {
            die ("(!) There was an error pulling last 5 transaction for " . $userID . ": " . $e);
        }        
   
          
    }
    /**
     * Remove expense record by expenseID
     */
    public function removeExpenseByID($expenseID){
        
        try{
            $stmt = $this->_conn->prepare('DELETE FROM expenseDtl WHERE expenseID = :expenseID');
            $stmt->bindParam(':expenseID', $expenseID, PDO::PARAM_STR);
            $stmt->execute();
        }      
        catch (PDOException $e) {
            die ("(!) There was an error removing expense with id: " . $expenseID . " from the database... " . $e);
        }
        
    }
    
    
    /**
     * Grab the sum of all income that exist in the database for the
     * specified user in the specified month.
     * @param $id int User's databse record number
     * @param $month int month number to operate with
     * @return $results array() collection of income transactions
     */
    public function getTotalIncomeByDate($id, $month, $year) {
        // Prepare PDO query
        $stmt = $this->_conn->prepare(
            'SELECT SUM(amount) as total ' .
            'FROM incomeDtl ' .
            'WHERE user_userID = :id ' .
            'AND MONTH(effectivedate) = :month ' .
            'AND YEAR(effectivedate) = :year'
        );
        
        // Bind parameters, execute and return
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':month', $month);
        $stmt->bindParam(':year', $year);
        
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die('(!) There was an error getting total income for: ' . $id . ':' . $month . '/' . $e);
        }
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return $result;
    }
    
    
    /**
     * Grab the sum of all expenses that exist in the database for the
     * specified user in the specified month.
     * @param $id int User's databse record number
     * @param $month int month number to operate with
     * @return $results array() collection of expense transactions
     */
    public function getTotalExpenseByDate($id, $month, $year) {
        $stmt = $this->_conn->prepare(
            'SELECT SUM(amount) as total ' .
            'FROM expenseDtl ' .
            'WHERE user_userID = :id ' .
            'AND MONTH(duedate) = :month ' .
            'AND YEAR(duedate) = :year'
        );
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':month', $month);
        $stmt->bindParam(':year', $year);
        
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die('(!) There was an error getting total expense for: ' . $id . ':' . $month . '/' . $e);
        }
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return $result;
    }
    
    
    /**
     * Grab the sum of all expenses that exist in the database for each
     * category list for the specified user in the specified month.
     * @param $id int User's databse record number
     * @param $month int month number to operate with
     * @return $results array() collection of category-amount pairs
     */
    public function getTotalExpenseByCategory($id, $month, $year) {
        // Prepare MySQL Query
        $stmt = $this->_conn->prepare(
            'SELECT expensetype, ROUND(SUM(amount)) AS total ' .
            'FROM expenseDtl ' .
            'WHERE user_userID = :id ' .
            'AND MONTH(duedate) = :month ' .
            'AND YEAR(duedate) = :year ' .
            'GROUP BY expensetype ' .
            'ORDER BY amount DESC'
        );
        
        // Bind Paramters and execute
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }


    /**
     * Determines if the specified user is the owner of the specified
     * transaction record.  Returns true if so, false otherwise.
     * @param $type String type of transaction
     * @param $transactionID int transaction record number
     * @param $userID int user record number
     * @return boolean true if valid user, false otherwise
     */
    public function validTransactionUser($type, $transactionID, $userID) {
        // Prepare PDO statement
        $stmt = $this->_conn->prepare(
            'SELECT CASE user_userID ' .
            'WHEN :userID ' .
            'THEN true ' .
            'ELSE false ' .
            'END as "validUser" ' .
            'FROM ' . $type . 'Dtl ' .
            'WHERE ' . $type . 'id = :transactionID'
        );
        
        // Bind parameters and execute
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':transactionID', $transactionID, PDO::PARAM_INT);
        
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo '(!) There was an error check user validity: ' . $userID . ' / ' . $transactionID . ' - ' . $e;
        }
        
        // Get and return results
        //var_dump($stmt->fetch(PDO::FETCH_ASSOC));
        $result = $stmt->fetch(PDO::FETCH_ASSOC)['validUser'];
        if ($result === "1") return true;
        else return false;
    }
    

}