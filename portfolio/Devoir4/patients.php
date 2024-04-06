<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

if (isset($_POST['name']) && isset($_POST['code'])) {
    $inputName = $_POST['name'];
    $inputCode = $_POST['code'];

    $isValidUser = false;
    foreach ($patients as $patient) {
        if ($patient['name'] == $inputName && $patient['code'] == $inputCode) {
            $isValidUser = true;
            break;
        }
    }

    if ($isValidUser) {
        $_SESSION['patient_logged_in'] = true;
        $_SESSION['patient_name'] = $inputName;
    
        echo json_encode(array('redirect' => 'patient_dashboard.php'));
        exit();
    } else {
        http_response_code(401);
        echo json_encode(array('error' => 'Invalid name or password. Please try again.'));
        exit();
    }
}

?>