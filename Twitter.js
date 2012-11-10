$(document).ready(function(){



	//var HashTags=["%2330Rock", "%23ModernFamily", "%23NewGirl", "%23HIMYM", "%23TheWalkingDead", "%23bones", "%23CriminalMinds", "%23DWTS", "%23TheVoice", "%23MythBusters", "%23familyguy", "%23SouthPark"];  //%23 is url code for "#"

//var HashTags=["%23hello","%23ModernFamily","%23HIMYM"];


	//for (HTag in HashTags)   //loop through each of the hash tags
	//{
		TheTag="%23ModernFamily";
				//for (var p = 1; p <=15 ; p++)  //loop to retrieve all 15 pages each with 100 tweets
				//{ 
				p=1;		
				var CSVstring="";
						//rpp=no. of tweets returned per page. Max is 100
						//page= the page no. retrieved. Max is 1500 tweets. That is,  rpp * page = 100 * 15 = 1500 tweets
						//result_type = "recent" instead of "mixed" (which is recent AND popular)
						$.getJSON("http://search.twitter.com/search.json?q="+HashTags[HTag]+"&rpp=100&page="+p+"&result_type=recent&callback=?",
						function(tweets)

						 { 

								//go through each tweet
								for (i in tweets.results)
								{
										//tweets.results[i].profile_image_url   //IMAGE OF USER, IN CASE REQD
										CSVstring += tweets.results[i].from_user + ",";
										//CSVstring += tweets.results[i].from_user_id + ",";
										//CSVstring += tweets.results[i].from_user_name + ",";
										CSVstring += tweets.results[i].id + ",";
										//CSVstring += tweets.results[i].id_str + ",";
										CSVstring += tweets.results[i].text + ",";
										//CSVstring += tweets.results[i].geo + ",";
										CSVstring += tweets.results[i].created_at;
										CSVstring += "\r\n";
								} 

								//Send to php file to write in file
						 
										$.ajax({ url: 'http://people.ischool.berkeley.edu/~suhani/IOLab/writing.php',
										         data: {tweetsString: CSVstring, filename:TheTag},//filename:HashTags[HTag].substring(3)},
										         type: 'POST',  //Need to keep it POST data so that we can send out a longer string
										         success: function(CSVdata) { //From php, the whole file should be returned as CSV string
										         	
										                      //Put code to manipulate CSV data from file
										                  },
										         error: function (CSVdata){ console.log("This is in error");}
										                  	
										}); //end of ajax	

						}); //end of callback function

				//} //end of page numbers loop

//	} //end of HashTags loop


// $.get('http://people.ischool.berkeley.edu/~suhani/IOLab/writing.php?tweets='+TweetCSV, //connecting to php file and sending CSV string
            

//             function(CSVdata){ //From php, the whole file should be returned as CSV string
//             	console.log("Success");

//             	//Put code to manipulate CSV data from file
//             });

	return false;

}); //end of document.ready function
