<?PHP


$file = array("#30Rock.json", "#ModernFamily.json", 
				  "#NewGirl.json", "#HIMYM.json", 
				  "#TheWalkingDead.json", "#bones.json", 
				  "#CriminalMinds.json", "#DWTS.json", 
				  "#TheVoice.json", "#MythBusters.json", 
				  "#familyguy.json", "#SouthPark.json");


for($n = 0; $n < count($file); $n++)
{	
	preg_match("/#(.+)\.json/", $file[$n], $matches);
	$shows[] = $matches[1];
}

$values = assembleVals($file);
$result = array("shows"=> $shows, "values"=> $values, "random_tweets"=>"");
file_put_contents("allShows.json", json_encode($result)); 

function assembleVals( $jsonFiles)
{

$dataM = array();

	foreach($jsonFiles as $file_name) 
	{

		$data = file_get_contents($file_name);
		$data = json_decode($data);

		/*
		echo "data from file";
		printJson($data->values);
		echo "<br>";
		echo "merged array";
		*/
		$dataM = array_merge($data->values, $dataM);

		/*
		printJson($dataM);
		echo "<br>";
		echo "<br>";
		*/

	}
	return $dataM;
}

function printJson( $json_dataArr )
{
	foreach($json_dataArr as $row)
	{
		//echo "entire row <br>";
		//print_r ($row); 
		//echo "<br> then by parts <br>";
		echo $row->count . ", " . $row->sentiment . ", " . $row->day . ", " . $row->time . ", " . $row->show;
		echo "<br>";
	}
	echo "<br>";
}

?>