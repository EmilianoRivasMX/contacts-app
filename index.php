<?php
    if (file_exists("contacts.json")) {
        /* Por defecto json_decode devuelve un objeto, 
        *  para devolver un array asocitativo colocamos el segundo parámetro como true */
        $contacts = json_decode(file_get_contents("contacts.json"), true);
    }
    else {
        $contacts = [];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link  rel="icon" href="./static/img/logo.png" type="image/png" />
    <link rel="stylesheet" href="./static/css/style.css">

    <!-- Bootswatch CDN -->
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.2/quartz/bootstrap.min.css" 
        integrity="sha512-GlPFmIhfvCl79w3jNnFX4LG5pP/bRPOyHDVjUXs3aWOrMC0HNHRdH5RrplrQZQDshU+9ibUHsE5Mkznt3ClPpQ==" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer" />
    
    <!-- Bootstrap bundle -->
    <script 
        defer
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" 
        crossorigin="anonymous" >
    </script>

    <title>Contacts App</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand font-weight-bold" href="#">
                <img class="mr-2" src="./static/img/logo.png" />
                ContactsApp
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./add-contact.php">Add Contact</a>
                </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="container pt-4 p-3">
            <div class="row">
            <?php if (count($contacts) == 0): ?>
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
                            <a href="#" class="btn btn-info mb-2">Edit Contact</a>
                            <a href="#" class="btn btn-danger mb-2">Delete Contact</a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            </div>
        </div>
    </main>
</body>
</html>