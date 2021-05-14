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

  public function modelRegisterCustomer($CustomerFirstname, $CustomerLastname, $CustomerEmail, $CustomerPassword)
  {

    $statement = "INSERT INTO customers (FirstName,LastName,Email,password )  
                    VALUES (:CustomerFirstname,:CustomerLastname,:CustomerEmail,:CustomerPassword )";
    $parameters = array(
      ':CustomerFirstname' => $CustomerFirstname,
      ':CustomerLastname' => $CustomerLastname,
      ':CustomerEmail' => $CustomerEmail,
      ':CustomerPassword' => $CustomerPassword
    );

    // new customer
    $insertedCustomer = $this->db->insert($statement, $parameters);

    return array('insertedCustomer' => $insertedCustomer);
  }

  public function modelLoginCustomer()
  {
    if (isset($_POST)) {

      $email = $_POST['email'];
      $password = $_POST['password'];

      if ($email != "" && $password != "") {

        $statement = "SELECT * FROM customers  WHERE email = :email and password =:password";

        $parameters = array(
          ":email" => $email,
          ":password" => $password,
        );

        $loggedInCustomer = $this->db->select($statement, $parameters);

        // print_r($loggedInCustomer);

        if (count($loggedInCustomer) > 0) {
          $_SESSION['email'] = $email;


          // setcookie("TestCookie", $loggedInCustomer);
          // $_SESSION["favcolor"] = "green";

          // print_r($_SESSION);
          header('Location: index.php');
        } else {
          echo "Invalid username or password";
        }
        return array('loggedInCustomer' => $loggedInCustomer);


        // $s= "select * from customers where email='" . $email . "' and password='" . $password . "'";
        // $result = mysqli_query($con, $sql_query);
        // $row = mysqli_fetch_array($result);

        // $count = $row['cntUser'];

        // if ($count > 0) {
        //     $_SESSION['uname'] = $uname;
        //     header('Location: home.php');
        // } else {
        //     echo "Invalid username and password";
        // }
      }
    }
  }
}
