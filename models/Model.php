<?php

class Model
{

  private $db;

  public function __construct($database)
  {
    $this->db = $database;
  }

  public function fetchAllCards()
  {
    $cards = $this->db->select("SELECT * FROM products");
    return $cards;
  }

  public function fetchCardById($id)
  {
    $statement = "SELECT * FROM products WHERE id = :id";
    $params = array(":id" => $id);
    $card = $this->db->select($statement, $params);
    // print_r($movie);
    return $card[0] ?? false;
  }

  public function fetchCustomerById($id)
  {
    $statement = "SELECT * FROM customers WHERE customer_id=:id";
    $parameters = array(':id' => $id);
    $customer = $this->db->select($statement, $parameters);
    return $customer[0] ?? false;
  }

  public function saveOrder($customer_id, $movie_id)
  {
    $customer = $this->fetchCustomerById($customer_id);
    if (!$customer) return false;

    $statement = "INSERT INTO orders (customer_id, film_id)  
                    VALUES (:customer_id, :film_id)";
    $parameters = array(
      ':customer_id' => $customer_id,
      ':film_id' => $movie_id
    );

    // Ordernummer
    $lastInsertId = $this->db->insert($statement, $parameters);

    return array('customer' => $customer, 'lastInsertId' => $lastInsertId);
  }
}
