<?php
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once "koneksi.php";
    
    $sql = "SELECT * FROM produk WHERE id = ?";
    
    if($stmt = mysqli_prepare($con, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        $param_id = trim($_GET["id"]);
        
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                $nama_produk = $row["nama_produk"];
                $keterangan = $row["keterangan"];
                $harga = $row["harga"];
                $jumlah = $row["jumlah"];
            } else{
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Terjadi kesalahan! Silahkan coba lagi.";
        }
    }
     
    mysqli_stmt_close($stmt);
    
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk - <?php echo $row["nama_produk"]; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: whitesmoke;
        }
        .wrapper{
            width: 600px;
            margin: 2% auto;
            padding: 3rem;
            background-color: white;
            border-radius: 1rem;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-1 mb-1" align="center">Detail Produk - <?php echo $row["nama_produk"]; ?></h1>
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <p><b><?php echo $row["nama_produk"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <p><b><?php echo $row["keterangan"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <p><b><?php echo $row["harga"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <p><b><?php echo $row["jumlah"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Kembali</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>