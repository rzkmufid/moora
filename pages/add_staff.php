<?php    
session_start();    
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'pimpinan') {    
    header("Location: login.php");    
    exit();    
}    
    
include '../includes/db.php';    
  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $name = $_POST['name'];    
    $username = $_POST['username'];    
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password  
  
    // Insert staff ke database  
    $sql = "INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, 'staff')";  
    $stmt = $conn->prepare($sql);  
    $stmt->bind_param("sss", $name, $username, $password);  
      
    if ($stmt->execute()) {  
        header("Location: staff.php");  
        exit();  
    } else {  
        $error = "Error: " . $stmt->error;  
    }  
}  
include '../includes/header.php';
?>    
  
<div class="container mt-5">
    <h2 class="text-center">Add Staff</h2>
    <form method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
        <a type="submit" class="btn btn-secondary" href="staff.php">Back to Users Page</a>
    </form>
</div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>
  
<?php include '../includes/sidebar.php'; ?>  
