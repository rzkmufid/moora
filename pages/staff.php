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
            Staff List Table
        </h6>
        <button onclick="location.href='add_staff.php'" class="btn btn-primary">Add Staff</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table
                class="table table-bordered"
                id="dataTable"
                width="100%"
                cellspacing="0"
            >
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_staff = "SELECT * FROM users WHERE role = 'staff'";
                    $result_staff = $conn->query($sql_staff);
                    if ($result_staff->num_rows > 0) {
                        $no = 1;
                        while ($row = $result_staff->fetch_assoc()) {
                            echo "<tr> 
                                    <td>{$no}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['name']}</td>
                                    <td>
                                        <a href='edit_staff.php?id={$row['id']}' class='btn btn-primary'><i class='fas fa-edit'></i> Edit</a>
                                        <button type='button' class='btn btn-secondary' data-toggle='modal' data-target='#deleteModal{$row['id']}'><i class='fas fa-trash'></i> Delete</button>
                                    </td>
                                </tr>";
                            $no++;

                            echo "<div class='modal fade' id='deleteModal{$row['id']}' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel{$row['id']}' aria-hidden='true'>
                                    <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='deleteModalLabel{$row['id']}'>Delete Staff</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                Are you sure you want to delete this staff?
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                                                <a href='delete_staff.php?id={$row['id']}' class='btn btn-primary'>Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No staff available</td></tr>";
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

