<?php      
session_start();      
if (!isset($_SESSION['loggedin'])) {      
    header("Location: login.php");      
    exit();      
}      
      
include '../includes/db.php';      
      
if (isset($_GET['id'])) {      
    $criteria_id = $_GET['id'];      
      
    // Mulai transaksi untuk memastikan semua operasi berhasil  
    $conn->begin_transaction();  
      
    try {  
        // Hapus nilai terkait dari alternative_values    
        $sql_delete_values = "DELETE FROM alternative_values WHERE criterion_id = '$criteria_id'";    
        if (!$conn->query($sql_delete_values)) {    
            throw new Exception("Error deleting related values: " . $conn->error);      
        }      
          
        // Hapus subcriteria terkait dengan kriteria ini  
        $sql_delete_subcriteria = "DELETE FROM subcriteria WHERE criterion_id = '$criteria_id'";    
        if (!$conn->query($sql_delete_subcriteria)) {    
            throw new Exception("Error deleting subcriteria: " . $conn->error);      
        }      
          
        // Hapus kriteria    
        $sql_delete_criteria = "DELETE FROM criteria WHERE id = '$criteria_id'";      
        if (!$conn->query($sql_delete_criteria)) {      
            throw new Exception("Error deleting criteria: " . $conn->error);      
        }      
          
        // Commit transaksi jika semua operasi berhasil  
        $conn->commit();  
        $success = "Criteria and related values deleted successfully.";  
    } catch (Exception $e) {  
        // Rollback transaksi jika ada kesalahan  
        $conn->rollback();  
        $error = $e->getMessage();  
    }  
} else {  
    $error = "Criteria ID not provided.";  
}  
  
header("Location: criteria.php?success=" . urlencode($success) . "&error=" . urlencode($error));      
exit();      
?>  
