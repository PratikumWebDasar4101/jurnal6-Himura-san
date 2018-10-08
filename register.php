<?php
    require("config.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Register</title>
        <link rel="stylesheet" href="css/style_lr.css">
    </head>
    <body>
        <a href="index.php" id="button">Login</a>
<!-- =============================================================================== -->
        <div class="login">
            <div id="title">
                <h3>Register</h3>
            </div>
            <div id="data">
                <form method="POST">
                    <b>NIM</b><br><input type="text" name="nim" pattern="\d*" maxlength="10" required><br><br>
                    <b>Nama</b><br><input type="text" name="nama" maxlength="35" required><br><br>
                    <b>Username</b><br><input type="text" name="username" required><br><br>
                    <b>Password</b><br><input type="password" name="password" required><br><br>
                    <b>Confirm Password</b><br><input type="password" name="confirm_password" required><br><br>
                    <input type="submit" value="Register"> <input type="reset" value="Reset">
                </form>
            </div>
        </div>
<!-- =============================================================================== -->
    </body>
</html>
<?php
    if (isset($_POST['nim'])) {
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password == $confirm_password) {
            $check_mahasiswa = $pdo -> prepare("SELECT nim FROM tb_mahasiswa WHERE nim = '$nim'");
            $check_mahasiswa -> execute();
            $row_mahasiswa = $check_mahasiswa -> rowcount();

            $check_akun = $pdo -> prepare("SELECT username FROM tb_account WHERE username = '$username'");
            $check_akun -> execute();
            $row_akun = $check_akun -> rowcount();

            if ($row_akun == 0 && $row_mahasiswa == 0){
                $query = $pdo -> prepare("INSERT INTO tb_account(username, password) VALUES ('$username','$password')");
                $query -> execute();

                $query_id = $pdo -> prepare("SELECT id_user FROM tb_account WHERE username = '$username' AND password = '$password'");
                $query_id -> execute();
                $data = $query_id -> fetch(PDO::FETCH_ASSOC);
                $id_user = $data['id_user'];

                $query_mahasiswa = $pdo -> prepare("INSERT INTO tb_mahasiswa(nim, nama, id_user) VALUES ('$nim','$nama','$id_user')");
                $query_mahasiswa -> execute();

                if ($query && $query_mahasiswa) {
                    ?>
                    <script type="text/javascript">
                        alert("Akun telah terbuat..");
                        location = "index.php";
                    </script>
                    <?php
                }
                else {
                    die("Gagal Register..");
                }
            } elseif($row_akun != 0) {
                ?>
                <script type="text/javascript">
                    alert("Username sudah terpakai..!!");
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    alert("NIM sudah terpakai..!!");
                </script>
                <?php
            }
        } else {
            ?>
            <script type="text/javascript">
                alert("Confirm Password tidak sama..!!");
            </script>
            <?php
        }
    }
?>