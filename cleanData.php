<?PHP


$test = "dddd ///// \"\\\\";
echo $test;
echo "<br><br>";

$data = str_replace("\\", "/" , $test);
echo $test;
echo "<br><br>";

preg_replace('\$', '/', $test);
echo $test;
echo "<br><br>";

//$today = getdate();
//$today = mktime();
//var_dump($today);
//echo "<br><br>";

/*
$today = strftime("%F");
var_dump($today);


for($n = 0; $n < 10; $n++)
{
	echo "<br><br>";
	$date = strftime("%F", strtotime("-{$n} day", strtotime($today)));

	var_dump($date);
	echo "<br><br>";
}

$test = array();
$tweets = 1;

if(empty($tweets))
{
	echo "the array is empty";
}
else
{	
	echo "the array is something, who knew";
}



/*
$file_handle = fopen("Tweets.csv", "r");


$all_tweets = array();
$tweet_dates = array();

$index = 0;

while (!feof($file_handle)) {

//echo "{$index} <br>";
$line_of_text = fgets($file_handle);

preg_match("/[0-9]+,(.*),.{3},/", $line_of_text, $matches);

$all_tweets[$index] = $matches[1];

preg_match("/([0-9]{2} [A-Z][a-z]{2}.*:[0-9]{2}:[0-9]{2}.+[0-9]{4})/", $line_of_text, $matches);

//$tweet_dates[$index] = $matches[1];

$index++;

}

fclose($file_handle);

*/
/*
$file_write = fopen("sentiments.txt", "w+");
fwrite($file_write, $all_tweets);
fclose($file_write);
*/

//$data = "RT @dannisiminerio: I SHIP NICK AND JESS SO MUCH THAT IT HURTS #newgirl @sydneeyxx";
//$data ="\"It's your birthday and you won't eat cake. You're better than that.\" - Jess #NewGirl";
//$data = "We (@eltiofanegas @mariasimavilla @david_boyero) are talking about you @ZooeyDeschanel and #newgirl";  

//$data = "#bored :\ decided to have a #newgirl marathon :/";
$data = "We (@eltiofanegas @mariasimavilla @david_boyero) are talking about you @ZooeyDeschanel and #newgirl";

//$data = str_replace("\"", "'", $data);
//$data = str_replace("\\", "/" , $tweet_data[$x][2]);
echo "<br>";
echo "$data  <br>";
$data_string = "{\"data\": [{\"text\": \"{$data}\"}]}";

echo "$data_string <br>";
/*
for ($x =0; $x < 10; $x++)
{
	$data_string .= "{\"text\": \"{$all_tweets[$x]}\"}"; 
	
	if($x != 9)
	{
		$data_string .= ",";
	}

}
$data_string .= "]}";
*/
//echo $data_string;
                                                            
var_dump(json_decode($data_string)); 

$ch = curl_init('http://www.sentiment140.com/api/bulkClassifyJson?appid=derek@ischool.berkeley.com');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
 
$result = curl_exec($ch);

//$sentiment = preg_match("/\"polarity\":([0-4],/", $result, $matches);
echo "<br>";
var_dump( $result );
echo "<br>";
var_dump(json_decode($result));


//print_r($matches[1]);

/*
$test = "sydneyvanasse,266321054107058180,RT @nbc30rock: .@ABFalecbaldwin Congrats on over one million followers!  High-fiving a million angels… LITERALLY. #30Rock,Wed, 07 Nov 2012 23:27:41 +0000";

if ( preg_match("/([0-9]{2} [A-Z][a-z]{2}.*:[0-9]{2}:[0-9]{2}.+[0-9]{4})/", $test, $matches))
{
	echo "found a match\n";
	echo $matches[0] . "<br>";
	echo $matches[1];

}
else
{
	echo "trouble\n";
}

*/
/*
$j = 0;
foreach ($matches as $tweets)
{
	echo "j: $tweets <br>";
	++$j;
}
*/
?>