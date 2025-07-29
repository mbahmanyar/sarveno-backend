<?php require_once path('/app/Views/Shares/head.php') ?>
<?php require_once path('/app/Views/Shares/open_body.php') ?>


<div id="register" class="container">


    <div class="form-wrapper">

        <h1 class="title">Register</h1>
        <p class="sub-title">Create a new account</p>

        <form id="register-form" method="POST" action="/api/register">
            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <a class="sub-link" href="/login">Have you registered? Let's log in.</a>

    </div>

</div>

<?php require_once path('/app/Views/Shares/close_body.php') ?>
