<?php
session_start();

if (!isset($_SESSION['patient_logged_in'])) {
    header('Location: index.html');
    exit();
}


include 'patients_data.php';

$currentPatientName = $_SESSION['patient_name'];

$currentPatient = null;
foreach ($patients as $patient) {
    if ($patient['name'] === $currentPatientName) {
        $currentPatient = $patient;
        break;
    }
}

if (!$currentPatient) {
    echo "<p>Error: Unable to retrieve patient information.</p>";
    exit();
}

$totalWaitTime = 0;
foreach ($patients as $patient) {
    if ($patient['arrival_time'] < $currentPatient['arrival_time']) {
        $totalWaitTime += 8;
    }
}

$currentDoctor = null;
foreach ($doctors as $doctor) {
    if ($doctor['id'] === $currentPatient['doctor_id']) {
        $currentDoctor = $doctor;
        break;
    }
}

if (!$currentDoctor) {
    echo "<p>Error: Unable to retrieve doctor information.</p>";
    exit();
}

$totalWaitTime = 0;
foreach ($patients as $patient) {
    if ($patient['doctor_id'] == $currentDoctor['id'] && $patient['arrival_time'] < $currentPatient['arrival_time'] && !isset($_SESSION['treatment_done'][$patient['id']])) {
        $totalWaitTime += 8; 
    }
}

$currentPatient['estimated_wait'] = $totalWaitTime; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('./hospital.jpg'); 
            background-size: cover; 
            background-position: center; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transition: background-image 0.5s ease;
        }

        .container {
            max-width: 900px;
            width: 100%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); 
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            opacity: 0; 
            transition: opacity 0.3s ease; 
        }

        .content {
            grid-column: span 1;
        }

        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 15px;
        }

        button {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 30px;
        }

        button:hover {
            background-color: #0056b3;
        }

        img {
            max-width: 600px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .show {
            opacity: 1; 
        }

       
        .return-button {
            position: absolute;
            top: 20px;
            left: 35px;
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <button class="return-button" onclick="location.href='index.html'">Return</button>
    
    <div class="container">
        <div class="content">
            <h2>Patient Information</h2>
            <p><strong>Name:</strong> <span id="patientName"></span></p>
            <p><strong>Age:</strong> <span id="patientAge"></span></p>
            <p><strong>Gender:</strong> <span id="patientGender"></span></p>
            <p><strong>Symptoms:</strong> <span id="patientSymptoms"></span></p>
            <p><strong>Estimated Wait Time:</strong> <span id="waitTime"><?php echo $currentPatient['estimated_wait']; ?></span> minutes</p>
            <p><strong>Assigned Doctor:</strong> <span id="doctorName"></span></p>
            <p><strong>Number of Patients Ahead:</strong> <span id="patientsAhead"><?php echo $totalWaitTime / 8; ?></span></p>
            
            <button onclick="location.reload()">Refresh</button>
        </div>
        
        <div>
            <img src="patients.jpg" alt="Patients">
        </div>
    </div>

    <script>
        setTimeout(function() {
            var patientName = "<?php echo htmlspecialchars($currentPatient['name']); ?>";
            var patientAge = "<?php echo $currentPatient['age']; ?>";
            var patientGender = "<?php echo $currentPatient['gender']; ?>";
            var patientSymptoms = "<?php echo htmlspecialchars($currentPatient['symptoms']); ?>";
            var doctorName = "<?php echo htmlspecialchars($currentDoctor['name']); ?>";

            document.getElementById('patientName').textContent = patientName;
            document.getElementById('patientAge').textContent = patientAge;
            document.getElementById('patientGender').textContent = patientGender;
            document.getElementById('patientSymptoms').textContent = patientSymptoms;
            document.getElementById('doctorName').textContent = doctorName;

            document.querySelector('.container').classList.add('show');
        }, 500); 
    </script>
</body>
</html>
