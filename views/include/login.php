<div class="col-md-5 mx-auto">
    <form id="registerForm" action="#" method="POST">

        <label for="inputEmail" class="visually-hidden">Email address</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" value="" required>
        <br>
        <label for="inputPassword" class="visually-hidden">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control mb-3" placeholder="Password" value="" required>
        <br>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button><br><br>

        <div class="text-center">
            <h5 class="mt-2">Not a user yet? <a href=" ?page=register">Register here!</a></h5>
        </div>

    </form>
</div>

<?php

// print_r($_POST);
