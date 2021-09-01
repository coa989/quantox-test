<?php
session_start();
include 'partials/header.php';
if(isset($_SESSION['user_id'])):
    ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card-body">
                    <h5 class="card-title text-center">Welcome <?= $_SESSION['user_name']; ?>!</h5>
                </div>
            </div>
        </div>
    </div>
<?php
else:
    header('Location: login.view.php');
endif;
include 'partials/footer.php';

?>