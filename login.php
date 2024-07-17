<?php
session_start();
include('includes/header.php');
include('security.php');

// Cek jika pengguna sudah login, maka redirect ke halaman index
if (isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}


// Form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Query untuk memeriksa keberadaan pengguna
  $query = "SELECT * FROM register WHERE username='$username' AND password='$password'";
  $result = $connection->query($query);

  if ($result->num_rows == 1) {
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit;
  } else {
    // Jika tidak, tampilkan pesan error
    $error = "Username atau password salah.";
  }
}
?>

<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-6 col-md-6">
          <div class="card o-hidden border-0 shadow-lg my-5">
              <div class="card-body p-0">
                  <!-- Nested Row within Card Body -->
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="p-5">
                              <div class="text-center">
                                  <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                  <?php 
                                  if(isset($_SESSION['status']) && $_SESSION['status']!='')
                                  {
                                      echo '<h2 class="bg-danger text-white">' .$_SESSION['status']. '</h2>';
                                      unset($_SESSION['status']);
                                  }
                                   ?>
                              </div>
                              <form class="user" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                  <div class="form-group">
                                      <input type="text" name= "username" class="form-control form-control-user" placeholder="Enter Username">
                                  </div>
                                  <div class="form-group">
                                      <input type="password" name= "password" class="form-control form-control-user" placeholder="Password">
                                  </div>
                                  <div class="form-group">
                                      <div class="custom-control custom-checkbox small">
                                          <input type="checkbox" class="custom-control-input" id="customCheck">
                                          <label class="custom-control-label" for="customCheck">Remember Me</label>
                                      </div>
                                  </div>
                                  <button type="submit" name= "login_btn" class="btn btn-primary btn-user btn-block">
                                      Login
                                  </button>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
    
<?php 
include('includes/scripts.php');
?>