<form id="registerForm" action="#" method="POST">
    <h1 class="h3 mb-3 fw-normal">Admin, Please Login</h1>

    <label for="inputEmail" class="visually-hidden">Email address</label>
    <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" value="" required>

    <label for="inputPassword" class="visually-hidden">Password</label>
    <input name="password" id="inputPassword" class="form-control mb-3" placeholder="Password" value="" required>
    <input hidden="true" name="admin" value="admin" required>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>

</form>

<?php

// print_r($_POST);
