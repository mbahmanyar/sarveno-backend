<?php require_once path('/app/Views/Shares/head.php') ?>


<div id="login" class="container">


    <div class="form-wrapper">

        <h1 class="title">Sign in</h1>
        <p class="sub-title">Log in to your account</p>

        <form id="register-form" method="POST" action="/api/login">
            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Log in</button>
        </form>

    </div>

</div>