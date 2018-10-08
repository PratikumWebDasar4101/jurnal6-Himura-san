<?php
    require("config.php");
    session_start();

    if (@$_SESSION['sukses'])
        header("Location: form.php");
        
    if (@$_GET['exit']) {
        session_destroy();
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style_lr.css">
</head>
<body>
    <a href="register.php" id="button">Register</a>
<!-- =============================================================================== -->
    <div class="login">
        <div id="title">
            <h3>Login</h3>
        </div>
        <div id="data">
            <form method="POST">
                <b>Username</b><br><input type="text" name="username" required><br><br>
                <b>Password</b><br><input type="password" name="password" required><br><br>
                <input type="submit" value="Login"> <input type="reset" value="Reset">
            </form>
        </div>
    </div>
<!-- =============================================================================== -->
</body>
</html>
<?php
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = $pdo -> prepare("SELECT * FROM tb_account WHERE username = '$username' AND password = '$password'");
        $query -> execute();
        $row = $query -> rowcount();
        $data = $query -> fetch(PDO::FETCH_ASSOC);

        if ($row != 0) {
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['sukses'] = "Sukses";
            header("Location: form.php");
        } else {
            ?>
            <script type="text/javascript">
                alert("Username atau Password salah..!!");
            </script>
            <?php
        }
    }
?>