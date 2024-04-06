<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$doctors = [
    ['id' => 1, 'name' => 'Dr. Smith', 'specialty' => 'Cardiology'],
    ['id' => 2, 'name' => 'Dr. Jones', 'specialty' => 'Pediatrics'],
    ['id' => 3, 'name' => 'Dr. Johnson', 'specialty' => 'Orthopedics'],
    ['id' => 4, 'name' => 'Dr. Lee', 'specialty' => 'General Surgery'],
    ['id' => 5, 'name' => 'Dr. Kim', 'specialty' => 'Neurology'],
    ['id' => 6, 'name' => 'Dr. Chen', 'specialty' => 'Dermatology']
];

$patients = [
    ['id' => 1, 'name' => 'John Doe', 'age' => 30, 'gender' => 'Male', 'symptoms' => 'Cough and fever', 'severity' => 2, 'arrival_time' => 0, 'treatment_done' => false, 'doctor_id' => 2], 
    ['id' => 2, 'name' => 'Jane Doe', 'age' => 25, 'gender' => 'Female', 'symptoms' => 'Broken arm', 'severity' => 5, 'arrival_time' => 2,'treatment_done' => false, 'doctor_id' => 3], 
    ['id' => 3, 'name' => 'Mike Brown', 'age' => 40, 'gender' => 'Male', 'symptoms' => 'Chest pain', 'severity' => 9, 'arrival_time' => 6,'treatment_done' => false, 'doctor_id' => 1], 
    ['id' => 4, 'name' => 'Anna Hill', 'age' => 22, 'gender' => 'Female', 'symptoms' => 'Severe headache', 'severity' => 8, 'arrival_time' => 7,'treatment_done' => false, 'doctor_id' => 5], 
    ['id' => 5, 'name' => 'Tom Clark', 'age' => 55, 'gender' => 'Male', 'symptoms' => 'Abdominal pain', 'severity' => 4, 'arrival_time' => 15,'treatment_done' => false, 'doctor_id' => 4], 
    ['id' => 6, 'name' => 'Lucy Grey', 'age' => 45, 'gender' => 'Female', 'symptoms' => 'Skin rash', 'severity' => 3, 'arrival_time' => 16,'treatment_done' => false, 'doctor_id' => 6], 
    ['id' => 7, 'name' => 'Ethan Hunt', 'age' => 35, 'gender' => 'Male', 'symptoms' => 'Fractured leg', 'severity' => 7, 'arrival_time' => 20, 'treatment_done' => false, 'doctor_id' => 3], 
    ['id' => 8, 'name' => 'Olivia Pain', 'age' => 29, 'gender' => 'Female', 'symptoms' => 'Burns', 'severity' => 6, 'arrival_time' => 23,'treatment_done' => false, 'doctor_id' => 4], 
    ['id' => 9, 'name' => 'Mason Ray', 'age' => 50, 'gender' => 'Male', 'symptoms' => 'High fever', 'severity' => 5, 'arrival_time' => 24,'treatment_done' => false, 'doctor_id' => 2], 
    ['id' => 10, 'name' => 'Ava Lee', 'age' => 27, 'gender' => 'Female', 'symptoms' => 'Dizziness', 'severity' => 4, 'arrival_time' => 24,'treatment_done' => false, 'doctor_id' => 5], 
    ['id' => 11, 'name' => 'Jacob Wells', 'age' => 65, 'gender' => 'Male', 'symptoms' => 'Shortness of breath', 'arrival_time' => 27,'severity' => 10, 'treatment_done' => false, 'doctor_id' => 1], 
    ['id' => 12, 'name' => 'Mia Song', 'age' => 38, 'gender' => 'Female', 'symptoms' => 'Dehydration', 'severity' => 3, 'arrival_time' => 28,'treatment_done' => false, 'doctor_id' => 2], 
    ['id' => 13, 'name' => 'Noah Flynn', 'age' => 47, 'gender' => 'Male', 'symptoms' => 'Head injury', 'severity' => 6, 'arrival_time' => 35,'treatment_done' => false, 'doctor_id' => 3], 
    ['id' => 14, 'name' => 'Isabella Moon', 'age' => 31, 'gender' => 'Female', 'symptoms' => 'Eye injury', 'severity' => 2, 'arrival_time' => 37,'treatment_done' => false, 'doctor_id' => 4], 
    ['id' => 15, 'name' => 'Liam Sun', 'age' => 59, 'gender' => 'Male', 'symptoms' => 'Hypothermia', 'severity' => 8, 'arrival_time' => 41,'treatment_done' => false, 'doctor_id' => 6], 
    ['id' => 16, 'name' => 'Sophia Star', 'age' => 26, 'gender' => 'Female', 'symptoms' => 'Electrical shock', 'severity' => 7, 'arrival_time' => 47,'treatment_done' => false, 'doctor_id' => 5], 
    ['id' => 17, 'name' => 'Elijah Storm', 'age' => 44, 'gender' => 'Male', 'symptoms' => 'Animal bite', 'severity' => 5, 'arrival_time' =>48,'treatment_done' => false, 'doctor_id' => 3],
    ['id' => 18, 'name' => 'Charlotte Gale', 'age' => 60, 'gender' => 'Female', 'symptoms' => 'Heat stroke', 'severity' => 4, 'arrival_time' => 52,'treatment_done' => false, 'doctor_id' => 4], 
    ['id' => 19, 'name' => 'Logan River', 'age' => 34, 'gender' => 'Male', 'symptoms' => 'Poisoning', 'severity' => 6,'arrival_time' => 59,'treatment_done' => false, 'doctor_id' => 6], 
    ['id' => 20, 'name' => 'Amelia Field', 'age' => 41, 'gender' => 'Female', 'symptoms' => 'Allergic reaction', 'severity' => 5, 'arrival_time' => 63,'treatment_done' => false, 'doctor_id' => 2], 
];



foreach ($doctors as $doctor) {
    $doctorId = $doctor['id'];
    $doctorPatients = array_filter($patients, function ($patient) use ($doctorId) {
        return isset($patient['doctor_id']) && $patient['doctor_id'] === $doctorId;
    });
    
    usort($doctorPatients, function ($a, $b) {
        return $a['arrival_time'] <=> $b['arrival_time'];
    });

    $waitTime = 0; 
    foreach ($doctorPatients as &$patient) {
        $patient['estimated_wait'] = $waitTime;
        $waitTime += 8;
    }

    
    foreach ($doctorPatients as $dp) {
        foreach ($patients as &$p) {
            if ($dp['id'] === $p['id']) {
                $p['estimated_wait'] = $dp['estimated_wait'];
            }
        }
    }
}
unset($patient);