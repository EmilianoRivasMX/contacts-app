<?php
require 'connection.php';

session_start();
// Restringe el acceso a la página sin estar autenticado
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    return;
}

$contacts = $conn->query("SELECT * FROM contacts WHERE user_id = {$_SESSION['user']['id']}");
?>

<?php require 'partials/header.php'; ?>
<div class="container pt-4 p-3">
    <div class="row">
    <?php if ($contacts->rowCount() == 0): ?>
        <div class="col-md-6 mx-auto">
            <div class="card card-body text-center p-4">
                <p>No contacts saved yet</p>
                <a href="./add-contact.php">Add one!</a>
            </div>
        </div>
    <?php endif ?>
    <?php foreach ($contacts as $contact): ?>
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title text-capitalize"><?= $contact['name'] ?></h3>
                    <p class="m-2"><?= $contact['phone'] ?></p>
                    <a href="edit.php?id=<?= $contact['id'] ?>" class="btn btn-info mb-2">Edit Contact</a>
                    <a href="delete.php?id=<?= $contact['id'] ?>" class="btn btn-danger mb-2">Delete Contact</a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    </div>
</div>
<?php require 'partials/footer.php'; ?>