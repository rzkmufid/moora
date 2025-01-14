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

// Ambil data Benefit
$sql_benefit = "SELECT id, code FROM criteria WHERE type = 'Benefit'";
$result_benefit = $conn->query($sql_benefit);

echo "<h3>Data Benefit</h3>";
echo "<table border='1'>
<tr>
<th>ID</th>
<th>Name</th>
</tr>";

if ($result_benefit->num_rows > 0) {
    while ($row = $result_benefit->fetch_assoc()) {
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['code']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='2'>No data available</td></tr>";
}

echo "</table>";

// Ambil data Cost
$sql_cost = "SELECT id, code FROM criteria WHERE type = 'Cost'";
$result_cost = $conn->query($sql_cost);

echo "<h3>Data Cost</h3>";
echo "<table border='1'>
<tr>
<th>ID</th>
<th>Name</th>
</tr>";

if ($result_cost->num_rows > 0) {
    while ($row = $result_cost->fetch_assoc()) {
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['code']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='2'>No data available</td></tr>";
}

echo "</table>";

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
echo "<h3>Data Mentah</h3>";
echo "<table border='1'>
<tr>
<th>Alternatif</th>";

foreach ($criteria as $criterion) {
    echo "<th>{$criterion['name']}</th>";
}
echo "</tr>";

if ($result_alternatives->num_rows > 0) {
    while ($row = $result_alternatives->fetch_assoc()) {
        echo "<tr>
        <td>{$row['name']}</td>";

        // Ambil nilai untuk setiap alternatif dari tabel alternative_values
        $sql_values = "SELECT * FROM alternative_values WHERE alternative_id = " . $row['id'];
        $result_values = $conn->query($sql_values);

        if ($result_values->num_rows > 0) {
            while ($value_row = $result_values->fetch_assoc()) {
                echo "<td>{$value_row['value']}</td>";
                $alternatives[$row['name']][$value_row['criterion_id']] = (float)$value_row['value'];
            }
        }
        echo "</tr>";
    }
}

echo "</table>";

// Tampilkan Tabel Pembagi
echo "<h3>Tabel Pembagi</h3>";
echo "<table border='1'>
<tr>
<th>Kriteria</th>
<th>Rumus</th>
<th>Hasil</th>
</tr>";

$dividers = []; // Array untuk menyimpan nilai pembagi

foreach ($criteria as $index => $criterion) {
    $sum_of_squares = 0;
    foreach ($alternatives as $alt_name => $values) {
        // Ambil nilai untuk setiap alternatif dari array
        $value = $values[$criterion['id']];
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

// Tampilkan Hasil Perkalian Data Mentah dengan Tabel Pembagi
echo "<h3>Hasil Perkalian Data Mentah dengan Tabel Pembagi</h3>";
echo "<table border='1'>
<tr>
<th>Alternatif</th>";

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
        $result_multiplication = $values[$criterion['id']] / $dividers[$index]; // Normalisasi
        echo "<td>" . round($result_multiplication, 4) . "</td>";
        $normalized_values[$alt_name][$criterion['id']] = $result_multiplication; // Simpan nilai normalisasi
    }
    echo "</tr>";
}

echo "</table>";

// Perhitungan: Mengalikan hasil normalisasi dengan bobot  
echo "<h3>Hasil Perhitungan Normalisasi dengan Bobot</h3>";  
echo "<table border='1'>  
<tr>  
<th>Alternatif</th>";  
  
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
    echo "<td>" . $result_row['total'] . "</td>";  
    echo "</tr>";  
    $yi[$alt_name] = $y;  
}  
  
echo "</table>";  
  
// Tampilkan hasil akhir  
echo "<h3>Hasil Akhir (Y_i)</h3>";  
echo "<table border='1'>  
<tr>  
<th>Alternatif</th>  
<th>Max</th>  
<th>Min</th>  
<th>YI (Max-Min)</th>  
<th>Ranking</th>  
</tr>";  
  
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
  
// Debugging  
echo "<h3>Debugging</h3>";  
echo "<pre>";  
foreach ($alternatives as $alt_name => $values) {  
    echo "Alternatif: $alt_name\n";  
    echo "Normalisasi:\n";  
    foreach ($criteria as $criterion) {  
        $criterion_id = $criterion['id'];  
        echo "  {$criterion['code']}: ";  
        $weighted_value = isset($normalized_values[$alt_name][$criterion_id]) ? $normalized_values[$alt_name][$criterion_id] * $weights[array_search($criterion_id, array_column($criteria, 'id'))] : 0;  
        echo "  {$criterion['name']}: " . round($weighted_value, 4) . "\n";  
    }  
    echo "Max: " . round($max_values[$alt_name], 4) . "\n";  
    echo "Min: " . round($min_values[$alt_name], 4) . "\n";  
    echo "YI (Max-Min): " . round($max_values[$alt_name] - $min_values[$alt_name], 4) . "\n";  
    echo "-------------------------\n";  
}  
echo "</pre>";  
  
$conn->close();  
