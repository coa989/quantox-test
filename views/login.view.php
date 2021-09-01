<?php
session_start();
include 'partials/header.php';
if(!isset($_SESSION['data'])) {
    $_SESSION['data'] = [
        'email_err' => '',
        'password_err' => '',
    ];
}
?>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card-body">
                <h5 class="card-title text-center">Sign In</h5>
                <form action="/login.php" class="form-signin" method="post">
                    <div class="form-label-group">
                        <input type="email" name="email" class="form-control <?=(!empty($_SESSION['data']['email_err'])) ? 'is-invalid' : ''; ?>" placeholder="Email Address" value="<?= (empty($_SESSION['data']['email'])) ? '' : $_SESSION['data']['email']; ?>">
                        <span class="invalid-feedback"><?= $_SESSION['data']['email_err']; ?></span>
                    </div>
                    <div class="form-label-group">
                        <input type="password" name="password" class="form-control <?=(!empty($_SESSION['data']['password_err'])) ? 'is-invalid' : ''; ?>" placeholder="Password">
                        <span class="invalid-feedback"><?= $_SESSION['data']['password_err']; ?></span>
                    </div>
                    <button class="btn btn-dark btn-block text-uppercase" type="submit">Login</button>
                    <hr class="my-4">
                    <a href="register.view.php"><span class="btn btn-light btn-block">No account? Register</span></a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
unset($_SESSION['data']);
session_destroy();
include 'partials/footer.php'; ?>