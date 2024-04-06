<?php
include 'patients_data.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['doctor_logged_in'])) {
    header('Location: index.html');
    exit();
}

$doctorId = $_GET['doctorId'] ?? '';

if (!$doctorId) {
    header('Location: index.html');
    exit();
}

if (!isset($_SESSION['treatment_done'])) {
    $_SESSION['treatment_done'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['treated'])) {
        $treatedPatientIds = $_POST['treated'] ?? [];
        foreach ($treatedPatientIds as $treatedPatientId) {
            $_SESSION['treatment_done'][$treatedPatientId] = true;
        }
    }

    if (isset($_POST['requeue'])) {
        $requeuePatientIds = $_POST['requeue'] ?? [];
        foreach ($requeuePatientIds as $requeuePatientId) {
            unset($_SESSION['treatment_done'][$requeuePatientId]);
        }
    }
}

$doctorPatients = array_filter($patients, function ($patient) use ($doctorId) {
    return $patient['doctor_id'] == $doctorId && !isset($_SESSION['treatment_done'][$patient['id']]);
});

$processedPatients = array_filter($patients, function ($patient) use ($doctorId) {
    return $patient['doctor_id'] == $doctorId && isset($_SESSION['treatment_done'][$patient['id']]);
});


usort($doctorPatients, function ($a, $b) {
    return $a['arrival_time'] <=> $b['arrival_time'];
});
usort($processedPatients, function ($a, $b) {
    return $a['arrival_time'] <=> $b['arrival_time'];
});


$averageTreatmentTime = 8;
$remainingWaitTime = 0;
foreach ($doctorPatients as &$patient) {
    if (!isset($_SESSION['treatment_done'][$patient['id']])) {
        $patient['estimated_wait'] = $remainingWaitTime;
        $remainingWaitTime += $averageTreatmentTime;
    }
}
unset($patient); 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('./hospital.jpg');
            background-size: cover;
            padding: 20px;
        }

        h2 {
            color: black;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.5); 
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: rgba(242, 242, 242, 0.7); 
        }

        button {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

       
        form.return-form {
            position: absolute;
            top: 20px;
            left: 30px;
            background-color: transparent;
            padding: 0;
            box-shadow: none;
        }

        form.return-form button {
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        form.return-form button:hover {
            background-color: #0056b3;
        }

        
        .button-container {
            text-align: right;
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>

<h2>Patient Queue for Doctor ID: <?= htmlspecialchars($doctorId) ?></h2>
<form method="post">
    <table>
        <tr>
            <th>Order</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Severity</th>
            <th>Arrival Time</th>
            <th>Estimated Wait (min)</th>
            <th>Symptoms</th>
            <th>Status</th>
            <th>Treated</th>
        </tr>
        <?php foreach ($doctorPatients as $index => $patient): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($patient['name']) ?></td>
                <td><?= $patient['age'] ?></td>
                <td><?= $patient['gender'] ?></td>
                <td><?= $patient['severity'] ?></td>
                <td><?= $patient['arrival_time'] ?></td>
                <td><?= $patient['estimated_wait'] ?></td>
                <td><?= htmlspecialchars($patient['symptoms']) ?></td>
                <td><?= isset($_SESSION['treatment_done'][$patient['id']]) ? 'Treated' : 'Waiting' ?></td>
                <td><input type="checkbox" name="treated[]" value="<?= $patient['id'] ?>"></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="button-container">
        <button type="submit" name="action" value="update">Update Status</button>
    </div>
</form>

<h2>Processed Patients</h2>
<form method="post">
    <table>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Severity</th>
            <th>Arrival Time</th>
            <th>Estimated Wait (min)</th>
            <th>Symptoms</th>
            <th>Requeue</th>
        </tr>
        <?php foreach ($processedPatients as $patient): ?>
            <tr>
                <td><?= htmlspecialchars($patient['name']) ?></td>
                <td><?= $patient['age'] ?></td>
                <td><?= $patient['gender'] ?></td>
                <td><?= $patient['severity'] ?></td>
                <td><?= $patient['arrival_time'] ?></td>
                <td><?= 'N/A'  ?></td>
                <td><?= htmlspecialchars($patient['symptoms']) ?></td>
                <td><input type="checkbox" name="requeue[]" value="<?= $patient['id'] ?>"></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="button-container">
        <button type="submit" name="action" value="requeue">Requeue Selected</button>
    </div>
</form>

<h2>All Patients</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Severity</th>
        <th>Arrival Time</th>
        <th>Symptoms</th>
    </tr>
    <?php foreach ($patients as $patient): ?>
        <tr>
            <td><?= htmlspecialchars($patient['name']) ?></td>
            <td><?= $patient['age'] ?></td>
            <td><?= $patient['gender'] ?></td>
            <td><?= $patient['severity'] ?></td>
            <td><?= $patient['arrival_time'] ?></td>
            <td><?= htmlspecialchars($patient['symptoms']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>


<form class="return-form" method="get" action="index.html">
    <button type="submit">Return</button>
</form>

</body>
</html>