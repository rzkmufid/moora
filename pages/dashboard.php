<?php    
session_start();    
if (!isset($_SESSION['loggedin'])) {    
    header("Location: login.php");    
    exit();    
}    
    
include '../includes/db.php';    
  
// Ambil data untuk grafik  
$sql_data = "SELECT COUNT(*) as total_staff FROM users WHERE role = 'staff'";  
$result_data = $conn->query($sql_data);  
$total_staff = $result_data->fetch_assoc()['total_staff'];  
  
// Ambil data untuk grafik lainnya, misalnya jumlah kriteria  
$sql_criteria = "SELECT COUNT(*) as total_criteria FROM criteria";  
$result_criteria = $conn->query($sql_criteria);  
$total_criteria = $result_criteria->fetch_assoc()['total_criteria'];  

// Ambil data untuk grafik lainnya, misalnya jumlah alternative
$sql_alternatives = "SELECT COUNT(*) as total_alternatives FROM alternatives";
$result_alternatives = $conn->query($sql_alternatives);
$total_alternatives = $result_alternatives->fetch_assoc()['total_alternatives'];
  
// Ambil data untuk grafik bulanan (contoh)  
$sql_monthly_data = "SELECT MONTH(created_at) as month, COUNT(*) as count FROM users WHERE role = 'staff' GROUP BY MONTH(created_at)";  
$result_monthly_data = $conn->query($sql_monthly_data);  
  
$monthly_counts = [];  
while ($row = $result_monthly_data->fetch_assoc()) {  
    $monthly_counts[$row['month']] = $row['count'];  
}  
  
// Siapkan data untuk chart  
$months = range(1, 12);  
$staff_counts = [];  
foreach ($months as $month) {  
    $staff_counts[] = isset($monthly_counts[$month]) ? $monthly_counts[$month] : 0;  
}  
include '../includes/header.php';
?>   
<style>
    .text-coklat{
        color: #964B00;
    }
</style>
    <div class="container-fluid">  
        <h1 class="mt-4">Dashboard</h1>  
        <div class="row">  
            <div class="col-xl-4 col-md-6 mb-4">  
                <div class="card border-left-danger shadow h-100 py-2">  
                    <div class="card-body">  
                        <div class="row no-gutters align-items-center">  
                            <div class="col mr-2">  
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Staff</div>  
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_staff; ?></div>  
                            </div>  
                            <div class="col-auto">  
                                <i class="fas fa-users fa-2x text-gray-300"></i>  
                            </div>  
                        </div>  
                    </div>  
                </div>  
            </div>  
            <div class="col-xl-4 col-md-6 mb-4">  
                <div class="card border-left-success shadow h-100 py-2">  
                    <div class="card-body">  
                        <div class="row no-gutters align-items-center">  
                            <div class="col mr-2">  
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Criteria</div>  
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_criteria; ?></div>  
                            </div>  
                            <div class="col-auto">  
                                <i class="fas fa-list fa-2x text-gray-300"></i>  
                            </div>  
                        </div>  
                    </div>  
                </div>  
            </div>  
            <div class="col-xl-4 col-md-6 mb-4">  
                <div class="card border-left-warning shadow h-100 py-2">  
                    <div class="card-body">  
                        <div class="row no-gutters align-items-center">  
                            <div class="col mr-2">  
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Alternatives</div>  
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_alternatives; ?></div>  
                            </div>  
                            <div class="col-auto">  
                                <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>  
                            </div>  
                        </div>  
                    </div>  
                </div>  
            </div>  
        </div>  
  
        <div class="row">  
            <div class="col-lg-12">  
                <div class="card shadow mb-4">  
                    <div class="card-header py-3">  
                        <h6 class="m-0 font-weight-bold text-primary">Staff Registration Over Months</h6>  
                    </div>  
                    <div class="card-body">  
                        <canvas id="staffChart"></canvas>  
                    </div>  
                </div>  
            </div>  
        </div>  
    </div>  
  
    <script>  
        var ctx = document.getElementById('staffChart').getContext('2d');  
        var staffChart = new Chart(ctx, {  
            type: 'line', // Jenis chart  
            data: {  
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],  
                datasets: [{  
                    label: 'Staff Registered',  
                    data: <?php echo json_encode($staff_counts); ?>,  
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',  
                    borderColor: 'rgba(75, 192, 192, 1)',  
                    borderWidth: 1  
                }]  
            },  
            options: {  
                scales: {  
                    y: {  
                        beginAtZero: true  
                    }  
                }  
            }  
        });  
    </script>  

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
