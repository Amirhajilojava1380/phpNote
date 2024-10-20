<?php 

require 'Connect.php';

header('Content-Type: application/json ; charset=UTF-8');

$id    = filter_input(INPUT_POST, 'id');

$response = [];

if (empty($id)) {

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

        $stmt = $conn->prepare("SELECT * FROM company WHERE id_note = ?");
        $stmt->bind_param('s', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 0) {

            $insertStmt = $conn->prepare("DELETE FROM list_note WHERE id = ?");
            $insertStmt->bind_param('s', $id);
            $insertStmt->execute();

            $response['message'] = "ثبت شد";
            $response['status']  = true;

        }else{

            $insertStmt = $conn->prepare("DELETE FROM company WHERE id_note = ?");
            $insertStmt->bind_param('s', $id);
        
            if ($insertStmt->execute()) {

                $insertStmt = $conn->prepare("DELETE FROM list_note WHERE id = ?");
                $insertStmt->bind_param('s', $id);
                $insertStmt->execute();

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