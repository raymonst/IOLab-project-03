<?PHP

/*  This function takes a twitter call and query and outputs an array within an array.  The internal array includes tweet "id", tweet "text"
    and tweet date "created_at"

*/
function searchResults( $search = null ) {

	$tweet_data = array();

	for($i = 1; $i <= 15; $i++)
	{
		$url = "http://search.twitter.com/search.json?q=" . urlencode( $search ) . "&lang=en&rpp=100" . $i . "&result_type=recent";
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$result = curl_exec( $curl );
		curl_close( $curl );
		$return = json_decode( $result, true );

		for($n = 0; $n < count($return["results"]); $n++)
		{
			//print($n+($i-1)*100);
			$tweet_data[$n + ($i -1)*100][0] = $return["results"][$n]["id"];
			$tweet_data[$n + ($i -1)*100][1] = $return["results"][$n]["text"];
			$tweet_data[$n + ($i -1)*100][2] = $return["results"][$n]["created_at"];
		}	
	}

	return $tweet_data;
}

//print_r(searchResults("#NewGirl"));
//$tweet_data = searchResults("#NewGirl");

//id
//text
//created_at
//var_dump($tweet_data);
//print(count($tweet_da))
/*
var_dump($tweet_data["results"][0]["created_at"]);
var_dump($tweet_data["results"][0]["id"]);
var_dump($tweet_data["results"][0]["text"]);
*/
?>