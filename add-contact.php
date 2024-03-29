<?php
    require 'connection.php';

    session_start();
    // Restringe el acceso a la página sin estar autenticado
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        return;
    }

    $error = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['name']) || empty($_POST['phone'])) {
            $error = "Please fill all the fields";
        } elseif (strlen($_POST['phone']) < 10) {
            $error = "The phone number must be al leats 10 characters";
        } elseif (!is_numeric($_POST['phone'])) {
            $error = "The phone is not a numeric string";
        } else {
            // Inserta un nuevo registro en la base de datos
            $stmt = $conn->prepare("INSERT INTO contacts(name, phone, user_id) VALUES(:name, :phone, {$_SESSION['user']['id']})");
            $stmt->bindParam(":name", $_POST["name"]);
            $stmt->bindParam(":phone", $_POST["phone"]);
            $stmt->execute();

            $_SESSION['flash'] = ["message" => "Contact {$_POST["name"]} added"];

            // Rediirige a la página de inicio
            header("Location: home.php");
            return;
        }
    }
?>

<?php require 'partials/header.php'; ?>
<div class="container pt-5 p-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if ($error): ?>
                <div class="alert alert-dismissible alert-primary">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <p class="mb-0">Error: <?= $error ?></p>
                </div>
            <?php endif ?>
            <div class="card">
                <div class="card-header">Add New Contact</div>
                <div class="card-body">
                    <form method="POST" action="add-contact.php">
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
            
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" maxlength="30" required autocomplete="name" autofocus>
                            </div>
                        </div>
            
                        <div class="mb-3 row">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">Phone Number</label>
            
                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control" name="phone" maxlength="15" required autocomplete="phone">
                            </div>
                        </div>
            
                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Add</button>
                                <a href="home.php" class="btn btn-info">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
