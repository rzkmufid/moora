<?php    
session_start();    
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'pimpinan') {    
    header("Location: login.php");    
    exit();    
}    
    
include '../includes/db.php';    
    
if (isset($_GET['id'])) {    
    $staff_id = $_GET['id'];    
  
    // Hapus staff dari database  
    $sql = "DELETE FROM users WHERE id = ? AND role = 'staff'";  
    $stmt = $conn->prepare($sql);  
    $stmt->bind_param("i", $staff_id);  
      
    if ($stmt->execute()) {  
        header("Location: staff.php");  
        exit();  
    } else {  
        $error = "Error: " . $stmt->error;  
    }  
}    
?>  
