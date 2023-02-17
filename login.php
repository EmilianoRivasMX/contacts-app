<?php
    require 'connection.php';

    $error = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $error = "Please fill all the fields";
        } elseif (!str_contains($_POST['email'], "@") || !str_contains($_POST['email'], ".com")) {
            $error = "Please, enter a valid email";
        } else {
            // Comprueba si existe el usuario a traves del email
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->bindParam(":email", $_POST['email']);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                $error = "The user does not exist";
            } else {
                // Obtiene al usuario y valida sus credenciales
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!password_verify($_POST['password'], $user['password'])) {
                    $error = "Invalid credentials";
                } else {
                    unset($user['password']);    // Elimina la contraseña del array $user
                    
                    session_start(); // Inicia la sesión
                    $_SESSION['user'] = $user;

                    header("Location: home.php");
                    return;
                }
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
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="POST" action="login.php">            
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
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'partials/footer.php'; ?>
