<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';
include '../includes/db.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Alternative List Table
        </h6>
        <button onclick="location.href='add_alternative.php'" class="btn btn-primary">Add Alternative</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table
                class="table table-bordered"
                id="dataTable"
                width="100%"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <?php
                        $sql_criteria = "SELECT * FROM criteria";
                        $result_criteria = $conn->query($sql_criteria);

                        if ($result_criteria->num_rows > 0) {
                            while ($row = $result_criteria->fetch_assoc()) {
                                echo "<th>{$row['name']}</th>";
                            }
                        }
                        ?>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_alternatives = "SELECT * FROM alternatives";
                    $result_alternatives = $conn->query($sql_alternatives);

                    $no = 1;
                    if ($result_alternatives->num_rows > 0) {
                        while ($row = $result_alternatives->fetch_assoc()) {
                            echo "<tr>  
                        <td>{$no}</td>  
                        <td>{$row['name']}</td>";

                            $sql_values = "SELECT * FROM alternative_values WHERE alternative_id = " . $row['id'];
                            $result_values = $conn->query($sql_values);

                            $values = [];
                            if ($result_values->num_rows > 0) {
                                while ($value_row = $result_values->fetch_assoc()) {
                                    $values[$value_row['criterion_id']] = $value_row['value'];
                                }
                            }

                            $sql_criteria = "SELECT * FROM criteria";
                            $result_criteria = $conn->query($sql_criteria);

                            if ($result_criteria->num_rows > 0) {
                                while ($criterion = $result_criteria->fetch_assoc()) {
                                    $value = isset($values[$criterion['id']]) ? $values[$criterion['id']] : '-';
                                    echo "<td>{$value}</td>";
                                }
                            }

                            echo "<td>  
                        <a href='edit_alternative.php?id={$row['id']}' class='btn btn-primary'> <i class='fas fa-edit'></i> Edit</a>  
                        <a href='delete_alternative.php?id={$row['id']}' class='btn btn-secondary'> <i class='fas fa-trash'></i> Delete</a>  
                      </td>  
                      </tr>";

                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='10'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include '../includes/sidebar.php'; ?>

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