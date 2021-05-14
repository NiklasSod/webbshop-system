<form id="registerForm" action="/user/register" method="post">
    <h1 class="h3 mb-3 fw-normal">Please register</h1>



    <label for="inputEmail" class="visually-hidden">Email address</label>
    <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" value="" required>

    <label for="inputPassword" class="visually-hidden">Password</label>
    <input name="password" id="inputPassword" class="form-control mb-3" placeholder="Password" value="" required>


    <button class=" mb-3 w-100 btn btn-lg btn-primary" type="submit">Register</button>


    <h3><a href="?page=login">Login </a></h3>

</form>