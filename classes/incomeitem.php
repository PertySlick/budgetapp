<?php

/*
 * File Name: incomeitem.php
 * Author: Timothy Roush
 * Date Created: 6/02/17
 * Assignment: Final Budget App
 * Description: Represents an income transaction
 */

/**
 * An object representing an income transaction within the budget environment.
 * Is a direct child class of the Transaction class.
 *
 * @author Timothy Roush
 * @copyright 2017
 * @version 1.0
 * @see Transaction
 */
abstract class IncomeItem extends Transaction {


// FIELDS


    protected $description;                 // Description for this income item


// CONSTRUCTOR


    /**
     * Constructs an instance of this object with the base required information.
     * @param $amount float dollar amount to store in income item
     * @param $category string name of income item category
     * @param $datePosted string date income item was created
     * @param $dateApplied string date income item actually applies
     */
    public function __contruct($amount, $category, $datePosted, $dateApplied) {
        parent::__construct($amount, $category, $datePosted, $dateApplied);
    }


// METHODS - GETTERS


    /**
     * Returns the description stored for this income item
     * @return String description of income item
     */
    public function getDescription() {
        return $this->description;
    }


// METHODS - SETTERS


    /**
     * Sets the amount of this income item to the supplied value after it is
     * rounded DOWN to the nearest whole dollar.
     */
    public function setAmount($value) {
        if ($value < 0) $value = 0;
        $this->amount = floor($value);
    }
    
    
    /**
     * Sets the description of this income item. If value supplied is null or
     * empty, a default value is entered instead.
     */
    public function setDescription($value) {
        if ($value == null || $value == "") $value = "Income Item";
        
        $this->description = $value;
    }
}
    