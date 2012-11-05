<pre>
<html>
<head>
<meta charset="UTF-8" />
</head>
<body>
    
<?php

//$data = array("data" => array( "text" => "I love Titanic.", "text" => "I hate Titanic." ));                                                                    
$data_string = "{\"data\": [{\"text\": \"I love Titanic.\"}, 
							{\"text\": \"I hate Titanic.\"},
							{\"text\": \"The staff sucks.\"}]}";
                                                                                  
 
$ch = curl_init('http://www.sentiment140.com/api/bulkClassifyJson?appid=derek@ischool.berkeley.com');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
 
$result = curl_exec($ch);

var_dump( $result );

?>

</body>
</html>
</pre>
