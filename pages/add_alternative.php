<?php    
session_start();    
if (!isset($_SESSION['loggedin'])) {    
    header("Location: login.php");    
    exit();    
}    
    
include '../includes/db.php';    

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $name = $_POST['name'];    
    $values = $_POST['values'];    
    
    $sql = "INSERT INTO alternatives (name) VALUES ('$name')";    
    if ($conn->query($sql) === TRUE) {    
        $alternative_id = $conn->insert_id;    
  
        foreach ($values as $criterion_id => $value) {    
            $sql_value = "INSERT INTO alternative_values (alternative_id, criterion_id, value) VALUES ('$alternative_id', '$criterion_id', '$value')";    
            $conn->query($sql_value);    
        }    
    }    
    
    header("Location: alternatives.php");    
    exit();    
}    

$sql_criteria = "SELECT * FROM criteria";    
$result_criteria = $conn->query($sql_criteria);    
include '../includes/header.php';
?>    
    
<div class="container mt-5">  
    <h2>Add Alternative</h2>    
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>    
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>    
    <form method="post">    
        <div class="mb-3">    
            <label for="name" class="form-label">Name:</label>    
            <input type="text" class="form-control" id="name" name="name" required>    
        </div>    
    
        <?php    
        if ($result_criteria->num_rows > 0) {    
            while ($row = $result_criteria->fetch_assoc()) {    
                // Ambil subkriteria untuk setiap kriteria  
                $criterion_id = $row['id'];  
                $subcriteria_sql = "SELECT * FROM subcriteria WHERE criterion_id = $criterion_id";  
                $subcriteria_result = $conn->query($subcriteria_sql);  
                  
                echo "<div class='mb-3'>    
                        <label for='value_{$criterion_id}' class='form-label'>{$row['name']}:</label>    
                        <select class='form-control' id='value_{$criterion_id}' name='values[{$criterion_id}]' required>
                        <option value=''>-- Pilih {$row['name']} --</option>
                        ";  
                  
                // Tambahkan opsi untuk setiap subkriteria  
                if ($subcriteria_result->num_rows > 0) {  
                    while ($subrow = $subcriteria_result->fetch_assoc()) {  
                        echo "<option value='{$subrow['score']}'>{$subrow['subkriteria']} (Score: {$subrow['score']})</option>";  
                    }  
                } else {  
                    echo "<option value=''>No subcriteria available</option>";  
                }  
                  
                echo "      </select>    
                      </div>";    
            }    
        }    
        ?>    
    
        <button type="submit" class="btn btn-primary">Add Alternative</button>    
        <a href="alternatives.php" class="btn btn-secondary">Back to Alternatives</a>    
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
