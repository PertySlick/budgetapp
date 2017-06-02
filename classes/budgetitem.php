<?php

/*
 * File Name: budgetitem.php
 * Author: Timothy Roush
 * Date Created: 6/02/17
 * Assignment: Final Budget App
 * Description: Represents an budget transaction/restriction
 */

/**
 * An object representing a budget transaction within the budget environment.
 * Is a direct child class of the Transaction class.
 *
 * @author Timothy Roush
 * @copyright 2017
 * @version 1.0
 * @see Transaction
 */
abstract class BudgetItem extends Transaction {


// CONSTRUCTOR


    /**
     * Constructs an instance of this object with the base required information.
     * @param $amount float dollar amount to store in budget item
     * @param $category string name of budget item category
     * @param $datePosted string date budget item was created
     * @param $dateApplied string date budget item actually applies
     */
    public function __contruct($amount, $category, $datePosted, $dateApplied) {
        parent::__construct($amount, $category, $datePosted, $dateApplied);
    }


// METHODS - SETTERS


    /**
     * Sets the amount of this budget item to the supplied value after it is
     * rounded DOWN to the nearest whole dollar.
     */
    public function setAmount($value) {
        if ($value < 0) $value = 0;
        $this->amount = floor($value);
    }   