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

    public function viewCustomerPage($orders)
    {
        include_once("views/include/customerPage.php");
    }

    public function registerPage()
    {
        include_once("views/include/register.php");
    }
    public function loginPage()
    {
        include_once("views/include/login.php");
    }

    public function loginAdminPage()
    {
        include_once("views/include/loginadmin.php");
    }

    public function logoutPage()
    {
        include_once("views/include/logout.php");
    }

    public function viewOrderConfirmPage()
    {
        include_once("views/include/orderconfirm.php");
    }

    public function viewCartPage()
    {
        include_once("views/include/shoppingcart.php");
        if (isset($_SESSION['order'])) {
            $this->viewAllOrdersInCart();
        }
    }

    public function updatedTotalCardAmount($card)
    {
        $updatedAmount = $card['amount'];

        if (isset($_SESSION['order'])) {
            $amountOfOrders = count($_SESSION['order']);
            for ($i = 0; $i < $amountOfOrders; $i++) {

                if ($_SESSION['order'][$i]['id'] === $card['id']) {
                    $updatedAmount = $card['amount'] -= $_SESSION['order'][$i]['amount'];
                }
            }
        }
        return $updatedAmount;
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
        $amountLeft =  $this->updatedTotalCardAmount($card);

        $html = <<<HTML
        
            <div class="col-md-5">
                    <div class="card m-1">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h5>$card[description]</h5>
                                <p>Antal kvar: $amountLeft</p>
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
        $amountLeft =  $this->updatedTotalCardAmount($card);

        $showbtn = 'enabled';

        if ($amountLeft == '0') {

            $showbtn = 'disabled';
        }

        $html = <<<HTML
            <div class="col-md-4 mx-auto">
            
                <form action="?page=shoppingcart" method="post">
                    <input type="hidden" name="id" 
                            value="$card[id]">
                    <input type="hidden" name="title" 
                            value="$card[name]">
                    <input type="hidden" name="check" 
                            value="check">
                    <input type="hidden" name="price" 
                            value="$card[price]">
                    <input type="number" value=1 min=1 max=$amountLeft name="amount" required 
                            class="form-control form-control-lg my-2" 
                            >
                
                    <input type="submit" class="form-control my-2 btn btn-lg btn-outline-success" 
                            value="Lägg till i varukorgen" $showbtn>
                </form>
                
            <!-- col avslutas efter ett meddelande från viewConfirmMessage eller viewErrorMessage -->
        HTML;

        echo $html;
    }

    private function viewAllOrdersInCart()
    {

        $row = 0;
        $btnPossition = -1;
        $totalt = 0;

        foreach ($_SESSION['order'] as $order) {
            $row += 1;
            $btnPossition +=1;

            $sum = $this->viewOneOrderInCart($order, $row, $btnPossition);
            $totalt += $sum;
        }

        echo $totalt;

        if(isset($_SESSION['customer_id'])){
        $html = <<<HTML
            
            <form method="post" action="?page=orderconfirm">
            <input type="hidden" name="sendOrder" value=true>
                <input type="submit" value="check out">
            </form>

        HTML;

        echo $html;
        }
    }

    private function viewOneOrderInCart($order, $row, $btnPossition)
    {
        $sum = $order['price'] * $order['amount'];

        $html = <<<HTML
        
                <tr>
                <th scope="row">$row</th>
                <td>$order[title]</td>
                <td>$order[price]</td>
                <td>$order[amount]</td>
                <td>$sum</td>
                <td>
                    <form method="POST" action="?page=shoppingcart">
                        <input value=$btnPossition name="orderIndex" hidden="true"></input>
                        <input type="submit"></input>
                    </form>
                </td>
                </tr>

        HTML;

        echo $html;

        return $sum;
    }    

    public function viewConfirmMessageSend($userInfo)
    {
        $this->printMessage(
            "<h4>$_SESSION[email] Order confirmed!!</h4>
            ",
            "success"

        );
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
