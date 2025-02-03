<?php
session_start();
include '../includes/db.php';

$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];

    // Query untuk memeriksa apakah username ada di tabel users
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Mengupdate kata sandi baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashed_password, $username);
        $stmt->execute();

        $message = "Kata sandi berhasil direset.";
    } else {
        $error = "Tidak ada akun yang ditemukan dengan username tersebut.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Reset Kata Sandi</title>

    <!-- Font kustom untuk template ini-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Gaya kustom untuk template ini-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .card-login {
            background-color: #964B00;
            /* Brown color for the card */
            color: #ffffff;
            /* White text color for contrast */
        }

        .bg-login-image {
            background-image: url('../img/login.png');
            background-size: contain;
            /* Adjust size to contain the image */
            background-position: center center;
            background-repeat: no-repeat;
            background-clip: border-box;
        }

        .btn-primary {
            background-color: #0056b3;
            /* Darker blue for buttons */
            border-color: #0056b3;
        }

        .btn-primary:hover {
            background-color: #004494;
            border-color: #004494;
        }

        body {
            background-color: #f4f4f9;
            /* Light grey for the body */
        }

        .btn-coklat {
            background-color: #964B00;
            color: #ffffff;
        }

        .roundeder {
            border-radius: 28px;
        }

        .roundeder-lg {
            border-radius: 32px;
        }

        .text-coklat {
            color: #964B00;
        }

        .text-coklat:hover {
            color: rgb(94, 47, 1);
            text-decoration: none;
        }
    </style>
</head>

<body class="bg-white">
    <div class="container">
        <!-- Baris luar -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden roundeder border-0 shadow-lg my-5 card-login">
                    <div class="card-body  p-5">
                        <div class="row roundeder-lg ">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6 roundeder">
                                <div class="p-5 bg-white roundeder ">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Reset Kata Sandi</h1>
                                        <?php if (!empty($error)): ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?= $error ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($message)): ?>
                                            <div class="alert alert-success" role="alert">
                                                <?= $message ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <form class="user" action="forgot_password.php" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Masukkan Username..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="new_password" name="new_password" placeholder="Kata Sandi Baru" required>
                                        </div>
                                        <button type="submit" class="btn btn-coklat btn-user btn-block">
                                            Reset Kata Sandi
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small text-coklat" href="login.php">Sudah punya akun? Masuk!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- JavaScript inti Bootstrap-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>