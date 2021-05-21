<?php
if (!isset($_SESSION['isAdmin'])) {
    header("refresh:0; url=index.php");
    die();
}

?>
<div class="col-md-5 mx-auto">
    <form id="registerForm" action="#" method="POST">

        <label for="cardName" class="visually-hidden"> Card Name</label>
        <input name="name" type="text" id="cardName" class="form-control" placeholder=" Card name" required>
        <br>
        <label for="cardAmount" class="visually-hidden"> Card Amount</label>
        <input name="amount" type="number" id="cardAmount" class="form-control" placeholder=" Card Amount" required>
        <br>
        <label for="cardDescription" class="visually-hidden"> Card Description</label>
        <textarea rows="10" name="description" type="text" id="cardDescription" class="form-control" placeholder=" Card Description" required> </textarea>
        <br>
        <label for="cardPrice" class="visually-hidden"> Card Price</label>
        <input name="price" type="number" id="cardPrice" class="form-control" placeholder=" Card Price" required>
        <br>
        <label for="cardImageUrl" class="visually-hidden"> Card Image</label>
        <input name="image" type="url" id="cardImageUrl" class="form-control" placeholder=" Card Image Url" required>
        <br>
        <label for="cardCategory" class="visually-hidden"> Card Category</label>
        <input name="category" type="text" id="cardCategory" class="form-control" placeholder=" Card Category" required>
        <br>
        <label class="visually-hidden" for="rarity">Choose Rarity:</label>
        <select class="form-control" id="cardRarity" name="rarity">

            <option value="Mythic Rare">Mythic Rare</option>
            <option value="Rare">Rare</option>
            <option value="Uncommon">Uncommon</option>
            <option value="Common">Common</option>

        </select>
        <br>
        <br>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Create</button><br><br>

    </form>
</div>