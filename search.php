<?PHP

/*  This function takes a twitter call and query and outputs an array within an array.  The internal array includes tweet "id", tweet "text"
    and tweet date "created_at"

*/
function searchResults( $search = null, $date) {

	if(empty($date))
	{
		echo "<br> date was not passed <br>";
		$date = strftime("%F");
	}

	$offset = 0;
	$tweet_data = array();

	for($i = 1; $i <= 15; $i++)
	{
		$url = "http://search.twitter.com/search.json?q=" . urlencode( $search ) . "&lang=en&rpp=100&page=" . $i . "&result_type=mixed&until=" . $date;
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$result = curl_exec( $curl );
		curl_close( $curl );
		$return = json_decode( $result, true );
/*
		echo "<br><br>";
		var_dump($return);
		echo "<br><br>";
*/
		if(empty($return["results"]))
		{
			break;
		}

		for($n = 0; $n < count($return["results"]); $n++)
		{
			//print($n+($i-1)*100);
			$tweet_data[$n + $offset/*($i - 1)*100*/][0] = $search;
			$tweet_data[$n + $offset][1] = $return["results"][$n]["id"];
			$tweet_data[$n + $offset][2] = utf8_encode($return["results"][$n]["text"]) ;
			$tweet_data[$n + $offset][3] = $return["results"][$n]["created_at"];
		}	
		$offset += count($return["results"]);
	}

	return $tweet_data;
}


//$result = searchResults("#NewGirl", "2012-11-04");
//var_dump($result);
/*
$hash = array("#NewGirl", "#ModernFamily");

foreach( $hash as $term)
{
	$tweet_data = searchResults($term);
	var_dump($tweet_data);
}
*/
//id
//text
//created_at

//print(count($tweet_da))
/*
var_dump($tweet_data["results"][0]["created_at"]);
var_dump($tweet_data["results"][0]["id"]);
var_dump($tweet_data["results"][0]["text"]);
*/
?>