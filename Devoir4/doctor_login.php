<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$doctors = [
    ['name' => 'Dr. Smith', 'id' => '001'],
    ['name' => 'Dr. Jones', 'id' => '002'],
    ['name' => 'Dr. Johnson', 'id' => '003'],
    ['name' => 'Dr. Lee', 'id' => '004'],
    ['name' => 'Dr. Kim', 'id' => '005'],
    ['name' => 'Dr. Chen', 'id' => '006'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $code = $_POST['code'] ?? '';

    foreach ($doctors as $doctor) {
        if ($name == $doctor['name'] && $code == $doctor['id']) {
            $_SESSION['doctor_logged_in'] = true;
            $_SESSION['doctor_id'] = $doctor['id'];
            $_SESSION['processed_patients'] = [];
            header('Location: admin.php?doctorId=' . $doctor['id']);
            exit();
        }
    }
    echo "<p>Invalid name or ID. Please try again.</p>";
    echo "<a href='index.html'>Go Back</a>";
}
?>
