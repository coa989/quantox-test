<?php
session_start();
include 'partials/header.php';
if(!isset($_SESSION['data'])) {
    $_SESSION['data'] = [
    'name_err' => '',
    'email_err' => '',
    'password_err' => '',
    'confirm_password_err' => ''
    ];
}
?>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card-body">
                <h5 class="card-title text-center">Create Account</h5>
                <form action="../register.php" method="post">
                    <div class="form-label-group">
                        <input class="form-control <?=(!empty($_SESSION['data']['name_err'])) ? 'is-invalid' : ''; ?>" type="text" name="name" placeholder="Name" value="<?= (empty($_SESSION['data']['name'])) ? '' : $_SESSION['data']['name']; ?>">
                        <span class="invalid-feedback"><?= $_SESSION['data']['name_err']; ?></span>
                    </div>
                    <div class="form-label-group">
                        <input class="form-control <?=(!empty($_SESSION['data']['email_err'])) ? 'is-invalid' : ''; ?>" type="email" name="email" placeholder="Email" value="<?= (empty($_SESSION['data']['email'])) ? '' : $_SESSION['data']['email']; ?>">
                        <span class="invalid-feedback"><?= $_SESSION['data']['email_err']; ?></span>
                    </div>
                    <div class="form-label-group">
                        <input class="form-control <?=(!empty($_SESSION['data']['password_err'])) ? 'is-invalid' : ''; ?>" type="password" name="password" placeholder="Password">
                        <span class="invalid-feedback"><?= $_SESSION['data']['password_err']; ?></span>
                    </div>
                    <div class="form-label-group">
                        <input class="form-control <?=(!empty($_SESSION['data']['confirm_password_err'])) ? 'is-invalid' : ''; ?>" type="password" name="confirm_password" placeholder="Confirm Password">
                        <span class="invalid-feedback"><?= $_SESSION['data']['confirm_password_err']; ?></span>
                    </div>
                    <button class="btn btn-dark btn-block text-uppercase" type="submit">Register</button>
                    <hr class="my-4">
                    <a href="login.view.php"><span class="btn btn-light btn-block">Already have account? Login</span></a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_SESSION)) {
    unset($_SESSION['data']);
    session_destroy();
}
include 'partials/footer.php';