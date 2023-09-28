<?php
    include ".././db/conn.php";
    $d = new Database();
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['sign'])) {
        $u = $_POST['auth_user'];
        $s = "SELECT `pass` FROM `admin` WHERE `user` = '$u'";
        $dpass = $d->RetriveSingle($s);
        if ($dpass['pass'] == $_POST['auth_pass']) {
          header('Location: ../admin');
          session_start();
          $_SESSION['admin'] = true;
        }
        else{
          header('Location: ../admin/sign-in?type=error');
        }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Sign in as admin | Agri Chat</title>
</head>
<style>
    *{
        margin: 0;padding: 0;box-sizing: border-box;
    }
    body{
        width: 100%;
        height: 100vh;
        background: #f5f5f5;
    }
</style>
<body class="d-flex align-items-center justify-content-center">

    <main class="form-signin p-3" >

        <form method="POST" action="sign-in.php">
          <!-- <img class="mb-4" src="assets/img/logo.png" alt="" width="100" height="auto" style=" object-fit: cover; margin: 0 auto;"> -->
          <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>

          <?php
            if (isset($_GET['type']) && $_GET['type']=="error") {
              echo '<div class="alert alert-danger" role="alert">
              Invalid Credentials
            </div>';
            }
          ?>
          
      
          <div class="form-floating mb-2">
            <input type="text" name="auth_user" class="form-control" id="floatingInput" placeholder="name@example.com" required>
            <label for="floatingInput">User Name</label>
          </div>
          <div class="form-floating mb-2">
            <input type="password" name="auth_pass" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
          </div>
      
          <button class="w-100 btn btn-lg btn-primary mx-auto" type="submit" name="sign">Sign in</button>
          <p class="mt-3 mb-3 text-center text-muted">© All Rights Reserved. BeetaBie | 2022</p>
        </form>
      </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>