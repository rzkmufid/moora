<?php  
session_start();  
if (!isset($_SESSION['loggedin'])) {  
    header("Location: login.php");  
    exit();  
}  
  
include '../includes/db.php';  

if (isset($_GET['id'])) {  
    $criteria_id = $_GET['id'];  
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
        $name = $_POST['name'];  
        $code = $_POST['code'];  
        $type = $_POST['type'];  
        $weight = $_POST['weight'];  
        
        $sql = "UPDATE criteria SET code = '$code', name = '$name', type = '$type', weight = '$weight' WHERE id = '$criteria_id'";  
        if ($conn->query($sql) === TRUE) {  
            $success = "Criteria updated successfully.";  
        } else {  
            $error = "Error: " . $sql . "<br>" . $conn->error;  
        }  
    }  
    
    // Fetch criteria data  
    $sql_criteria = "SELECT * FROM criteria WHERE id = '$criteria_id'";  
    $result_criteria = $conn->query($sql_criteria);  
    
    if ($result_criteria->num_rows > 0) {  
        $criteria = $result_criteria->fetch_assoc();  
    } else {  
        header("Location: criteria.php");  
        exit();  
    }  
} else {  
    header("Location: criteria.php");  
    exit();  
}  
include '../includes/header.php';  
?>  
  
  <div class="container mt-5">
    <h2>Edit Criteria</h2>
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="post">
        <div class="mb-3">
            <label for="code" class="form-label">Code:</label>
            <input type="text" class="form-control" id="code" name="code" value="<?php echo $criteria['code']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $criteria['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type:</label>
            <select class="form-select form-control" id="type" name="type" required>
                <option value="Benefit" <?php if ($criteria['type'] == 'Benefit') echo 'selected'; ?>>Benefit</option>
                <option value="Cost" <?php if ($criteria['type'] == 'Cost') echo 'selected'; ?>>Cost</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="weight" class="form-label">Weight:</label>
            <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="<?php echo $criteria['weight']; ?>" required>
        </div>
        <div>
            <button type="submit" class="btn btn-coklat">Update Criteria</button>
            <a href='criteria.php' class="btn btn-secondary">Back to Criteria</a>
        </div>
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
