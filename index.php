<?php

session_start();

include __DIR__ . '/autenticazione.php';

define("DB_SERVERNAME", 'localhost');
define("DB_USERNAME", 'root');
define("DB_PASSWORD", 'root');
define("DB_NAME", 'login');

$conn = new mysqli (DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn && $conn->connect_error) {
    echo 'Errore di connessione al DB: ' . $conn->connect_error;
}

//verifico se ho passato in modalità post name e password
if (isset($_POST['name']) && isset($_POST['password'])) {
    login($_POST['name'], $_POST['password'], $conn);
}

if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] !== 0) {
    $sql = "SELECT `name`, `email` FROM `departments`";
    $result = $conn->query($sql);
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<body>
    
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Sistema di login</a>
               
                <form class="d-flex" method="POST" action="logout.php">
                    <input type="hidden" name="logout" value="1"/>
                    <button class="btn btn-outline-success" type="submit">Logout</button>
                </form>
        
            </div>
            </nav>
    </header>

    <main>
        <div class="container">

            <?php if (!empty($_SESSION['user_id']) && !empty($_SESSION['username'])) { ?>

                <h3>Benvenuto <?php echo $_SESSION['username']; ?></h3>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0 ) { 
                            while ($row = $result->fetch_assoc()) {

                                echo '<tr>
                                        <td>' . $row['name']. '</td>
                                        <td>' . $row['email'] . '</td>
                                    </tr>';

                            }
                        } ?>
                    </tbody>
                </table>

            <?php }  else { ?>

                
                <?php 
                    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 0) {
                        echo '<div class="alert alert-danger" role="alert">
                                Credenziali di login non valide!
                            </div>';
                    }
                ?>

                <form method="POST" action="index.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

            <?php } ?>
        </div>

    </main>

</body>
</html>