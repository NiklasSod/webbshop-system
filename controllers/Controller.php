<?php

class Controller
{

    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function main()
    {
        $this->router();
    }
    private function router()
    {
        $page = $_GET['page'] ?? "";

        switch ($page) {
            case "about":
                $this->about();
                break;
            case "detailpage":
                $this->detailPage();
                break;
            case "register":
                $this->register();
                break;
            case "login":
                $this->login();
                break;
            case "customerpage":
                $this->customerPage();
                break;
            case "logout":
                $this->view->logOut();
                break;
            case "shoppingcart":
                $this->cartPage();
                break;
            case "orderconfirm":
                $this->orderconfirmPage();
                break;
            case "adminorderpage":
                $this->adminOrderPage();
                break;
            case "adminproductpage":
                $this->adminProductPage();
                break;
            case "delete":
                $this->adminDeletePage();
                break;
            default:
                $this->getAllCards();
        }
    }

    private function getHeader($title)
    {
        $this->view->viewHeader($title);
    }

    private function getFooter()
    {
        $this->view->viewFooter();
    }

    private function about()
    {
        $this->getHeader(null);
        $this->view->viewAboutPage();
        $this->getFooter();
    }

    private function customerPage()
    {
        $this->getHeader("Your page");
        if (isset($_SESSION['customer_id'])) {
            $orders = $this->model->findUserOrders();
            $this->view->viewCustomerPage($orders);
        }
        $this->getFooter();
    }

    private function cartPage()
    {
        $this->getHeader("Your Shoppingcart");
        $this->view->viewCartPage();
        $this->getFooter();
    }

    private function orderconfirmPage()
    {
        $this->getHeader("Order Confirmed");
        $this->view->viewOrderConfirmPage();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sendOrder'])){
            $this->sendOrderToDb();
        }
        $this->getFooter();
    }

    private function register()
    {
        $this->getHeader("Register here");
        $this->view->registerPage();

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->registerUserToDb();
        $this->getFooter();
    }

    private function login()
    {
        $this->getHeader("Please login");
        $this->view->loginPage();

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->validateUserLogin();

        $this->getFooter();
    }

    private function getAllCards()
    {
        $this->getHeader("Welcome");
        $cards = $this->model->fetchAllCards();
        $this->view->viewAllCards($cards);
        $this->getFooter();
    }

    // ADMIN ---------------------------------------
    private function adminOrderPage() {
        $this->getHeader("Admin Order page");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])){
            $this->adminChangeOrderStatus();
        }
        $this->view->viewAdminOrderPage();
        $this->adminOrderHandling();
        $this->getFooter();
    }

    private function adminProductPage() {
        $this->getHeader("Admin Product page");
        $this->view->viewAdminProductPage();
        $this->getFooter();
    }

    private function adminDeletePage() {
        $this->getHeader("Admin Delete page");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cardId'])){
            $this->adminDeleteProduct();
        }
        $cards = $this->model->fetchAllCards();
        $this->view->viewAdminDeletePage($cards);
        $this->getFooter();
    }

    private function detailPage()
    {
        $this->getHeader("Card detail page");

        $id = $this->sanitize($_GET['id']);
        $card = $this->model->fetchCardById($id);

        if ($card)
            $this->view->viewOrderPage($card);

        $this->getFooter();
    }


    private function sendOrderToDb()
    {

        $customerId = $this->sanitize($_SESSION['customer_id']);
        $confirmed2 = $this->model->sendOrderToDb($customerId);

        if ($confirmed2){
            foreach ($_SESSION['order'] as $order) {

                $orderId = $this->sanitize($_SESSION['neworder']);
                $cardId = $this->sanitize($order['id']);
                $amount = $this->sanitize($order['amount']);
                $price = $this->sanitize($order['price']);
                $confirmed = $this->model->sendOrderItemToDb($orderId, $amount, $price, $cardId);
            }
        } else {
            $this->view->viewErrorMessage();
        }

        if ($confirmed) {
            $this->view->viewConfirmMessageSend($_SESSION['email']);
            unset($_SESSION['order']);
            header("refresh:2; url=index.php");
        } else {
            $this->view->viewErrorMessage();
        }
    }

    private function adminOrderHandling() {
        $ordersToHandle = $this->model->fetchAllOrders();
        $this->view->viewAllOrdersToHandle($ordersToHandle);

        if (!$ordersToHandle) {
            $this->view->viewErrorMessage();
        }
    }

    private function adminChangeOrderStatus() {
        $orderId = $this->sanitize($_POST['orderId']);
        $confirmed = $this->model->changeOrderStatus($orderId);

        if ($confirmed) {
            $this->view->viewErrorMessage();
        } else {
            $type = "sent";
            $this->view->viewConfirmMessageSuccess($orderId, $type);
        }
    }

    

    private function adminDeleteProduct() {
        $cardId = $this->sanitize($_POST['cardId']);
        $confirmed = $this->model->deleteProduct($cardId);

        if ($confirmed) {
            $this->view->viewErrorMessage();
        } else {
            $type = "deleted";
            $this->view->viewConfirmMessageSuccess($cardId, $type);
        }
    }



    private function registerUserToDb()
    {
        $CustomerFirstname    = $this->sanitize($_POST['firstname']);
        $CustomerLastname = $this->sanitize($_POST['lastname']);
        $CustomerEmail = $this->sanitize($_POST['email']);
        $CustomerPassword = $this->sanitize($_POST['password']);
        $confirmed = $this->model->modelRegisterCustomer($CustomerFirstname, $CustomerLastname, $CustomerEmail, $CustomerPassword);

        if ($confirmed) {
            $this->view->viewConfirmMessageRegister($CustomerFirstname);
        } else {
            $this->view->viewErrorMessage();
        }
    }

    public function validateUserLogin()
    {
        $CustomerEmail = $this->sanitize($_POST['email']);
        $CustomerPassword = $this->sanitize($_POST['password']);

        $confirmed = $this->model->modelLoginCustomer($CustomerEmail, $CustomerPassword);
        
        if ($confirmed) {
            $this->view->viewConfirmMessageLogin($CustomerEmail . "... redirecting to homepage");

            header("refresh:1; url=index.php");
        } else {
            $this->view->viewErrorMessage($CustomerEmail);
        }
    }

    /**
     * Sanitize Inputs
     * https://www.w3schools.com/php/php_form_validation.asp
     */
    public function sanitize($text)
    {
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        return $text;
    }
}
