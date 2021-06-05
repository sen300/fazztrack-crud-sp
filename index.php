<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fazztrack CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 100%;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
                    <div class="mt-4 mb-2">
                        <h1 align="center">Fazztrack CRUD</h1>
                        <h3 align="center">Seno Priyambodo</h3>
                        <a href="tambah_produk.php" class="btn btn-success text-center" ><i class="fa fa-plus"></i> Tambah Produk</a>
                    </div>
                    <?php
                    require_once "koneksi.php";
                    
                    $sql = "SELECT * FROM produk";
                    if($result = mysqli_query($con, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>No.</th>";
                                        echo "<th>Nama Produk</th>";
                                        echo "<th>Keterangan</th>";
                                        echo "<th>Harga</th>";
                                        echo "<th>Jumlah</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['nama_produk'] . "</td>";
                                        echo "<td>" . $row['keterangan'] . "</td>";
                                        echo "<td>" . $row['harga'] . "</td>";
                                        echo "<td>" . $row['jumlah'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="lihat_produk.php?id='. $row['id'] .'" class="mr-3" title="Lihat Detail" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="edit_produk.php?id='. $row['id'] .'" class="mr-3" title="Edit Produk" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="hapus_produk.php?id='. $row['id'] .'" title="Hapus Produk" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>Belum ada data yang dimasukan.</em></div>';
                        }
                    } else{
                        echo "Error, coba lagi nanti.";
                    }
                    mysqli_close($con);
                    ?>
        </div>
    </div>
</body>
</html>