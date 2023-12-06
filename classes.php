<?php
class Account
{
    public $id;
    public $name;
    public $transactions = []; // Array di oggetti Transaction associati a questo account

    // Costruttore
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}

class Categories
{
    public $id;
    public $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}

class Position
{
    public $id;
    public $longitude;
    public $latitude;
    public $cityName;

    public function __construct($id, $longitude, $latitude, $cityName)
    {
        $this->id = $id;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->cityName = $cityName;
    }
}

class Transaction
{
    public $id;
    public $isExpense;
    public $amount;
    public $account; // Oggetto Account associato a questa transazione
    public $category; // Oggetto Categories associato a questa transazione
    public $position; // Oggetto Position associato a questa transazione
    public $transactionDate;

    public function __construct($id, $isExpense, $amount, $account, $category, $position, $transactionDate)
    {
        $this->id = $id;
        $this->isExpense = $isExpense;
        $this->amount = $amount;
        $this->account = $account;
        $this->category = $category;
        $this->position = $position;
        $this->transactionDate = $transactionDate;
    }
}
