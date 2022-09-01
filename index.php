<?php
  session_start();
  if(isset($_SESSION['userweb']) && ($_SESSION['jenis']=="admin")){
    header("location: dashboard.php");
    exit();
  }
  require_once("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css?<?php echo time();?>">
    <title>Landing Page</title>
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"></script>
</head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form method="POST" class="sign-in-form">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Username" required="" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" required="" />
            </div>
            <input type="submit" name="submit" value="Login" class="btn solid" />
            <?php
                if(isset($_POST['submit'])) {
                  $username = trim($_POST['username']);
                  $password = trim($_POST['password']);
                  $qry = mysqli_query($koneksi,"SELECT * FROM profile WHERE username = '$username' AND password = '$password'");
                  $cek = mysqli_num_rows($qry);
                          if ($cek==1) {
                              $data = mysqli_fetch_assoc($qry);
                              if($data['jenis']=="admin"){
                                $_SESSION['userweb']=$username;
                                $_SESSION['jenis']=$data['jenis'];
                                header ("location: Dashboard.php");
                                exit;
                              }else{($data['jenis']=="user");
                                $_SESSION['userweb']=$username;
                                $_SESSION['jenis']=$data['jenis'];
                                header ("location: coba.php");
                                exit;
                              }
                          }
                          else{
                              echo "<center><font color= red>Maaf username atau password anda salah !</font></center>";
                          }
                }
              ?>
            <p class="social-text">Or Sign in with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
          <form method="" class="sign-up-form">
            <h2 class="title">Sign up</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" />
            </div>
            <input type="submit" class="btn" value="Sign up" />
            <p class="social-text">Or Sign up with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <img src="img/logomalang.png" height="75px">
            <h3>Kota Malang</h3>
            <p>
              Beautiful Malang – City Branding Kota Malang
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="img/malang.png" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
              laboriosam ad deleniti.
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="app.js"></script>
  </body>
</html>
