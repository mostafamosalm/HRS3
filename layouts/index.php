<?php
    session_start();
    $nonavbar = '';
    $pagetitle = 'Login';
        //look if there is a session or not
         if(isset($_SESSION['username'])){
         header('Location: dashboard.php'); // redirect to dashboard page
          }
    include '../layouts/init.php';

    // Check if user come from http request
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPass = sha1($password);
        // check if user exist in db
        $stmt = $con->prepare("SELECT username, password FROM users WHERE username = ? AND password = ?");
        $stmt->execute(array($username, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
         //if count > 0 ----> there is user
        if ($count > 0) {
            $_SESSION['username'] = $username; //register session name
            header('Location: dashboard.php'); // redirect to dashboard page
            exit();
        }
    }
?>
    <!-- login Form -->
    <div class="login-form">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="avatar">
                <img src="" alt="Avatar">
            </div>
            <h2 class="text-center">Login Page</h2>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required="required" autocomplete="new-password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" value="Login">Log in</button>
            </div>
        </form>
    </div>

<?php include $tpl . 'footer.php'; ?>