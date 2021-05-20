<div class="col-md-5 mx-auto">
    <form id="registerForm" action="#" method="POST">

        <label for="inputEmail" class="visually-hidden">Email address</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" value="" required>
        <br>
        <label for="inputPassword" class="visually-hidden">Password</label>
        <input name="password" id="inputPassword" class="form-control mb-3" placeholder="Password" value="" required>
        <br>
        <input hidden="true" name="admin" value="admin" required>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>

        <div class="text-center">
            <h5 class="mt-3 bg-light rounded col-md-8 mx-auto">This form is for admins<br>If you are a user then</h5>
            <h5 class="mt-3"><a href=" ?page=login">Login</a> or <a href=" ?page=register">Register</a></h5>
        </div>

    </form>
</div>

<?php
