<?php 

require 'Connect.php';

header('Content-Type: application/json ; charset=UTF-8');

$id         = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
$id_note    = filter_input(INPUT_POST, 'id_note' ,FILTER_SANITIZE_STRING);
$Date       = filter_input(INPUT_POST, 'Date'  );
$price      = filter_input(INPUT_POST, 'price' ,FILTER_SANITIZE_STRING);
$Commission = filter_input(INPUT_POST, 'Commission' , FILTER_SANITIZE_STRING);


$response = [];

if (empty($id) && empty($id_note) && empty($Date) && empty($price) && empty($Commission)) {

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

        $stmt = $conn->prepare("SELECT * FROM company WHERE id = ?");
        $stmt->bind_param('s', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows != 0) {

            

            $insertStmt = $conn->prepare("UPDATE `company` SET `Date`= ? , price = ? , Commission = ?  WHERE id = ? ");

            $insertStmt->bind_param('ssss', $Date,$price ,$Commission , $id );
        
            if ($insertStmt->execute()) {
    
                $response['message'] = "تغییر داده شد";
                $response['status']  = true;
    
            } else {
    
                $response['message'] = "ناشناخته: " . $conn->error;
                $response['status']  = false;
    
            }


        }else{

            $response['message'] = "  مقدار شما وجود نداره ";
            $response['status']  = false;

        }

       
            

        }
        
    }


echo json_encode($response);

?>