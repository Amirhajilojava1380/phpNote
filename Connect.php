<?php 
    
    $server = [

        'host'=>'localhost',
        'user'=>'root',
        'pass'=>'',
        'db'=>'note'

    ];

    $response = [];

    $conn = new mysqli( $server['host'] , $server['user'] , $server['pass'] , $server['db'] );

    if ($conn->connect_error) {
        
        $response["status"] = false ;

    }else{

        //$response["status"] = true;
        
    }

    //echo json_encode($response);
?>