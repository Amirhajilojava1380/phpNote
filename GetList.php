<?php 

    require 'Connect.php';

    header('Content-Type: application/json ; charset=UTF-8');

    $query = $conn->query("SELECT * FROM list_note");
    $result = [];



    if ($query->num_rows == 0) {

        

    }else{

        foreach ($query as $key) {

            $row = array();
    
            $row['id'] = $key['id'];
            $row['title'] = $key['title'];
           
    
            $result[] = $row;
        }

    }
  

    echo json_encode(["result"=>$result]);

?>