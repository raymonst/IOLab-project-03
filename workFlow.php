<?PHP

ini_set("memory_limit","80M");
include($_SERVER['DOCUMENT_ROOT'] . '/IOlab-project-03/search.php');//includes searchResults() function 
include($_SERVER['DOCUMENT_ROOT'] . '/IOlab-project-03/sentiment.php');//includes other necesary functions 
																	   //assignSentiment(), binData, usort() {for sorting by time}, 
																	   //get_data_from_file(), write_to_file()
				

$hash = array(/*"#ModernFamily", "#NewGirl", "#30Rock", "#HIMYM", "#TheWalkingDead", "#bones", "#CriminalMinds", "#DWTS", "#TheVoice", "#MythBusters",*/ "#familyguy", "#SouthPark");


foreach($hash as $item)
{

$count = 0;
$query = $item;
$date = strftime("%F");
$date = strftime("%F", strtotime("-1 day", strtotime($date)));
$tweets = 1;
$data_file = $query .".txt";
$json_file = $query .".json";

var_dump($date);
echo "<br><br>";

while(!empty($tweets) && $count < 10)
{	
	$tweets = searchResults($query, $date);
	echo count($tweets);
	echo "<br><br>";

	if(!empty($tweets))
	{
		$sentimentized = assignSentiment($tweets);
		echo count($sentimentized);
		echo "<br><br>";
		write_to_file($data_file, $sentimentized);	
		//break;
	}
	sleep(0.5);
	$date = strftime("%F", strtotime("-1 day", strtotime($date)));
	echo $date;
	echo "<br><br>";
	$count++; 

}


	$data = get_data_from_file($data_file);
	
	echo count($data);
	$result = binData($data);
	convert2Json($json_file, $result);
	foreach($result as $row)
	{
		print_r($row);
		echo "<br>";
	}
}
?>