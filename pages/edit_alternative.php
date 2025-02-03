<?php    
session_start();    
if (!isset($_SESSION['loggedin'])) {    
    header("Location: login.php");    
    exit();    
}    
    
include '../includes/db.php';    

if (isset($_GET['id'])) {    
    $alternative_id = $_GET['id'];    
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
        $name = $_POST['name'];    
        $values = $_POST['values'];    
        
        $sql = "UPDATE alternatives SET name = '$name' WHERE id = '$alternative_id'";    
        if ($conn->query($sql) === TRUE) {    
            $sql_delete_values = "DELETE FROM alternative_values WHERE alternative_id = '$alternative_id'";    
            $conn->query($sql_delete_values);    
            
            foreach ($values as $criterion_id => $value) {    
                $sql_value = "INSERT INTO alternative_values (alternative_id, criterion_id, value) VALUES ('$alternative_id', '$criterion_id', '$value')";    
                $conn->query($sql_value);    
            }    
            
            header("Location: alternatives.php");    
            exit();    
        } else {    
            $error = "Error: " . $sql . "<br>" . $conn->error;    
        }    
    }    
    
    $sql_alternative = "SELECT * FROM alternatives WHERE id = '$alternative_id'";    
    $result_alternative = $conn->query($sql_alternative);    
    
    if ($result_alternative->num_rows > 0) {    
        $alternative = $result_alternative->fetch_assoc();    
    } else {    
        header("Location: alternatives.php");    
        exit();    
    }    
    
    $sql_values = "SELECT * FROM alternative_values WHERE alternative_id = '$alternative_id'";    
    $result_values = $conn->query($sql_values);    
    
    $values = [];    
    if ($result_values->num_rows > 0) {    
        while ($value_row = $result_values->fetch_assoc()) {    
            $values[$value_row['criterion_id']] = $value_row['value'];    
        }    
    }    
    
    $sql_criteria = "SELECT * FROM criteria";    
    $result_criteria = $conn->query($sql_criteria);    
} else {    
    header("Location: alternatives.php");    
    exit();    
}    
include '../includes/header.php';    
?>    
    
<div class="container">  
    <h2>Edit Alternative</h2>    
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>    
    <form method="post">    
        <div class="form-group">    
            <label for="name">Name:</label>    
            <input type="text" id="name" name="name" value="<?php echo $alternative['name']; ?>" class="form-control" required>    
        </div>    
    
        <?php    
        if ($result_criteria->num_rows > 0) {    
            while ($row = $result_criteria->fetch_assoc()) {    
                // Ambil subkriteria untuk setiap kriteria  
                $criterion_id = $row['id'];  
                $subcriteria_sql = "SELECT * FROM subcriteria WHERE criterion_id = $criterion_id";  
                $subcriteria_result = $conn->query($subcriteria_sql);  
                  
                echo "<div class='form-group'>    
                        <label for='value_{$criterion_id}'>{$row['name']}:</label>    
                        <select class='form-control' id='value_{$criterion_id}' name='values[{$criterion_id}]' required>
                        <option value=''>-- Pilih {$row['name']} --</option>
                        ";  
                  
                // Tambahkan opsi untuk setiap subkriteria  
                if ($subcriteria_result->num_rows > 0) {  
                    while ($subrow = $subcriteria_result->fetch_assoc()) {  
                        $selected = (isset($values[$criterion_id]) && $values[$criterion_id] == $subrow['score']) ? 'selected' : '';  
                        echo "<option value='{$subrow['score']}' $selected>{$subrow['subkriteria']} (Score: {$subrow['score']})</option>";  
                    }  
                } else {  
                    echo "<option value=''>No subcriteria available</option>";  
                }  
                  
                echo "      </select>    
                      </div>";    
            }    
        }    
        ?>    
    
        <button type="submit" class="btn btn-coklat">Update Alternative</button>    
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
