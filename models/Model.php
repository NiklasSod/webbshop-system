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

  public function fetchAllOrders()
  {
    $adminOrderHandling = $this->db->select("SELECT * FROM orders WHERE orderStatus IS null");
    return $adminOrderHandling;
  }

  public function changeOrderStatus($orderId)
  {
    $orderSent = $this->db->update("UPDATE orders SET orderStatus = 1 WHERE id = $orderId");
    return $orderSent;
  }

  public function deleteProduct($cardId)
  {
    $cardDelete = $this->db->delete("DELETE FROM products WHERE id = $cardId");
    return $cardDelete;
  }

  public function createProduct(
    $name,
    $amount,
    $description,
    $price,
    $image,
    $category,
    $rarity
  ) {

    $statement = "INSERT INTO products (name, amount, description, price, image,  category, rarity) 
                    VALUES (:name,:amount,:description,:price, :image,:category,:rarity)";
    $parameters = array(
      ':name' => $name,
      ':amount' => $amount,
      ':description' => $description,
      ':price' => $price,
      ':image' => $image,
      ':category' => $category,
      ':rarity' => $rarity,
    );

    // new customer
    $insertedNewProduct = $this->db->insert($statement, $parameters);

    return array('insertedNewProduct' => $insertedNewProduct) ?? false;
  }
  public function updateProduct(
    $id,
    $name,
    $amount,
    $description,
    $price,
    $image,
    $category,
    $rarity
  ) {
    // "UPDATE contacts SET name= :name, tel= :tel WHERE id = :id");
    $statement = "UPDATE products SET name=:name,amount=:amount,description=:description,price=:price, image=:image,category=:category,rarity=:rarity WHERE id=:id";

    $parameters = array(
      ':id' => $id,
      ':name' => $name,
      ':amount' => $amount,
      ':description' => $description,
      ':price' => $price,
      ':image' => $image,
      ':category' => $category,
      ':rarity' => $rarity,
    );

    $updatedProduct = $this->db->update($statement, $parameters);

    return array('updatedProduct' => $updatedProduct) ?? false;
  }

  public function fetchCardById($id)
  {
    $statement = "SELECT * FROM products WHERE id = :id";
    $params = array(":id" => $id);
    $card = $this->db->select($statement, $params);
    return $card[0] ?? false;
  }

  public function findUserOrders()
  {
    $statement = "SELECT * FROM orders WHERE customerId = :customerId";
    $params = array(":customerId" => $_SESSION['customer_id']);
    $orders = $this->db->select($statement, $params);
    return $orders ?? false;
  }

  public function fetchCustomerById($id)
  {
    $statement = "SELECT * FROM customers WHERE customer_id=:id";
    $parameters = array(':id' => $id);
    $customer = $this->db->select($statement, $parameters);
    return $customer[0] ?? false;
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

    return array('insertedCustomer' => $insertedCustomer) ?? false;
  }

  public function sendOrderToDb($customerId)
  {

    $statement = "INSERT INTO orders (customerId )  
                    VALUES (:customerId )";
    $parameters = array(
      ':customerId' => $customerId
    );

    // new order
    $newOrder = $this->db->insert($statement, $parameters);

    $_SESSION['neworder'] = $newOrder;

    return array('newOrder' => $newOrder) ?? false;
  }

  public function sendOrderItemToDb($orderId, $amount, $price, $cardId)
  {

    $statement = "INSERT INTO orderitems (amount,orderId,price,productId )  
          VALUES (:amount,:orderId,:price,:productId )";
    $parameters = array(
      ':amount' => (int)$amount,
      ':orderId' => $orderId,
      ':price' => (int)$price,
      ':productId' => (int)$cardId
    );

    // new customer
    $insertedCustomer = $this->db->insert($statement, $parameters);

    return array('insertedCustomer' => $insertedCustomer) ?? false;
  }

  public function modelLoginCustomer()
  {
    if (isset($_POST)) {
      $email = $_POST['email'];
      $password = $_POST['password'];

      if ($email != "" && $password != "") {

        $statement = "SELECT * FROM customers WHERE email = :email AND password =:password";

        $parameters = array(
          ":email" => $email,
          ":password" => $password,
        );

        $loggedInCustomer = $this->db->select($statement, $parameters);

        if (count($loggedInCustomer) > 0) {

          // Sätta session för att förbli inloggad
          $_SESSION['email'] = $email;
          $_SESSION['customer_id'] = $loggedInCustomer[0]['id'];
          $_SESSION['isAdmin'] = $loggedInCustomer[0]['isAdmin'];

          return array('loggedInCustomer' => $loggedInCustomer) ?? false;
        }
      }
    }
  }
}
