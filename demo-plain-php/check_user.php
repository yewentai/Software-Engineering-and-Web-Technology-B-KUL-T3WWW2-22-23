<?php
require_once 'php/model/Student.php';

$output = null;
if (isset($_POST['email'])) {
    $student = Student::getStudentByEmail($_POST['email']);
    if ($student == null) {
        $output = [
            'status' => 'nok',
            'msg' => 'email not found'
        ];
        http_response_code(404);
    } else {
        $output = [
            'status' => 'ok',
            'msg' => 'user already registered'
        ];
        http_response_code(200);
    }
} else {
    $output = [
        'status' => 'error',
        'msg' => 'no email given'
    ];
    http_response_code(400);
}

header('Content-Type: application/json');
echo json_encode($output);