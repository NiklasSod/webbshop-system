<?php

class Controller
{

    private $model;
    private $view;
    private $adminController;

    public function __construct($model, $view, $adminController)
    {
        $this->model = $model;
        $this->view = $view;
        $this->adminController = $adminController;
    }

    /***************************
     * Router
     */
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
                $this->adminController->adminOrderPage();
                break;
            case "adminproductpage":
                $this->adminController->adminProductPage();
                break;
            case "delete":
                $this->adminController->adminDeletePage();
                break;
            case "create":
                $this->adminController->adminCreatePage();
                break;
            case "update":
                $this->adminController->adminUpdatePage();
                break;
            default:
                $this->getAllCards();
        }
    }

    
    /***************************
     * Header
     */
    private function getHeader($title)
    {
        $this->view->viewHeader($title);
    }

    
    /***************************
     * Footer
     */
    private function getFooter()
    {
        $this->view->viewFooter();
    }

    /**************************
     * PAGES
     */
    private function about()
    {
        $this->getHeader(null);
        $this->view->viewAboutPage();
        $this->getFooter();
    }

    private function detailPage()
    {
        $this->getHeader("Card detail page");

        $id = $this->sanitize($_GET['id']);
        $card = $this->model->fetchCardById($id);

        if ($card)
            $this->view->viewCardDetailPage($card);

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sendOrder'])) {
            $this->sendOrderToDb();
        }
        $this->getFooter();
    }

    /***************************
     * Case: Default
     */
    private function getAllCards()
    {
        $this->getHeader("Welcome");
        $cards = $this->model->fetchAllCards();
        $this->view->viewAllCards($cards);
        $this->getFooter();
    }

    /***************************
     * DB Functions Customer
     */
    private function sendOrderToDb()
    {
        $customerId = $this->sanitize($_SESSION['customer_id']);
        $confirmed2 = $this->model->sendOrderToDb($customerId);

        if ($confirmed2) {
            foreach ($_SESSION['order'] as $order) {

                $orderId = $this->sanitize($_SESSION['neworder']);
                $cardId = $this->sanitize($order['id']);
                $amount = $this->sanitize($order['amount']);
                $price = $this->sanitize($order['price']);
                $confirmed = $this->model->sendOrderItemToDb($orderId, $amount, $price, $cardId);
                $this->model->changeOrderAmount($cardId, $amount);
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
