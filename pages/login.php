<?php    
session_start();    
include '../includes/db.php';    
    
if (isset($_GET['logout'])) {    
    session_destroy();    
    header("Location: login.php");    
    exit();    
}    
    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $username = $_POST['username'];    
    $password = $_POST['password'];    
  
    // Query untuk mengambil data pengguna dari database  
    $sql = "SELECT * FROM users WHERE username = ?";   
    $stmt = $conn->prepare($sql);  
    $stmt->bind_param("s", $username);  
    $stmt->execute();  
    $result = $stmt->get_result();  
  
    if ($result->num_rows > 0) {  
        $user = $result->fetch_assoc();  
          
        // Verifikasi password  
        if (password_verify($password, $user['password'])) {  
            $_SESSION['loggedin'] = true;    
            $_SESSION['username'] = $username;   
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role']; // Simpan role di session  
            header("Location: dashboard.php");    
            exit();    
        } else {    
            $error = "Invalid username or password.";    
            echo $error;
        }    
    } else {    
        $error = "Invalid username or password.";    
        echo $error;
    }    
}    
?>    

  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .card-login {
            background-color: #964B00; /* Brown color for the card */
            color: #ffffff; /* White text color for contrast */
        }
        .bg-login-image {
            background-image: url('../img/login.png');
            background-size: contain; /* Adjust size to contain the image */
            background-position: center center;
            background-repeat: no-repeat;
            background-clip: border-box;
        }
        .btn-primary {
            background-color: #0056b3; /* Darker blue for buttons */
            border-color: #0056b3;
        }
        .btn-primary:hover {
            background-color: #004494;
            border-color: #004494;
        }
        body {
            background-color: #f4f4f9; /* Light grey for the body */
        }
        .btn-coklat{
            background-color: #964B00;
            color: #ffffff;
        }
        .roundeder{
            border-radius: 28px;
        }
        .roundeder-lg{
            border-radius: 32px;
        }
    </style>
</head>

<body class="bg-white">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5 card-login roundeder-lg">
                    <div class="card-body p-5">
                        <!-- Nested Row within Card Body -->
                        <div class="row roundeder-lg ">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6 roundeder">
                                <div class="p-5 bg-white roundeder ">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        <?php if (isset($error)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $error ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <form class="user" action="login.php" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="username" name="username" aria-describedby="username" placeholder="Enter Username..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                                        </div>
                                        <button type="submit" class="btn btn-coklat btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>

