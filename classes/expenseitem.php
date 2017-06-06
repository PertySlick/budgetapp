<?php

/*
 * File Name: expenseitem.php
 * Author: Timothy Roush
 * Date Created: 6/02/17
 * Assignment: Final Budget App
 * Description: Represents an expense transaction
 */

/**
 * An object representing an expense transaction within the budget environment.
 * Is a direct child class of the Transaction class.
 *
 * @author Timothy Roush
 * @copyright 2017
 * @version 1.0
 * @see Transaction
 */
abstract class ExpenseItem extends Transaction {


// FIELDS


    protected $description;                 // Description for this expense item


// CONSTRUCTOR


    /**
     * Constructs an instance of this object with the base required information.
     * @param $amount float dollar amount to store in expense item
     * @param $category string name of expense item category
     * @param $datePosted string date expense item was created
     * @param $dateApplied string date expense item actually applies
     */
    public function __contruct($amount, $category, $datePosted, $dateApplied) {
        parent::__construct($amount, $category, $datePosted, $dateApplied);
    }


// METHODS - GETTERS


    /**
     * Returns the description stored for this expense item
     * @return String description of expense item
     */
    public function getDescription() {
        return $this->description;
    }


// METHODS - SETTERS


    /**
     * Sets the amount of this expense item to the supplied value after it is
     * rounded UP to the nearest whole dollar.
     */
    public function setAmount($value) {
        if ($value < 0) $value = 0;
        $this->amount = ceil($value);
    }
    
    
    /**
     * Sets the description of this expense item. If value supplied is null or
     * empty, a default value is entered instead.
     */
    public function setDescription($value) {
        if ($value == null || $value == "") $value = "Expense Item";
        $this->description = $value;
    }
}

    