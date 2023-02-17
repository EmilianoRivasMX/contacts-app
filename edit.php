<?php
require 'connection.php';

session_start();
// Restringe el acceso a la página sin estar autenticado
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    return;
}

$id = $_GET['id'];

// Verifica si existe un contacto asociado con el id recibido
$stmt = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
$stmt->execute([":id" => $id]);

if ($stmt->rowCount() == 0) {
    http_response_code(404);
    echo "HTTP 404 NOT FOUND";
    return;
}

$contact = $stmt->fetch(PDO::FETCH_ASSOC);

// Impede la edicion de contactos de otros usuarios
if ($contact['user_id'] !== $_SESSION['user']['id']) {
    http_response_code(403);
    echo "HTTP 403 UNAUTHORIZED";
    return;
}

$error = null;

// Valida y actualiza el contacto en la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name']) || empty($_POST['phone'])) {
        $error = "Please fill all the fields";
    } elseif (strlen($_POST['phone']) < 10) {
        $error = "The phone number must be al leats 10 characters";
    } elseif (!is_numeric($_POST['phone'])) {
        $error = "The phone is not a numeric string";
    } else {
        try {
            $conn->prepare("UPDATE contacts SET name = :name, phone = :phone WHERE id = :id")
                 ->execute([
                    ":id"    => $id,
                    ":name"  => $_POST['name'],
                    ":phone" => $_POST['phone']
                 ]);
        } catch(PDOException $error) {
            die($error->getMessage());
        }

        // Rediirige a la página de inicio
        $_SESSION['flash'] = ["message" => "Contact {$_POST["name"]} updated"];
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
                    <form method="POST" action="edit.php?id=<?= $contact['id'] ?>">
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
            
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" value="<?= $contact['name'] ?>" name="name" maxlength="30" required autocomplete="name" autofocus>
                            </div>
                        </div>
            
                        <div class="mb-3 row">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">Phone Number</label>
            
                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control" value="<?= $contact['phone'] ?>" name="phone" maxlength="15" required autocomplete="phone">
                            </div>
                        </div>
            
                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Update</button>
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
