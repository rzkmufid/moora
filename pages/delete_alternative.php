<?php  
session_start();  
if (!isset($_SESSION['loggedin'])) {  
    header("Location: login.php");  
    exit();  
}  
  
include '../includes/db.php';  
  
if (isset($_GET['id'])) {  
    $alternative_id = $_GET['id'];  
  
    // Delete alternative values  
    $sql_delete_values = "DELETE FROM alternative_values WHERE alternative_id = '$alternative_id'";  
    $conn->query($sql_delete_values);  
  
    // Delete alternative  
    $sql_delete_alternative = "DELETE FROM alternatives WHERE id = '$alternative_id'";  
    if ($conn->query($sql_delete_alternative) === TRUE) {  
        $success = "Alternative deleted successfully.";  
    } else {  
        $error = "Error: " . $sql . "<br>" . $conn->error;  
    }  
}  
  
header("Location: alternatives.php");  
exit();  
?>  
