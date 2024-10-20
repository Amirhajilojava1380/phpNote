<?php 

require 'Connect.php';

header('Content-Type: application/json ; charset=UTF-8');

$id   = filter_input( INPUT_POST , 'id' , FILTER_SANITIZE_STRING);


$result = [];

if (empty($id)) {

    

} else {
   
    $stmt = $conn->prepare("SELECT * FROM list_note WHERE id = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();

    $result2 = $stmt->get_result();


    if ($result2->num_rows == 0) {

       
    } else {


        $stmt = $conn->prepare("SELECT * FROM company WHERE id_note = ? ORDER BY Date ");
        $stmt->bind_param('s', $id);
        
        if ($stmt->execute()) {

            $query = $stmt->get_result();
            
            foreach ($query as $data) {
                $row = array();
                
                $price = floatval($data['price']); 
                $commission = floatval ($data['Commission']); 
                
                $total = $price * $commission / 100 ;
                $priceNet =   $price - $total  ; 

                $price = number_format($price);

                $priceNet = number_format($priceNet);

                $row['id'] = $data['id'];
                $row['id_note'] = $data['id_note'];
                $row['Date'] = $data['Date'];
                $row['price'] = $price;
                $row['Commission'] = $data['Commission'];
                $row['priceNet'] = $priceNet ;
                
                
    
                $result[] = $row ;
            }


    
        } else {
    
            
    
        }


    }
        
}


echo json_encode(["result"=>$result]);

?>