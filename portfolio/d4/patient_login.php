<?php
session_start();


$patients = [
    ['name' => 'John Doe', 'code' => 'abc'],
    ['name' => 'Jane Doe', 'code' => 'def'],
    ['name' => 'Mike Brown', 'code' => 'ghi'],
    ['name' => 'Anna Hill', 'code' => 'jkl'],
    ['name' => 'Tom Clark', 'code' => 'mno'],
    ['name' => 'Lucy Grey', 'code' => 'pqr'],
    ['name' => 'Ethan Hunt', 'code' => 'stu'],
    ['name' => 'Olivia Pain', 'code' => 'vwx'],
    ['name' => 'Mason Ray', 'code' => 'yz1'],
    ['name' => 'Ava Lee', 'code' => '234'],
    ['name' => 'Jacob Wells', 'code' => '567'],
    ['name' => 'Mia Song', 'code' => '890'],
    ['name' => 'Noah Flynn', 'code' => 'cab'],
    ['name' => 'Isabella Moon', 'code' => 'fed'],
    ['name' => 'Liam Sun', 'code' => 'ihg'],
    ['name' => 'Sophia Star', 'code' => 'lkj'],
    ['name' => 'Elijah Storm', 'code' => 'onm'],
    ['name' => 'Charlotte Gale', 'code' => 'rqp'],
    ['name' => 'Logan River', 'code' => 'uts'],
    ['name' => 'Amelia Field', 'code' => 'xwv'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $code = trim($_POST['code']);

    
    foreach ($patients as $patient) {
        if ($patient['name'] == $name && $patient['code'] == $code) {
            $_SESSION['patient_logged_in'] = true;
            $_SESSION['patient_name'] = $name;
            header('Location: patients.php');
            exit();
        }
    }

   
    echo "<p>Invalid name or password. Please try again.</p>";
    echo "<a href='index.html'>Go Back</a>";
}
?>

