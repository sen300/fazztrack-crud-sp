<?php
require_once "koneksi.php";
 
$nama_produk = $keterangan = $harga = $jumlah = "";
$nama_produk_err = $keterangan_err = $harga_err = $jumlah_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];

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
    
    
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        $sql = "UPDATE produk SET nama_produk=?, keterangan=?, harga=?, jumlah=? WHERE id=?";
         
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "ssiii", $param_nama_produk, $param_keterangan, $param_harga, $param_jumlah, $param_id);
            
            $param_nama_produk = $nama_produk;
            $param_keterangan = $keterangan;
            $param_harga = $harga;
            $param_jumlah = $jumlah;
            $param_id = $id;
            
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
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM produk WHERE id = ?";
        if($stmt = mysqli_prepare($con, $sql)){            
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
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
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        mysqli_stmt_close($stmt);
        
        mysqli_close($con);
    } 
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk - <?php echo $row["nama_produk"]; ?></title>
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
                    <h2 class="mt-1 mb-1">Edit Produk</h2>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>