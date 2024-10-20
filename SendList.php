<?php 

header('Content-Type: application/json ; charset=UTF-8');

include 'Connect.php';

$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);

$response = [];

if (empty($title)) {

    $response['message'] = "مقدار لازمه خالی است";
    $response['status']  = false;

} else {
   
    $stmt = $conn->prepare("SELECT * FROM list_note WHERE title = ?");
    $stmt->bind_param('s', $title);
    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows != 0) {

        $response['message'] = "اسم شرکت قبلن ثبت شده";
        $response['status']  = false;
        

    } else {
        
        $insertStmt = $conn->prepare("INSERT INTO list_note (title) VALUES (?)");
        $insertStmt->bind_param('s', $title);

        if ($insertStmt->execute()) {

            $response['message'] = "ثبت شد";
            $response['status']  = true;

        } else {

            $response['message'] = "ناشناخته: " . $conn->error;
            $response['status']  = false;

        }
    }
}


echo json_encode($response);

?>