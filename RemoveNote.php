<?php 

require 'Connect.php';

header('Content-Type: application/json ; charset=UTF-8');

$id         = filter_input(INPUT_POST, 'id');
$id_note    = filter_input(INPUT_POST, 'id_note');

$response = [];

if (empty($id) && empty($id_note)) {

    $response['message'] = "مقدار لازمه خالی است";
    $response['status']  = false;

} else {
   
    $stmt = $conn->prepare("SELECT * FROM list_note WHERE id = ?");
    $stmt->bind_param('s', $id_note);
    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows == 0) {

        $response['message'] = "اسم شرکت وجود نداره";
        $response['status']  = false;

    } else {

        $stmt = $conn->prepare("SELECT * FROM company WHERE id = ? AND id_note = ?");
        $stmt->bind_param('ss', $id , $id_note);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows == 0) {

            $response['message'] = "مقدار وجود ندارد";
            $response['status']  = false;

        }else{


            $insertStmt = $conn->prepare("DELETE FROM company WHERE id = ? AND id_note = ?");
            $insertStmt->bind_param('ss', $id , $id_note);

            $result = $insertStmt->get_result();
            
            if ($insertStmt->execute()) {

                $response['message'] = "حذف شد";
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