<?php
session_start();

include 'partials/header.php';

if(!empty($_SESSION['result'])): ?>
    <div class="container">
        <table class="table">
        <?php foreach($_SESSION['result'] as $user): ?>
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $user->name ?></td>
                    <td><?= $user->email ?></td>
                </tr>
                </tbody>
        <?php endforeach; ?>
        </table>
    </div>

<?php else: ?>
    <h5 class="card-title text-center mt-3">No users found!</h5>
<?php
endif;
include 'partials/footer.php';
?>