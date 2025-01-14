<?php    
session_start();    
if (!isset($_SESSION['loggedin'])) {    
    header("Location: login.php");    
    exit();    
}    
    
include '../includes/db.php';    
    
if (isset($_GET['id'])) {    
    $criteria_id = $_GET['id'];    
    
    // Hapus nilai terkait dari alternative_values  
    $sql_delete_values = "DELETE FROM alternative_values WHERE criterion_id = '$criteria_id'";  
    if ($conn->query($sql_delete_values) === TRUE) {  
        // Jika penghapusan nilai berhasil, lanjutkan untuk menghapus kriteria  
        $sql_delete_criteria = "DELETE FROM criteria WHERE id = '$criteria_id'";    
        if ($conn->query($sql_delete_criteria) === TRUE) {    
            $success = "Criteria and related values deleted successfully.";    
        } else {    
            $error = "Error deleting criteria: " . $conn->error;    
        }    
    } else {  
        $error = "Error deleting related values: " . $conn->error;    
    }    
}    
    
header("Location: criteria.php");    
exit();    
?>    
