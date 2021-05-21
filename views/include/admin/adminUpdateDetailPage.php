<?php
if (!isset($_SESSION['isAdmin'])) {
    header("refresh:0; url=index.php");
    die();
}

$html = <<<HTML
<div class="col-md-5 mx-auto">
    <form id="registerForm" action="#" method="POST">

    <input name="id" type="hidden" value='$cards[id]'>

        <label for="cardName" class="visually-hidden"> Card Name</label>
        <input name="name" type="text" id="cardName" class="form-control" value='$cards[name]'>
        <br>
        <label for="cardAmount" class="visually-hidden"> Card Amount</label>
        <input name="amount" type="number" id="cardAmount" class="form-control" value='$cards[amount]'>
        <br>
        <label for="cardDescription" class="visually-hidden"> Card Description</label>
        <textarea rows="10" name="description" type="text" id="cardDescription" class="form-control" >$cards[description]</textarea>
        <br>
        <label for="cardPrice" class="visually-hidden"> Card Price</label>
        <input name="price" type="number" id="cardPrice" class="form-control" value='$cards[price]'>
        <br>
        <label for="cardImageUrl" class="visually-hidden"> Card Image</label>
        <input name="image" type="url" id="cardImageUrl" class="form-control"value='$cards[image]'>
        <br>
        <label for="cardCategory" class="visually-hidden"> Card Category</label>
        <input name="category" type="text" id="cardCategory" class="form-control" value='$cards[category]'>
        <br>
        <label class="visually-hidden" for="rarity">Choose Rarity:</label>
        <select class="form-control" id="cardRarity" name="rarity">


        <option value="selected " >$cards[rarity]</option>

            <option value="Mythic Rare">Mythic Rare</option>
            <option value="Rare">Rare</option>
            <option value="Uncommon">Uncommon</option>
            <option value="Common">Common</option>

        </select>
        <br>
        <br>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Update</button><br><br>

    </form>
</div>
HTML;
echo $html;
