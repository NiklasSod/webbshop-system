<div class="col-md-5 mx-auto">
    <form id="registerForm" action="#" method="post">
        <label for="firstNameInput" class="visually-hidden"> Firstname</label>
        <input name="firstname" type="text" id="firstNameInput" class="form-control" placeholder="Firstname" value="" required>
        <br>
        <label for="lastNameInput" class="visually-hidden">Lastname</label>
        <input name="lastname" type="text" id="lastNameInput" class="form-control" placeholder=" Lastname" value="" required>
        <br>
        <label for="inputEmail" class="visually-hidden">Email address</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" value="" required>
        <br>
        <label for="inputPassword" class="visually-hidden">Password</label>
        <input name="password" id="inputPassword" class="form-control mb-3" placeholder="Password" value="" required>
        <br>
        <button class=" mb-3 w-100 btn btn-lg btn-primary" type="submit">Register</button>

        <div class="text-center">
            <h5 class="mt-2">Already have an account? <a href="?page=login">Login here</a></h5>
        </div>

    </form>
</div>