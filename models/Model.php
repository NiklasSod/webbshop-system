<?php

class Model
{

  private $db;

  public function __construct($database)
  {
    $this->db = $database;
  }

  public function fetchAllSomething()
  {
    $movies = $this->db->select("SELECT * FROM customers");
    return $movies;
  }

  public function fetchSomething($WWW) {
    $movie = $this->db->select("SELECT * FROM XXX WHERE YYY = $WWW");
    return $movie;
  }

  public function insertOneOrder($customerNr, $filmId) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $order = $this->db->insert("INSERT INTO orders(customer_id, film_id) 
      VALUES ($customerNr,$filmId)");

    }
  }
}
