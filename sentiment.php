    
<?php
//include($_SERVER['DOCUMENT_ROOT'] . '/IOlab-project-03/search.php');//includes searchResults function 

function _json_decode($string) {
	if (get_magic_quotes_gpc()) {
		$string = stripslashes($string);
	}

	return json_decode($string);
}

function error_json_decode(){

		switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }

    echo "<br><br>";
}

// -------------------------------------- 
//code taken from http://php.net/manual/en/function.array-multisort.php
/* 
* -------- function arguments -------- 
*   $array ........ array of objects
*   $sortby ....... the object-key to sort by
*   $direction ... 'asc' = ascending
* --------
*/

function cmp($a, $b)
{
    return strcmp(strtotime($a->date), strtotime($b->date));
}


  
 
// -------------------------------------- 



/*************************************************************************************************************
	assignSentiment function!
	Input:
		takes an multidemenstional array:  Array must be nx4 
		arraryfields are assumed to be 
			[0] => query (tweet search term)
			[1] => tweet id 
			[2] => tweet text
			[3] => tweet creation date and time
	 Return value:
	 	function returns multidimensional associative array, rows are indexed by numerical values [0] - [n]
	 	The associative array fields are 
	 		[date], [id], [polarity], [text], [meta]
**************************************************************************************************************/

function assignSentiment( $tweet_data ) {

$data_string = "{\"data\": [";
$test = 200;

	for ($x =0; $x < /*$test */ count($tweet_data); $x++)
	{
		//var_dump($tweet_data[$x][2]);, \"date\": {$tweet_data[$x][3]}, \"date\": {$tweet_data[$x][3]}
		$tweet_data[$x][2] = str_replace("\"", "'", $tweet_data[$x][2]);
		$tweet_data[$x][2] = str_replace(":\\", ":/" , $tweet_data[$x][2]);
		$data_string .= "{\"date\": \"{$tweet_data[$x][3]}\", \"text\": \"{$tweet_data[$x][2]}\", \"query\": \"{$tweet_data[$x][0]}\", \"id\": \"{$tweet_data[$x][1]}\"}"; 
		
		if($x != /*$test-1 */count($tweet_data) -1)
		{
			$data_string .= ",";
		}

	}
	$data_string .= "]}";

	$data_string = utf8_encode($data_string);
/*
	echo "the raw data_string before getting sentimentized";                 
	var_dump($data_string);                                            
	echo "<br><br>";

	echo "the json decoded raw data";
	var_dump(json_decode($data_string));
	echo "<br><br>";
*/	
	
	$ch = curl_init('http://www.sentiment140.com/api/bulkClassifyJson?appid=derek@ischool.berkeley.com');                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	    'Content-Type: application/json',                                                                                
	    'Content-Length: ' . strlen($data_string))                                                                       
	);                                                                                                                   
	 
	$result = curl_exec($ch);
/*
	echo "<br><br>"; 
	echo "the sentimentized data non-jsonized";
	var_dump($result);
	echo "<br><br>";
*/	

	$result = utf8_encode($result);
	$result = json_decode($result);
/*	
	error_json_decode();
	echo "the sentimentized data in json";
	var_dump($result->data);
	echo "<br><br>";

	/*
    echo "the returned data from assignSentiment function";
    var_dump($result->data);
    echo "<br><br>";
    */

	return $result->data;
}


function write_to_file ($file_name, $data){

	
	$add_to = get_data_from_file($file_name);
	//echo "<br><br>";
	//var_dump($data);
	$fhandle = fopen($file_name, "w+");
	

	//echo "<br><br>";
	//var_dump($add_to);
	//echo "<br><br>";
	if(!empty($add_to))
	{
		$data = array_merge($add_to, $data);
		usort($data, "cmp");
	}

	//var_dump($data);
	//echo "<br><br>";
	$write_bytes = fwrite($fhandle, serialize($data));
	fclose($fhandle);
}

function get_data_from_file ($file_name)
{
	$data = file_get_contents($file_name);

	if($data)
	{
		return unserialize($data); 
	}
	else
	{
		return NULL;
	}

}


/*************************************************************************************************************
	binData function!
	Assumptions:
		This function assumes that the dates in the array rows are sorted in ascending or descending order
	Input:
		takes an multidemenstional associative array (output of assignSentiment) 
		arraryfields are assumed to be 
			["query"] => query (tweet search term)
			["id"] => tweet id 
			["text"] => tweet text
			["date"] => tweet creation date and time
			["meta"] => language and topic of tweet (optional)
	 Return value:
	 	function returns multidimensional associative array
	 	The associative array fields are 
	 		[shows] => array("show1", "show2"....etc)
	 		[values] => array("count"=>, "sentiment"=>, "time"=>, "show"=>)
	 		[random_tweets] => array(bunch of tweet text)
**************************************************************************************************************/

function binData ($data){
/*
	var_dump(substr($data[0]->date,0, 16));
	var_dump(substr($data[1]->date,0, 16));
	var_dump(substr($data[0]->date, 0,16) == substr($data[1]->date, 0, 16));
*/	

	$cur_date = substr($data[0]->date, 0, 16);
	$count = 0;
	$s_sum = 0;
	$binned = array();
	$n = 0;
	$x = 1;

	foreach( $data as $row)
	{
		/*
		echo "show me what the date is <br>";
		var_dump($row->date);
		echo "<br>";
		*/

		if(count($data != 1))
		{
			if($n == count($data) -1)
			{
				$binned[] = array("count" => $count, "sentiment" => $s_sum/$count, "day"=> $x, "time"=>$cur_date, "show"=>$row->query );
			}
				
			if($cur_date == substr($row->date,0,16))
			{
				$count++;
				$s_sum += $row->polarity;
				$cur_date = substr($row->date, 0, 16);
			}
			else
			{
				$binned[] = array("count" => $count, "sentiment" => $s_sum/$count, "day"=> $x, "time"=>$cur_date, "show"=>$row->query );
				$cur_date = substr($row->date,0,16);
				$count = 0;
				$s_sum = 0;
				$x++;
			}
			$n++;
		}
		else
		{
			$binned[] = array("count" => 1, "sentiment" => $data->polarity, "day"=> $x, "time"=>$cur_date, "show"=>$row->query );
		}
	}

var_dump($binned);
	$result = array("shows"=> "", "values"=> $binned, "random_tweets"=>"");

	return $result;

}

function convert2Json ($file_name, $agg_data)
{

	file_put_contents($file_name, json_encode($agg_data)) ;
}




/*
$test[] = array("date"=>"Sat, 10 Nov 2012 07:33:42 +0000", "text"=>"RT @tori_clark: â€œ@SoWillSays: Reigning cats & dogsâ€ #newgirl", "query"=> "#NewGirl" , "id"=>"267168138620194816");
$test[] = array("date"=>"Sat, 10 Nov 2012 07:32:48 +0000", "text"=>"A girl can only dream of having roommates like Nick, Schmidt and Winston. #newgirl", "query"=>"#NewGirl", "id"=>"267167911234371584");
$test[] = array("date"=>"Sat, 10 Nov 2012 07:31:49 +0000","text"=>"I love a show that can have me hysterically laughing by myself at 2:30 in the morning #newgirl","query"=>"#NewGirl", "id"=> "267167662143049728");
$test[] = array("date"=>"Sat, 10 Nov 2012 07:28:44 +0000", "text"=>"Best book known to man! #newgirl #schmidt #douchejar #amazingness #love #sofunny http://t.co/YNXE8KJx" ,"query"=>"#NewGirl", "id"=>"267166888621113344");
*/

/*
$test[] = array("#NewGirl", "11", "I love turtles", "Wed, 14 Nov 2012 07:44:42 +0000");
$test[] = array("#NewGirl", "11", "I love turtles", "Sun, 11 Nov 2012 07:33:42 +0000");
$test[] = array("#NewGirl", "11", "I love turtles", "Sat, 10 Nov 2012 07:33:42 +0000");
$test[] = array("#NewGirl", "11", "I love turtles", "Tue, 13 Nov 2012 07:33:42 +0000");
$test[] = array("#NewGirl", "11", "I love turtles", "Wed, 14 Nov 2012 07:34:42 +0000");
*/
//var_dump($test);
//echo "<br><br>";



//binData(assignSentiment($test));
//convert2Json(binData(assignSentiment(searchResults("#NewGirl"))));
//var_dump(searchResults("#NewGirl"));
/*
$tweets = searchResults("#NewGirl");


$result = assignSentiment($tweets);

echo "number retrieved from twitter";
echo count($result);
echo "<br><br>";

write_to_file("NewGirl.txt", $result);

$result = get_data_from_file("NewGirl.txt");
//var_dump($result);
echo "number of items array stored in file";
echo count($result);
echo "<br><br>";


foreach($result as $row)
{
	print_r($row);
	echo "<br>";

}
echo "<br><br>";


//$result = get_data_from_file("test.txt");


/*
usort($result, "cmp");

echo "<br> sorted? <br><br>";

$count = 0;
foreach($result as $row)
{
	//echo "\$result[$count]: " . $row["text"] . ", " . $row["id"] . ", " . $row["query"] . ", " . $row["polarity"]. ", " . $row["date"]. "<br>";
	print_r($row);
	echo "<br>";
	$count++;
}
*/
/*
print_r($result);
echo "<BR><BR>";

//binData($result);
*/
?>


