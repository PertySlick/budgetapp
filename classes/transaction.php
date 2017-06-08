<?php

/*
 * File Name: transaction.php
 * Author: Timothy Roush
 * Date Created: 6/02/17
 * Assignment: Final Budget App
 * Description: Parent Class: Transaction
 */

/**
 * Provides a base class for other transaction chil classes to inherit from.
 * Supplies the basic transaction details such as date posted, amount, as well
 * as a few getters and setters.  This is not intended to be instanciated as
 * it's own object.
 *
 * @author Timothy Roush
 * @copyright 2017
 * @version 1.0
 * @see BudgetItem
 * @see IncomeItem
 * @see ExpenseItem
 */
abstract class Transaction {


// FIELDS


    protected $amount;                      // Amount value for transaction
    protected $category;                    // Category of this transaction
    protected $dateApplied;                 // Date transaction applies
    protected $datePosted;                  // Date transaction was created
    protected $id;                          // the Expense or Income ID of the item


// CONSTRUCTOR


    /**
     * Constructs an instance of this object with the base required information.
     * @param $amount float dollar amount to store in transaction
     * @param $category string name of transaction category
     * @param $datePosted string date transaction was created
     * @param $dateApplied string date transaction actually applies
     */
    public function __construct($amount, $category, $datePosted, $dateApplied,$id) {
        $this->setAmount($amount);
        $this->setCategory($category);
        $this->setDatePosted($datePosted);
        $this->setDateApplied($dateApplied);       
        $this->setID($id);
    }


// METHODS - GETTERS


    /**
     * Returns the dollar amount stored for this transaction
     * @return int dollar amount for transaction
     */
    public function getAmount() {
        return $this->amount;
    }
    
    
    /**
     * Returns the category stored for this transaction
     * @return String category of transaction
     */
    protected function getCategory() {
        return $this->category;
    }
    
    
    /**
     * Returns the date this transaction actually applies in a display format
     * @return String date transaction applies
     */
    public function getDateApplied() {
        return  $this->dateApplied ;
    }
    
    
    /**
     * Returns the date this transaction was created in a display format
     * @return String date transaction was posted
     */
    protected function getDatePosted() {
        return  $this->datePosted ;
    }
    
    
    /**
     * Returns the month this transaction actually applies in a display format
     * @return String month this transaction applies
     */
    protected function getApplyMonth() {
        return date("m", $this->dateApplied);
    }
    
    public function getID(){
        return $this->id;
    }


// METHODS - SETTERS


    /**
     * Abstract class is specific to each child class.  Must set the dollar
     * amount of this transaction.
     */
     protected function setAmount($value){
     }
     
     /**
      *set the expenseID or incomeID
      */
     protected function setID($id){
        $this->id = $id;
     }


    /**
     * Sets the category of this transaction.  Value is first compared against
     * an array of possible values.  If the value is not found in the array, it
     * is then set as 'other'.  Otherwise it is entered as supplied.
     */
    protected function setCategory($value) {
        $categories = array('Gas', 'Groceries', 'Auto Maintenance',
                            'Home Maintenance', 'Clothing', 'Medical',
                            'Clothing', 'Recreation', 'Other');
        
        if (!in_array($value, $categories)) $value = 'Other';
        $this->category = $value;
    }
    
    
    /**
     * Sets the date that this transaction actually applies.  A string value
     * must be supplied as it is then converted to a time value and stored.
     */
    protected function setDateApplied($value) {
        $this->dateApplied = $value ;
    }
    
    /**
     * Sets the date that this transaction was created.  A string value must be
     * supplied as it is then converted to a time value and stored.
     */
    protected function setDatePosted($value) {
        $this->datePosted = $value;
    }
}