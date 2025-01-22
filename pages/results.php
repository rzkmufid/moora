<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';
include '../includes/db.php';

// Kode perhitungan MOORA  
$criteria = [];
$weights = [];

$sql_criteria = "SELECT * FROM criteria";
$result_criteria = $conn->query($sql_criteria);

if ($result_criteria->num_rows > 0) {
    while ($row = $result_criteria->fetch_assoc()) {
        $criteria[] = $row;
        $weights[] = $row['weight'];
    }
}

$alternatives = [];

$sql_alternatives = "SELECT * FROM alternatives";
$result_alternatives = $conn->query($sql_alternatives);

if ($result_alternatives->num_rows > 0) {
    while ($row = $result_alternatives->fetch_assoc()) {
        $alternatives[$row['name']] = [];

        $sql_values = "SELECT * FROM alternative_values WHERE alternative_id = " . $row['id'];
        $result_values = $conn->query($sql_values);

        if ($result_values->num_rows > 0) {
            while ($value_row = $result_values->fetch_assoc()) {
                $alternatives[$row['name']][$value_row['criterion_id']] = (float)$value_row['value'];
            }
        }
    }
}

$dividers = [];

foreach ($criteria as $index => $criterion) {
    $sum_of_squares = 0;
    foreach ($alternatives as $alt_name => $values) {
        $value = isset($values[$criterion['id']]) ? $values[$criterion['id']] : 0;
        // $value = $values[$criterion['id']];  
        $sum_of_squares += pow($value, 2);
    }
    $result_value = sqrt($sum_of_squares);
    $dividers[$index] = $result_value;
}

$normalized_values = [];

foreach ($alternatives as $alt_name => $values) {
    foreach ($criteria as $index => $criterion) {
        $value = isset($values[$criterion['id']]) ? $values[$criterion['id']] : 0;
        $divider = isset($dividers[$index]) ? $dividers[$index] : 0;
        if ($divider == 0) {
            $result_multiplication = 0; // Set to 0 if divider is zero
        } else {
            $result_multiplication = $value / $divider;
        }
        $normalized_values[$alt_name][$criterion['id']] = $result_multiplication;
    }
}

$yi = [];
$max_values = [];
$min_values = [];
$results = [];

foreach ($alternatives as $alt_name => $values) {
    $y = 0;
    $result_row = [];
    $result_row['name'] = $alt_name;

    foreach ($criteria as $index => $criterion) {
        $weighted_value = $normalized_values[$alt_name][$criterion['id']] * $weights[$index];
        $y += $weighted_value;
        $result_row[$criterion['code']] = round($weighted_value, 4);

        if ($criterion['type'] == 'Benefit') {
            if (!isset($max_values[$alt_name])) {
                $max_values[$alt_name] = 0;
            }
            $max_values[$alt_name] += $weighted_value;
        } elseif ($criterion['type'] == 'Cost') {
            if (!isset($min_values[$alt_name])) {
                $min_values[$alt_name] = 0;
            }
            $min_values[$alt_name] += $weighted_value;
        }
    }

    $result_row['total'] = round($y, 4);
    $results[] = $result_row;
    $yi[$alt_name] = $y;
}

$ranking = [];

foreach ($yi as $name => $value) {
    $max_value = isset($max_values[$name]) ? $max_values[$name] : 0;
    $min_value = isset($min_values[$name]) ? $min_values[$name] : 0;
    $yi_difference = $max_value - $min_value;
    $ranking[$name] = $yi_difference;
}

arsort($ranking);
?>


<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Results</h2>
    <!-- <button onclick="exportTableToCSV('results.csv')" class="btn btn-primary">Export to CSV</button> -->
    <a href="print.php" class="btn btn-primary" target="_blank"><i class="fas fa-print"></i> Print</a>

</div>

<?php
// Koneksi ke database
$host = 'localhost';
$db = 'moora_test'; // Nama database
$user = 'root'; // Ganti dengan username database Anda
$pass = ''; // Ganti dengan password database Anda

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data kriteria
$sql_criteria = "SELECT * FROM criteria";
$result_criteria = $conn->query($sql_criteria);

$criteria = [];
$weights = [];

if ($result_criteria->num_rows > 0) {
    while ($row = $result_criteria->fetch_assoc()) {
        $criteria[] = $row;
        $weights[] = $row['weight']; // Simpan bobot untuk perhitungan
    }
}

// Ambil data dari database
$sql_alternatives = "SELECT * FROM alternatives";
$result_alternatives = $conn->query($sql_alternatives);

$alternatives = [];

// Tampilkan Data Mentah
echo "<div class='card shadow mb-4'>
    <div class='card-header py-3 d-flex justify-content-between align-items-center'>
        <h6 class='m-0 font-weight-bold text-primary'>
            Data Mentah
        </h6>
    </div>
    <div class='card-body'>
        <div class='table-responsive'>
            <table
                class='table table-bordered'
                id='dataTable'
                width='100%'
                cellspacing='0'>
                <thead><th>Alternatif</th>";

foreach ($criteria as $criterion) {
    echo "<th>{$criterion['name']}</th>";
}
echo "</tr>";
echo "</thead>";

if ($result_alternatives->num_rows > 0) {
    while ($row = $result_alternatives->fetch_assoc()) {
        echo "<tr>
        <td>{$row['name']}</td>";

        // Ambil nilai untuk setiap alternatif dari tabel alternative_values
        $sql_values = "SELECT * FROM alternative_values WHERE alternative_id = " . $row['id'];
        $result_values = $conn->query($sql_values);

        if ($result_values->num_rows > 0) {
            while ($value_row = $result_values->fetch_assoc()) {
                if ($criteria > $value_row) {
                    echo "<td>{$value_row['value']}</td>";
                } else {

                    echo "<td>asd</td>";
                }
                $alternatives[$row['name']][$value_row['criterion_id']] = (float)$value_row['value'];
            }
        }
        echo "</tr>";
    }
}

echo "</table>";
echo "</div></div></div>";

// Tampilkan Tabel Pembagi
// echo "<h3>Tabel Pembagi</h3>";
echo "<div class='card shadow mb-4'>
<div class='card-header py-3 d-flex justify-content-between align-items-center'>
<h6 class='m-0 font-weight-bold text-primary'>
Table Pembagi
</h6>
</div>
<div class='card-body'>
<div class='table-responsive'>
<table
class='table table-bordered'
id='dataTable'
width='100%'
cellspacing='0'>
<thead><th>Kriteria</th>
<th>Rumus</th>
<th>Hasil</th>";

$dividers = []; // Array untuk menyimpan nilai pembagi

foreach ($criteria as $index => $criterion) {
    $sum_of_squares = 0;
    foreach ($alternatives as $alt_name => $values) {
        // Ambil nilai untuk setiap alternatif dari array
        $value = isset($values[$criterion['id']]) ? $values[$criterion['id']] : 0;
        $sum_of_squares += pow($value, 2);
    }
    $result_value = sqrt($sum_of_squares);
    $dividers[$index] = $result_value; // Simpan nilai pembagi
    echo "<tr>
    <td>{$criterion['name']}</td>
    <td>√(Σ(X<sup>2</sup>))</td>
    <td>" . round($result_value, 4) . "</td>
    </tr>";
}

echo "</table>";
echo "</div></div></div>";

// Tampilkan Hasil Perkalian Data Mentah dengan Tabel Pembagi
echo "<div class='card shadow mb-4'>
<div class='card-header py-3 d-flex justify-content-between align-items-center'>
<h6 class='m-0 font-weight-bold text-primary'>
Hasil Perkalian Data Mentah dengan Tabel Pembagi
</h6>
</div>
<div class='card-body'>
<div class='table-responsive'>
<table
class='table table-bordered'
id='dataTable'
width='100%'
cellspacing='0'>
<thead><th>Alternatif</th>";

foreach ($criteria as $criterion) {
    echo "<th>{$criterion['name']}</th>";
}
echo "</tr>";

$normalized_values = []; // Array untuk menyimpan nilai normalisasi

foreach ($alternatives as $alt_name => $values) {
    echo "<tr>
    <td>$alt_name</td>";

    foreach ($criteria as $index => $criterion) {
        // Hasil perkalian
        $divider = isset($dividers[$index]) ? $dividers[$index] : 0;
        $result_multiplication = $divider != 0 ? (isset($values[$criterion['id']]) ? $values[$criterion['id']] : 0) / $divider : 0;
        echo "<td>" . round($result_multiplication, 4) . "</td>";
        $normalized_values[$alt_name][$criterion['id']] = $result_multiplication; // Simpan nilai normalisasi
    }
    echo "</tr>";
}

echo "</table>";
echo "</div></div></div>";

// Perhitungan: Mengalikan hasil normalisasi dengan bobot
echo "<div class='card shadow mb-4'>
<div class='card-header py-3 d-flex justify-content-between align-items-center'>
<h6 class='m-0 font-weight-bold text-primary'>
Hasil Perhitungan Normalisasi dengan Bobot
</h6>
</div>
<div class='card-body'>
<div class='table-responsive'>
<table
class='table table-bordered'
id='dataTable'
width='100%'
cellspacing='0'>
<thead><th>Alternatif</th>";

foreach ($criteria as $criterion) {
    echo "<th>{$criterion['code']} (Bobot: " . round($criterion['weight'], 2) . ")</th>";
}
echo "</tr>";

$yi = []; // Array untuk menyimpan nilai Y_i  
$max_values = []; // Array untuk menyimpan nilai Max  
$min_values = []; // Array untuk menyimpan nilai Min  
$results = []; // Array untuk menyimpan hasil perhitungan  

foreach ($alternatives as $alt_name => $values) {
    $y = 0;
    $result_row = [];
    $result_row['name'] = $alt_name;

    foreach ($criteria as $index => $criterion) {
        $weighted_value = $normalized_values[$alt_name][$criterion['id']] * $weights[$index];
        $y += $weighted_value;
        $result_row[$criterion['code']] = round($weighted_value, 4);

        // Hitung Max dan Min berdasarkan jenis kriteria  
        if ($criterion['type'] == 'Benefit') {
            if (!isset($max_values[$alt_name])) {
                $max_values[$alt_name] = 0;
            }
            $max_values[$alt_name] += $weighted_value;
        } elseif ($criterion['type'] == 'Cost') {
            if (!isset($min_values[$alt_name])) {
                $min_values[$alt_name] = 0;
            }
            $min_values[$alt_name] += $weighted_value;
        }
    }

    $result_row['total'] = round($y, 4);
    $results[] = $result_row;
    echo "<tr>  
     <td>$alt_name</td>";

    foreach ($criteria as $criterion) {
        echo "<td>" . $result_row[$criterion['code']] . "</td>";
    }
    // echo "<td>" . $result_row['total'] . "</td>";
    echo "</tr>";
    $yi[$alt_name] = $y;
}

echo "</table>";
echo "</div></div></div>";

// Tampilkan hasil akhir  
echo "<div class='card shadow mb-4'>
<div class='card-header py-3 d-flex justify-content-between align-items-center'>
<h6 class='m-0 font-weight-bold text-primary'>
Hasil Akhir (Y_i)
</h6>
</div>
<div class='card-body'>
<div class='table-responsive'>
<table
class='table table-bordered'
id='dataTable'
width='100%'
cellspacing='0'>
<thead><th>Alternatif</th>  
<th>Max</th>  
<th>Min</th>  
<th>YI (Max-Min)</th>  
<th>Ranking</th>";

$ranking = [];

foreach ($yi as $name => $value) {
    $max_value = isset($max_values[$name]) ? $max_values[$name] : 0;
    $min_value = isset($min_values[$name]) ? $min_values[$name] : 0;
    $yi_difference = $max_value - $min_value;
    $ranking[$name] = $yi_difference;
}

arsort($ranking);

$rank = 1;
foreach ($ranking as $name => $yi_difference) {
    $max_value = isset($max_values[$name]) ? $max_values[$name] : 0;
    $min_value = isset($min_values[$name]) ? $min_values[$name] : 0;
    echo "<tr>  
    <td>$name</td>  
    <td>" . round($max_value, 4) . "</td>  
    <td>" . round($min_value, 4) . "</td>  
    <td>" . round($yi_difference, 4) . "</td>  
    <td>$rank</td>  
    </tr>";
    $rank++;
}

echo "</table>";
echo "</div></div></div>";



$conn->close();
?>



<script>
    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("table tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [],
                cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++) {
                row.push(cols[j].innerText);
            }

            csv.push(row.join(","));
        }

        var csvFile = new Blob([csv.join("\n")], {
            type: "text/csv"
        });
        var downloadLink = document.createElement("a");

        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);

        downloadLink.click();
    }
</script>


<?php include '../includes/sidebar.php'; ?>

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>
