<?php 

require 'Connect.php';

header('Content-Type: application/json ; charset=UTF-8');

$id            = filter_input( INPUT_POST, 'id');
$Date          = filter_input(INPUT_POST, 'Date');
$price         = filter_input(INPUT_POST, 'price');
$Commission    = filter_input(INPUT_POST, 'Commission');

$response = [];

if (empty($id) && empty($price)) {

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


        $insertStmt = $conn->prepare("INSERT INTO company ( id_note , Date , price , Commission ) VALUES (?,?,?,?)");
        $insertStmt->bind_param('ssss', $id , $Date , $price , $Commission);
        
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