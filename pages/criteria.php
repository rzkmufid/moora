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
        <h6 class="m-0 font-weight-bold text-coklat">    
            Criteria List Table    
        </h6>    
        <button onclick="location.href='add_criteria.php'" class="btn btn-coklat">Add Criteria</button>    
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
                            // Cek apakah ada subkriteria untuk kriteria ini    
                            $criterion_id = $row['id'];    
                            $subcriteria_sql = "SELECT * FROM subcriteria WHERE criterion_id = $criterion_id ORDER BY id DESC";    
                            $subcriteria_result = $conn->query($subcriteria_sql);    
                            $subcriteria_count = $subcriteria_result->num_rows;    
    
                            // Tampilkan indikator jika kurang dari 5 subkriteria  
                            $indicator = ($subcriteria_count < 5) ? "<span class='text-danger'>&bull;</span>" : "";
    
                            echo "<tr>      
                                <td>{$no}</td>      
                                <td>{$row['code']}</td>      
                                <td>{$row['name']} $indicator</td>      
                                <td>{$row['type']}</td>      
                                <td>{$row['weight']}</td>      
                                <td>      
                                    <a href='edit_criteria.php?id={$row['id']}' class='btn btn-coklat'><i class='fas fa-edit'></i> Edit</a>      
                                    <button class='btn btn-secondary' data-toggle='modal' data-target='#deleteModal{$row['id']}'><i class='fas fa-trash'></i> Delete</button>      
                                    <button class='btn btn-info' data-toggle='modal' data-target='#subcriteriaModal{$row['id']}'><i class='fas fa-list'></i> Manage Subcriteria</button>    
                                </td>      
                            </tr>";    
    
                            // Modal untuk menghapus kriteria    
                            echo "<div class='modal fade' id='deleteModal{$row['id']}' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel' aria-hidden='true'>    
                                    <div class='modal-dialog' role='document'>    
                                        <div class='modal-content'>    
                                            <div class='modal-header'>    
                                                <h5 class='modal-title' id='deleteModalLabel'>Delete {$row['name']}?</h5>    
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>    
                                                    <span aria-hidden='true'>&times;</span>    
                                                </button>    
                                            </div>    
                                            <div class='modal-body'>    
                                                Are you sure you want to delete <b>{$row['name']}</b>? This action is irreversible.    
                                            </div>    
                                            <div class='modal-footer'>    
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>    
                                                <a href='delete_criteria.php?id={$row['id']}' class='btn btn-coklat'>Delete</a>    
                                            </div>    
                                        </div>    
                                    </div>    
                                </div>";    
    
                            // Modal untuk menambahkan subkriteria    
                            echo "<div class='modal fade' id='subcriteriaModal{$row['id']}' tabindex='-1' role='dialog' aria-labelledby='subcriteriaModalLabel' aria-hidden='true'>    
                                    <div class='modal-dialog' role='document'>    
                                        <div class='modal-content'>    
                                            <div class='modal-header'>    
                                                <h5 class='modal-title' id='subcriteriaModalLabel'>Manage Subcriteria for {$row['name']}</h5>    
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>    
                                                    <span aria-hidden='true'>&times;</span>    
                                                </button>    
                                            </div>    
                                            <div class='modal-body'>    
                                                <form method='post' action='add_subcriteria.php'>    
                                                    <input type='hidden' name='criterion_id' value='{$row['id']}'>";    
    
                            // Menampilkan form untuk 5 subkriteria    
                            for ($i = 1; $i <= 5; $i++) {    
                                $subrow = $subcriteria_result->fetch_assoc();    
                                $description = $subrow ? $subrow['description'] : '';    
                                $subkriteria = $subrow ? $subrow['subkriteria'] : '';    
                                $score = $subrow ? $subrow['score'] : $i; // Default score
    
                                echo "
                                <div class='card mb-3 p-3'>
                                <div class='mb-3'>    
                                <label for='subkriteria{$i}' class='form-label'>Subkriteria:</label>    
                                <input type='text' class='form-control' name='subkriteria[]' id='subkriteria{$i}' value='{$subkriteria}' required>    
                                </div>    
                                <div class='mb-3'>    
                                        <label for='description{$i}' class='form-label'>Description:</label>    
                                        <input type='text' class='form-control' name='description[]' id='description{$i}' value='{$description}' required>    
                                        </div>    
                                        <div class='mb-3'>    
                                        <label for='score{$i}' class='form-label'>Score:</label>    
                                        <input type='number' class='form-control' name='score[]' id='score{$i}' value='{$score}' disabled required>    
                                        </div>
                                        </div>";    
                            }    
    
                            echo "<button type='submit' class='btn btn-coklat'>Save Subcriteria</button>    
                                                </form>    
                                            </div>    
                                        </div>    
                                    </div>    
                                </div>";    
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
    
<?php include '../includes/sidebar.php'; ?>    
    
<!-- Bootstrap core JavaScript-->    
<script src="../vendor/jquery/jquery.min.js"></script>    
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>    
    
<!-- Core plugin JavaScript-->    
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>    

