<?php

if (!isset($_SESSION['isAdmin'])) {
    header("refresh:0; url=index.php");
    die();
}
?>

<table class="table table-hover mt-3">
        <thead>
            <tr>
                <th scope="col">Card Id</th>
                <th scope="col">Card Name</th>
                <th scope="col">Card Amount</th>
                <th scope="col">Card Price</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>

<?php

foreach ($cards as $card) {
    viewOneProduct($card);
}

function viewOneProduct($card){
    $html = <<<HTML

        <tr>
            <td>$card[id]</td>
            <td>$card[name]</td>
            <td>$card[amount]</td>
            <td>$card[price]</td>
            <td>
                <form action="#" method="post">
                    <input type="hidden" name="cardId" value="$card[id]">
                    <input type="submit" class="btn btn-danger" value="Delete">
                </form>
            </td>
        </tr>

    HTML;
    
    echo $html;

}
?>