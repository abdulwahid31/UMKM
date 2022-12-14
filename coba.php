<?php
    session_start();
    include "koneksi.php";
    if(!isset($_SESSION['userweb'])){
      header("location: index.php");
      exit();
    }
        
    if(isset($_GET['aksi'])){
      $aksi = $_GET['aksi'];
      if($aksi == "logout"){
        if(isset($_SESSION['userweb'])){
          unset($_SESSION['userweb']);
          unset($_SESSION['jenis']);
          session_unset();
          session_destroy();
          $_SESSION = array ();
        }
        header("location: index.php");
        exit();
      }
    }


    $username=$_SESSION['userweb'];
    $qry = mysqli_query($koneksi, "SELECT * FROM profile WHERE username='$username'");
    $result = $qry;

    $qry = mysqli_query($koneksi, "SELECT * FROM kegiatan");
    ($data1 = mysqli_num_rows($qry));

    $qry2 = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE status='Dalam Proses'");
    ($data2 = mysqli_num_rows($qry2));

    $qry3 = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE status='Ditunda'");
    ($data3 = mysqli_num_rows($qry3));

    $qry4 = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE status='Selesai'");
    ($data4 = mysqli_num_rows($qry4));

    function tgl_indo($tanggal2){
      $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      );
      $pecahkan = explode('-', $tanggal2);
      
      // variabel pecahkan 0 = tanggal
      // variabel pecahkan 1 = bulan
      // variabel pecahkan 2 = tahun
    
      return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

?>

<?php
if(mysqli_num_rows($result)>0){
  $data_user = mysqli_fetch_array($result);
  $_SESSION["nama"]=$data_user["username"];
  $_SESSION["nomor"]=$data_user["nomor"];
  $_SESSION["alamat"]=$data_user["alamat"];
  $_SESSION["email"]=$data_user["email"];
  $_SESSION["password"]=$data_user["password"];
  $_SESSION["foto"]=$data_user["foto"];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css?<?php echo time();?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  </head>
  <body>
    <div class="sidebar">
      <ul class="nav">
        <li id="dashboard">
          <a class="active" href="dashboard.php">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li id="kegiatan">
          <a href="kegiatan.php">
            <i class="bi bi-briefcase"></i>
            <span>Kegiatan</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bi bi-image"></i>
            <span>Dokumentasi</span>
          </a>
        </li>
        <li>
          <a href="laporan.php">
            <i class="bi bi-journal-text"></i>
            <span>Laporan</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="wrapper">
      <div class="navbar">
            <div class="left">
              <img class="logo" src="images/iconnav.svg"/>
            </div>
            <div class="right">
                <ul>
                  <li>
                    <a href="#"> 
                      <p><?php echo $_SESSION['userweb'] ;?></p>
                      <img src="foto/<?php echo $_SESSION["foto"];?>" id="usericon">
                      <i class="bi bi-caret-down-fill" id="dropicon"></i>
                    </a>
                    <div class="dropdown">
                        <ul>
                          <li id="profilebox">
                            <a href="profile.php">
                              <i class="bi bi-person"></i>
                              <span id="textprofile">Profile</span>
                            </a>
                          </li>
                          <li>
                            <a href="dashboard.php?aksi=logout">
                              <i class="bi bi-box-arrow-right"></i>
                              <span id="textsignout">Sign Out</span>
                            </a>
                          </li>
                      </ul>
                    </div> 
                  </li>
              </ul>
            </div>
        </div>
      </div>
    </div>
    <div class="main">
      <h1>DASHBOARD</h1>
      <div class="list">
        <h2>Status Kegiatan</h2>
        <button type="button" id="listbutton">List</button>
        <button type="button" id="kalenderbutton">Kalender</button>
        <div class="card">
          <div class="total">
            <div class="atas">
              <label>Total Kegiatan</label><br>
              <i class="bi bi-circle-fill"></i>
            </div>
            <h3>
              <?php echo $data1;?> Kegiatan
            </h3>
          </div>
          <div class="proses">
            <div class="atas">
              <label>Dalam Proses</label>
              <i class="bi bi-circle-fill"></i>
            </div>
            <h3>
              <?php echo $data2;?> Kegiatan
            </h3>
          </div>
          <div class="ditunda">
            <div class="atas">
              <label>Ditunda</label>
              <i class="bi bi-circle-fill"></i>
            </div>
            <h3>
            <?php echo $data3;?> Kegiatan
            </h3>
          </div>
          <div class="selesai">
            <div class="atas">
                <label>Selesai</label>
                <i class="bi bi-circle-fill"></i>
            </div>
            <h3>
            <?php echo $data4;?> Kegiatan
            </h3>
          </div>
        </div>
        <h2>Kegiatan Terdekat</h2>
        <div class='listbawah'>
          <table>
            <a href=overviewkegiatan.php?kegiatan=$data7[no]>
            <tr>
            <?php 
            $qry7 = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE tanggalmulai>=now() ORDER BY tanggalmulai ASC LIMIT 7");
            while ($data7= mysqli_fetch_array($qry7)){
              $tanggal1=$data7["tanggalmulai"];
              $tanggalawal= date('d F Y', strtotime($tanggal1));
              $tanggal3= tgl_indo ($tanggal1);
              $text="Hari Lagi !";
              $future=$data7['tanggalmulai'];
              $d= new DateTime($future);
              $hitung= $d->diff(new DateTime())->format('%R%a');
              $rumus=($hitung*(-2))-(-$hitung);
              if($hitung>=0){
                $hitung=$data7['status'];
              }
                else{
                  $hitung=  "$rumus  $text";
              }
              echo "
              
              <td>
                <a href=overviewkegiatan.php?kegiatan=$data7[no]>
                <div class='terdekat'>
                
                  <div class='card1'>
                     <div class='carddalam'>
                        <div class='atas'>
                          <div class='hari'>
                            $hitung
                          </div>
                            <div class='tanggal'>
                              $tanggal3
                            </div>
                        </div>
                        <div class='isi'>
                          <label>$data7[nama]</label>
                          <a href=overviewkegiatan.php?kegiatan=$data7[no]><i class='bi bi-three-dots'></i></a>
                          <button>ikuti</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
                </div>
              
              </td>
              
              ";
            }
            ?>
            </tr>
          </table>
          
        </div>
      </div>
    </div>
    <script>
    document.querySelector(".right ul li").addEventListener("click", function(){
    this.classList.toggle("active");
    });
</script> 
<?php
?>

  </body>
</html>
?>