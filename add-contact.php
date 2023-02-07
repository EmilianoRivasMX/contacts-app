<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Crea un nuevo contacto
        $contact = [
            "name"  => $_POST["name"],
            "phone" => $_POST["phone"]
        ];

        // Verifica si ya existe una lista de contactos
        if (file_exists("contacts.json")) {
            $contacts = json_decode(file_get_contents("contacts.json"), true);
        }
        else {
            $contacts = [];
        }
    
        // Añade el nuevo contacto a la lista actual de contactos
        $contacts[] = $contact; 

        file_put_contents("contacts.json", json_encode($contacts));
        
        // Rediirige a la página de inicio
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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
    
        <title>Add contacts</title>
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
        <div class="container pt-5 p-3">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Add New Contact</div>
                        <div class="card-body">
                            <form method="POST" action="add-contact.php">
                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                    
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                                    </div>
                                </div>
                    
                                <div class="mb-3 row">
                                    <label for="phone" class="col-md-4 col-form-label text-md-end">Phone Number</label>
                    
                                    <div class="col-md-6">
                                        <input id="phone" type="tel" class="form-control" name="phone" required autocomplete="phone_number" autofocus>
                                    </div>
                                </div>
                    
                                <div class="mb-3 row">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>