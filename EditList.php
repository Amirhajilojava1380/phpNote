<?php 

require 'Connect.php';

header('Content-Type: application/json ; charset=UTF-8');

$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$id    = filter_input(INPUT_POST, 'id');

$response = [];

if (empty($title) && empty($id)) {

    $response['message'] = "مقدار لازمه خالی است";
    $response['status']  = false;

} else {
   
    $stmt = $conn->prepare("SELECT * FROM list_note WHERE id = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows == 0) {

        $response['message'] = "اسم شرکت وجود نداره";
        $response['status']  = false;

    } else {

        $row = $result->fetch_assoc();

        if ($row['title'] == $title) {

            $response['message'] = "اسم شرکت جدید وارد کنید";
            $response['status']  = false;

        }else{

            $insertStmt = $conn->prepare("UPDATE `list_note` SET `title`= ? WHERE id = ? ");

            $insertStmt->bind_param('si', $title,$id);
        
            if ($insertStmt->execute()) {
    
                $response['message'] = "ثبت شد";
                $response['status']  = true;
    
            } else {
    
                $response['message'] = "ناشناخته: " . $conn->error;
                $response['status']  = false;
    
            }


        }
        
    }
}

echo json_encode($response);

?>