<?php

class View
{

    public function viewHeader($title)
    {
        include_once("views/include/header.php");
    }

    public function viewFooter()
    {
        include_once("views/include/footer.php");
    }

    public function viewAboutPage()
    {
        include_once("views/include/about.php");
    }

    public function registerPage()
    {
        include_once("views/include/register.php");
    }
    public function loginPage()
    {
        include_once("views/include/login.php");
    }

    public function logoutPage()
    {
        include_once("views/include/logout.php");
    }

    public function viewOneCard($card)
    {
        $html = <<<HTML
        
            <div class="col-md-4">
                <a href="?page=order&id=$card[id]">
                    <div class="card m-1">
                        <img class="card-img-top img-thumbnail" 
                            src="$card[image]" alt="$card[name]">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h5>$card[name]</h5>
                                <p>Pris: $card[price] kr</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>  <!-- col -->
        HTML;

        echo $html;
    }

    public function viewCardDetails($card)
    {
        $html = <<<HTML
        
            <div class="col-md-5">
                    <div class="card m-1">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h5>$card[description]</h5>
                                <p>Antal kvar: $card[amount] </p>
                            </div>
                        </div>
                    </div>
            </div>  <!-- col -->
        HTML;

        echo $html;
    }

    public function viewAllCards($cards)
    {
        foreach ($cards as $card) {
            $this->viewOneCard($card);
        }
    }

    public function viewOrderPage($card)
    {
        $this->viewOneCard($card);
        $this->viewCardDetails($card);
        $this->viewOrderForm($card);
    }

    public function viewOrderForm($card)
    {

        $html = <<<HTML
            <div class="col-md-4 mx-auto">
            
                <form action="#" method="post">
                    <input type="hidden" name="id" 
                            value="$card[id]">
                    <input type="number" name="customer_id" required 
                            class="form-control form-control-lg my-2" 
                            placeholder="Välj antal kort!">
                
                    <input type="submit" class="form-control my-2 btn btn-lg btn-outline-success" 
                            value="Skicka beställningen">
                </form>
                
            <!-- col avslutas efter ett meddelande från viewConfirmMessage eller viewErrorMessage -->
        HTML;

        echo $html;
    }

    public function viewConfirmMessageRegister($userInfo)
    {
        $this->printMessage(
            "<h4>User $userInfo Created, pls login</h4>
            ",
            "success"

        );
    }

    public function viewConfirmMessageLogin($userInfo)
    {
        $this->printMessage(
            "<h4>User $userInfo logged in!</h4>
            ",
            "success"

        );
    }

    public function viewErrorMessage()
    {
        $this->printMessage(
            "<h4>Något gick fel, försök igen eller kontakta kundkänst</h4>
            </div> <!-- col  avslutar Beställningsformulär -->
            ",
            "warning"
        );
    }

    /**
     * En funktion som skriver ut ett felmeddelande
     * $messageType enligt Bootstrap Alerts
     * https://getbootstrap.com/docs/5.0/components/alerts/
     */
    public function printMessage($message, $messageType = "danger")
    {
        $html = <<< HTML
            <div class="my-2 alert alert-$messageType">
                $message
            </div>
        HTML;

        echo $html;
    }
}
