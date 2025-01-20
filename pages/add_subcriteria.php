<?php  
session_start();  
if (!isset($_SESSION['loggedin'])) {  
    header("Location: login.php");  
    exit();  
}  
  
// include '../includes/header.php';  
include '../includes/db.php';  
  
// Tangani form submission  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $criterion_id = $_POST['criterion_id'] ?? null;  
    $subkriteria = $_POST['subkriteria'] ?? [];  
    $descriptions = $_POST['description'] ?? [];  
    $scores = $_POST['score'] ?? [];  
  
    if (!$criterion_id) {  
        die("Criterion ID is required.");  
    }  
  
    // Hapus subkriteria yang ada untuk kriteria ini sebelum menambahkan yang baru  
    $delete_sql = "DELETE FROM subcriteria WHERE criterion_id = ?";  
    $stmt = $conn->prepare($delete_sql);  
    if (!$stmt) {  
        die("Error preparing delete statement: " . $conn->error);  
    }  
    $stmt->bind_param("i", $criterion_id);  
    if (!$stmt->execute()) {  
        die("Error executing delete statement: " . $stmt->error);  
    }  
    $stmt->close();  
  
    // Tambahkan subkriteria baru  
    $insert_sql = "INSERT INTO subcriteria (criterion_id, subkriteria, description, score) VALUES (?, ?, ?, ?)";  
    $stmt = $conn->prepare($insert_sql);  
    if (!$stmt) {  
        die("Error preparing insert statement: " . $conn->error);  
    }  
  
    foreach ($subkriteria as $index => $subkriteria_value) {  
        $description = $descriptions[$index] ?? '';  
        $score = $scores[$index] ?? ($index + 1); // Default score  
        $stmt->bind_param("issi", $criterion_id, $subkriteria_value, $description, $score);  
        if (!$stmt->execute()) {  
            die("Error executing insert statement: " . $stmt->error);  
        }  
    }  
  
    $stmt->close();  
    $conn->close();  
  
    // Redirect kembali ke halaman criteria dengan pesan sukses  
    header("Location: criteria.php?success=Subcriteria added successfully.");  
    exit();  
}  
  
// Jika tidak ada POST request, redirect ke halaman criteria  
header("Location: criteria.php");  
exit();  
?>  
