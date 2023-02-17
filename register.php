<?php
    require 'connection.php';

    $error = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
            $error = "Please fill all the fields";
        } elseif (!str_contains($_POST['email'], "@") || !str_contains($_POST['email'], ".com")) {
            $error = "Please, enter a valid email";
        } else {
            // Comprueba si existe el usuario a traves del email
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(":email", $_POST['email']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $error = "This email is taken";
            } else {
                try {
                    // Reigstra el nuevo usuario
                    $conn->prepare("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)")
                    ->execute([
                       ":name" => $_POST['name'], 
                       ":email" => $_POST['email'], 
                       ":password" => password_hash($_POST['password'], PASSWORD_BCRYPT)
                    ]);

                    // Comprueba si existe el nuevo usuario
                    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
                    $stmt->bindParam(":email", $_POST['email']);
                    $stmt->execute();

                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    unset($user['password']);   // Elimina la contraseña del array $user
                    session_start();            // Inicia la sesión
                    $_SESSION['user'] = $user;

                } catch (PDOException $error) {
                    die($error->getMessage());
                }
                
                header("Location: home.php");
            }

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
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form method="POST" action="register.php">
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
            
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" maxlength="50" required autocomplete="name" autofocus>
                            </div>
                        </div>
            
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
            
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" maxlength="50" required autocomplete="email">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
            
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" maxlength="50" required autocomplete="password">
                            </div>
                        </div>
            
                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
