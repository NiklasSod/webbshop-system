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
                // case "order":
                //     $this->order();
                //     break;
            case "register":
                $this->register();
                break;
            case "login":
                $this->login();
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
    private function register()
    {
        $this->getHeader("register");
        $this->view->registerPage();

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->registerUserToDb();
        // $this->registerCustomer();
        $this->getFooter();
    }


    private function login()
    {
        $this->getHeader("login");
        $this->view->loginPage();
        $this->getFooter();
    }


    private function getAllCards()
    {
        $this->getHeader("Welcome");
        $cards = $this->model->fetchAllCards();
        $this->view->viewAllCards($cards);
        $this->getFooter();
    }
    // * *************************
    // private function registerCustomer()
    // {
    //     $this->getHeader("Beställning");

    //     $id = $this->sanitize($_GET['id']);
    //     $card = $this->model->fetchCardById($id);

    //     if ($card)
    //         $this->view->viewOrderPage($card);

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST')
    //         $this->registerUserToDb();

    //     $this->getFooter();
    // }
    // ** *************************

    private function registerUserToDb()
    {
        $CustomerFirstname    = $this->sanitize($_POST['firstname']);
        $CustomerLastname = $this->sanitize($_POST['lastname']);
        $CustomerEmail = $this->sanitize($_POST['email']);
        $CustomerPassword = $this->sanitize($_POST['password']);
        $createdCustomer = $this->model->ModelRegisterCustomer($CustomerFirstname, $CustomerLastname, $CustomerEmail, $CustomerPassword);

        if ($createdCustomer) {
            $lastInsertCustomer = $CustomerFirstname;
            $this->view->viewConfirmMessage($lastInsertCustomer);
        } else {
            $this->view->viewErrorMessage($CustomerFirstname);
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
