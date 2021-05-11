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
            case "order":
                $this->order();
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
        $this->getHeader("About us");
        $this->view->viewAboutPage();
        $this->getFooter();
    }

    private function getAllCards()
    {
        $this->getHeader("Welcome");
        $cards = $this->model->fetchAllCards();
        $this->view->viewAllCards($cards);
        $this->getFooter();
    }

    private function order()
    {
        $this->getHeader("Beställning");

        $id = $this->sanitize($_GET['id']);
        $card = $this->model->fetchCardById($id);

        if ($card)
            $this->view->viewOrderPage($card);

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->processOrderForm();

        $this->getFooter();
    }

    private function processOrderForm()
    {
        $card_id    = $this->sanitize($_POST['id']);
        $customer_id = $this->sanitize($_POST['customer_id']);
        $confirm = $this->model->saveOrder($customer_id, $card_id);

        if ($confirm) {
            $customer = $confirm['customer'];
            $lastInsertId = $confirm['lastInsertId'];
            $this->view->viewConfirmMessage($customer, $lastInsertId);
        } else {
            $this->view->viewErrorMessage($customer_id);
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
