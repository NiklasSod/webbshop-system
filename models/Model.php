<?php

class Model
{

  private $db;

  public function __construct($database)
  {
    $this->db = $database;
  }

  /******************
   * Card Functions
   */

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
    return $card[0] ?? false;
  }

  /***************************
   * Order Functions
   */

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

    $insertedCustomer = $this->db->insert($statement, $parameters);

    return array('insertedCustomer' => $insertedCustomer) ?? false;
  }

  public function findUserOrders()
  {
    $statement = "SELECT * FROM orders WHERE customerId = :customerId";
    $params = array(":customerId" => $_SESSION['customer_id']);
    $orders = $this->db->select($statement, $params);
    return $orders ?? false;
  }

  public function fetchAllOrders()
  {
    $adminOrderHandling = $this->db->select("SELECT * FROM orders");
    return $adminOrderHandling;
  }

  public function fetchOneOrder($id)
  {
    // select correct order
    $order = $this->db->select(
      "SELECT orders.id, orders.customerId, orderitems.orderId 
      FROM orders 
      INNER JOIN orderitems ON orderitems.orderId = orders.id
      WHERE orders.customerId = $_SESSION[customer_id] AND orderitems.orderId = $id"
      );

    return $order;
  }

  public function changeOrderAmount($cardId, $amount)
  {
    $amountChange = $this->db->update(
      "UPDATE products p 
      SET p.amount = (p.amount - $amount) 
      WHERE p.id = $cardId
      "
    );
    return $amountChange;
  }

  public function changeOrderStatus($orderId)
  {
    $orderSent = $this->db->update("UPDATE orders SET orderStatus = 1 WHERE id = $orderId");
    return $orderSent;
  }

  /*****************************
   * Product Functions
   */

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

  /********************
   * User Functions
   */
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
          $_SESSION['customer_info'] = $loggedInCustomer;

          return array('loggedInCustomer' => $loggedInCustomer) ?? false;
        }
      }
    }
  }
}
