<?php    
session_start();    
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'pimpinan') {    
    header("Location: login.php");    
    exit();    
}    
    
include '../includes/db.php';    
  
if (isset($_GET['id'])) {    
    $staff_id = $_GET['id'];    
  
    // Ambil data staff  
    $sql = "SELECT * FROM users WHERE id = ? AND role = 'staff'";  
    $stmt = $conn->prepare($sql);  
    $stmt->bind_param("i", $staff_id);  
    $stmt->execute();  
    $result = $stmt->get_result();  
  
    if ($result->num_rows > 0) {  
        $staff = $result->fetch_assoc();  
    } else {  
        header("Location: staff.php");  
        exit();  
    }  
}  
  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $username = $_POST['username'];    
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $staff['password']; // Hash password jika diubah  
    $name = $_POST['name']; // Tambahkan name disini
  
    // Update staff di database  
    $sql = "UPDATE users SET username = ?, password = ?, name = ? WHERE id = ?";  
    $stmt = $conn->prepare($sql);  
    $stmt->bind_param("sssi", $username, $password, $name, $staff_id);  
      
    if ($stmt->execute()) {  
        header("Location: staff.php");  
        exit();  
    } else {  
        $error = "Error: " . $stmt->error;  
    }  
}  
include '../includes/header.php';
?>    
  
<div class="container">
<h2>Edit Staff</h2>  
<form method="post">    
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" class="form-control" name="name" value="<?php echo $staff['name']; ?>" required>
    </div>
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" class="form-control" name="username" value="<?php echo $staff['username']; ?>" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" class="form-control" name="password"> <!-- Password optional -->
    </div>
    <button type="submit" class="btn btn-coklat">Update Staff</button> 
    <a href="staff.php" class="btn btn-secondary">Back to Users Page</a>   
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

