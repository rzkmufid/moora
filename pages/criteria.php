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
            Criteria List Table
        </h6>
        <button onclick="location.href='add_criteria.php'" class="btn btn-primary">Add Criteria</button>
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
                        <th>Code</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Weight</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM criteria";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>  
                        <td>{$no}</td>  
                        <td>{$row['code']}</td>  
                        <td>{$row['name']}</td>  
                        <td>{$row['type']}</td>  
                        <td>{$row['weight']}</td>  
                        <td>  
                            <a href='edit_criteria.php?id={$row['id']}' class='btn btn-primary'><i class='fas fa-edit'></i> Edit</a>  
                            <a href='delete_criteria.php?id={$row['id']}' class='btn btn-secondary'> <i class='fas fa-trash'></i> Delete</a>  
                        </td>  
                      </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='6'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- <button onclick="location.href='dashboard.php'" class="back-button">Back to Dashboard</button>   -->

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