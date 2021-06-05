<?php
require_once "koneksi.php";
 
$nama_produk = $keterangan = $harga = $jumlah = "";
$nama_produk_err = $keterangan_err = $harga_err = $jumlah_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_nama_produk = trim($_POST["nama_produk"]);
    if(empty($input_nama_produk)){
        $nama_produk_err = "Masukan nama produk.";
    } elseif(!filter_var($input_nama_produk, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nama_produk_err = "Masukan nama produk yang valid.";
    } else{
        $nama_produk = $input_nama_produk;
    }
    
    $input_keterangan = trim($_POST["keterangan"]);
    if(empty($input_keterangan)){
        $keterangan_err = "Please enter an keterangan.";     
    } else{
        $keterangan = $input_keterangan;
    }
    
    $input_harga = trim($_POST["harga"]);
    if(empty($input_harga)){
        $harga_err = "Please enter the harga amount.";     
    } elseif(!ctype_digit($input_harga)){
        $harga_err = "Please enter a positive integer value.";
    } else{
        $harga = $input_harga;
    }
    $input_jumlah = trim($_POST["jumlah"]);
    if(empty($input_jumlah)){
        $jumlah_err = "Please enter the harga amount.";     
    } elseif(!ctype_digit($input_jumlah)){
        $jumlah_err = "Please enter a positive integer value.";
    } else{
        $jumlah = $input_jumlah;
    }
    
    if(empty($nama_produk_err) && empty($keterangan_err) && empty($harga_err) && empty($jumlah_err)){
        $sql = "INSERT INTO produk (nama_produk, keterangan, harga, jumlah) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "ssii", $param_nama_produk, $param_keterangan, $param_harga, $param_jumlah);
            
            $param_nama_produk = $nama_produk;
            $param_keterangan = $keterangan;
            $param_harga = $harga;
            $param_jumlah = $jumlah;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($con);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
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
                    <h2 class="mt-2 mb-3" align="center">Tambah Data Produk</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control <?php echo (!empty($nama_produk_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nama_produk; ?>">
                            <span class="invalid-feedback"><?php echo $nama_produk_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control <?php echo (!empty($keterangan_err)) ? 'is-invalid' : ''; ?>"><?php echo $keterangan; ?></textarea>
                            <span class="invalid-feedback"><?php echo $keterangan_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" name="harga" class="form-control <?php echo (!empty($harga_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $harga; ?>">
                            <span class="invalid-feedback"><?php echo $harga_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="text" name="jumlah" class="form-control <?php echo (!empty($jumlah_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jumlah; ?>">
                            <span class="invalid-feedback"><?php echo $jumlah_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>