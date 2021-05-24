<?php

class AdminController
{

    public $model;
    public $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function getHeader($title)
    {
        $this->view->viewHeader($title);
    }

    public function getFooter()
    {
        $this->view->viewFooter();
    }

    /*****************
     * PAGES
     */

    public function adminOrderPage()
    {
        $this->getHeader("Admin Order page");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])) {
            $this->adminChangeOrderStatus();
        }
        $this->view->viewAdminOrderPage();
        $this->adminOrderHandling();
        $this->getFooter();
    }

    public function adminProductPage()
    {
        $this->getHeader("Admin Product page");
        $this->view->viewAdminProductPage();
        $this->getFooter();
    }

    public function adminDeletePage()
    {
        $this->getHeader("Admin Delete page");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cardId'])) {
            $this->adminDeleteProduct();
        }
        $cards = $this->model->fetchAllCards();
        $this->view->viewAdminDeletePage($cards);
        $this->getFooter();
    }
    public function adminUpdatePage()
    {
        $this->getHeader("Admin Update page");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cardId']) && !isset($_POST['category'])) {
            $cardId = $this->sanitize($_POST['cardId']);
            $card = $this->model->fetchCardById($cardId);
            $this->view->viewAdminUpdateDetailPage($card);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category'])) {
            $this->adminUpdateProduct();
        }
        $cards = $this->model->fetchAllCards();
        $this->view->viewAdminUpdatePage($cards);
        $this->getFooter();
    }
    public function adminCreatePage()
    {
        $this->getHeader("Admin Create page");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
            $this->adminCreateProduct();
        }
        $this->view->viewAdminCreatePage();
        $this->getFooter();
    }

    /***************************
     * DB Functions ADMIN
     */

    public function adminOrderHandling()
    {
        $ordersToHandle = $this->model->fetchAllOrders();
        $this->view->viewAllOrdersToHandle($ordersToHandle);

        if (!isset($ordersToHandle)) {
            $this->view->viewErrorMessage();
        }
    }

    public function adminChangeOrderStatus()
    {
        $orderId = $this->sanitize($_POST['orderId']);
        $confirmed = $this->model->changeOrderStatus($orderId);

        if ($confirmed) {
            $this->view->viewErrorMessage();
        } else {
            $type = "sent";
            $this->view->viewConfirmMessageSuccess($orderId, $type);
        }
    }

    public function adminDeleteProduct()
    {
        $cardId = $this->sanitize($_POST['cardId']);
        $confirmed = $this->model->deleteProduct($cardId);

        if ($confirmed) {
            $this->view->viewErrorMessage();
        } else {
            $type = "deleted";
            $this->view->viewConfirmMessageSuccess($cardId, $type);
        }
    }

    public function adminCreateProduct()
    {
        extract($_POST);
        $name = $this->sanitize($name);
        $amount = $this->sanitize($amount);
        $description = $this->sanitize($description);
        $price = $this->sanitize($price);
        $image = $this->sanitize($image);
        $category = $this->sanitize($category);
        $rarity = $this->sanitize($rarity);

        $confirmed = $this->model->createProduct($name,  $amount,  $description,  $price, $image, $category, $rarity);
        if ($confirmed) {
            $type = "created";
            $this->view->viewConfirmMessageSuccess($name, $type);
            header("refresh:1; url=index.php");
        } else {
            $this->view->viewErrorMessage();
        }
    }
    public function adminUpdateProduct()
    {
        extract($_POST);
        $id = $this->sanitize($id);
        $name = $this->sanitize($name);
        $amount = $this->sanitize($amount);
        $description = $this->sanitize($description);
        $price = $this->sanitize($price);
        $image = $this->sanitize($image);
        $category = $this->sanitize($category);
        $rarity = $this->sanitize($rarity);

        $confirmed = $this->model->updateProduct($id, $name,  $amount,  $description,  $price, $image, $category, $rarity);
        if ($confirmed) {
            $type = "updated";
            $this->view->viewConfirmMessageSuccess($name, $type);
            header('refresh:1; Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            $this->view->viewErrorMessage();
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
