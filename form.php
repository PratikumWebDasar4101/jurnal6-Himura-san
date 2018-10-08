<?php
    require("config.php");
    session_start();

    if (!$_SESSION['sukses'])
        header("Location: index.php");
        
    @$id_user = $_SESSION['id_user'];
    $query = $pdo -> prepare("SELECT * FROM tb_mahasiswa WHERE id_user = '$id_user'");
    $query -> execute();
    $data = $query -> fetch(PDO::FETCH_ASSOC);
    $hobi_terpilih = explode(", ", $data['hobi']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit Data</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <a href="index.php?exit=logout" id="button_logout">Logout</a>
<!-- =============================================================================== -->
        <div class="form">
            <div id="title">
                <h3>Input Data</h3>
            </div>
            <div id="data">
                <form method="POST">
                    <b>NIM</b><br><input type="text" name="nim" pattern="\d*" maxlength="10" value="<?php echo $data['nim']; ?>" required><br><br>
                    
                    <b>Nama</b><br><input type="text" name="nama" maxlength="35" value="<?php echo $data['nama']; ?>" required><br><br>

                    <b>Kelas</b> <br>
                    <input type="radio" name="kelas" value="D3MI-41-01" <?php if($data['kelas'] == "D3MI-41-01") { ?> checked <?php } ?> required> D3MI-41-01
                    <input type="radio" name="kelas" value="D3MI-41-02" <?php if($data['kelas'] == "D3MI-41-02") { ?> checked <?php } ?> required> D3MI-41-02
                    <input type="radio" name="kelas" value="D3MI-41-03" <?php if($data['kelas'] == "D3MI-41-03") { ?> checked <?php } ?> required> D3MI-41-03
                    <input type="radio" name="kelas" value="D3MI-41-04" <?php if($data['kelas'] == "D3MI-41-04") { ?> checked <?php } ?> required> D3MI-41-04 <br><br>
                    
                    <b>Jenis Kelamin : </b>
                    <input type="radio" name="jk" value="Laki-laki" <?php if($data['jenis_kelamin'] == "Laki-laki") { ?> checked <?php } ?> required> Laki-Laki
                    <input type="radio" name="jk" value="Perempuan" <?php if($data['jenis_kelamin'] == "Perempuan") { ?> checked <?php } ?> required> Perempuan <br><br>

                    <b>Hobi</b> <br>
                    <input type="checkbox" name="hobi[]" value="Makan"> Makan
                    <input type="checkbox" name="hobi[]" value="Minum"> Minum
                    <input type="checkbox" name="hobi[]" value="Main"> Main
                    <input type="checkbox" name="hobi[]" value="Tidur"> Tidur <br><br>
                    
                    <b>Fakultas</b><br>
                    <select name="fakultas" id="dropdown" required>
                        <option value="FTE" <?php if($data['fakultas'] == "FTE") { ?> selected <?php } ?>>FTE</option>
                        <option value="FRI" <?php if($data['fakultas'] == "FRI") { ?> selected <?php } ?>>FRI</option>
                        <option value="FIF" <?php if($data['fakultas'] == "FIF") { ?> selected <?php } ?>>FIF</option>
                        <option value="FEB" <?php if($data['fakultas'] == "FEB") { ?> selected <?php } ?>>FEB</option>
                        <option value="FKB" <?php if($data['fakultas'] == "FKB") { ?> selected <?php } ?>>FKB</option>
                        <option value="FIK" <?php if($data['fakultas'] == "FIK") { ?> selected <?php } ?>>FIK</option>
                        <option value="FIT" <?php if($data['fakultas'] == "FIT") { ?> selected <?php } ?>>FIT</option>
                    </select>
                    <br><br>

                    <b>Alamat</b><br><textarea name="alamat" required><?php echo $data['alamat']; ?></textarea><br><br>
                    
                    <input type="submit" value="Simpan"> <input type="reset" value="Reset">
                </form>
            </div>
        </div>
<!-- =============================================================================== -->
    </body>
</html>
<?php
    if (isset($_POST['nim'])) {
        $nim = $_POST['nim'];
        $nama = addslashes($_POST['nama']);
        $kelas = $_POST['kelas'];
        $fakultas = $_POST['fakultas'];
        $jk = $_POST['jk'];
        $hobi = $_POST['hobi'];
        $alamat = $_POST['alamat'];

        $list_hobi = implode(", ", $hobi);
        
        $query = $pdo -> prepare("UPDATE tb_mahasiswa SET nim = '$nim', nama = '$nama', kelas = '$kelas', fakultas = '$fakultas', jenis_kelamin = '$jk', hobi = '$list_hobi', alamat = '$alamat' WHERE id_user = '$id_user'");
        $query -> execute();

        if ($query) {
            ?>
            <script type="text/javascript">
                alert("Data telah terubah..!");
                location = "form.php";
            </script>
            <?php
        }else {
            ?>
            <script type="text/javascript">
                alert("Data gagal terubah..!");
            </script>
            <?php
        }
    }
?>