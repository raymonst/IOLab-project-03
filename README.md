TweeVee
================
TweeVee displays the trends of sentiments of TV shows' audiences based on their tweets on Twitter. It allows comparison of sentiments among the shows over a period of time.

We wanted to include multiple years of data. Due to lack of knowledge and resources, we worked on only 7 days of data. However, this data can be used to see differences in sentiments of audiences before/during/after the telecast of weekly shows. 

The visualization shows total number of tweets and average sentiment value of those tweets per day per TV show for past 7 days. The sentiment values are plotted on y axis on a rank of 1 to 10. The more positive the tweets, the higher they rank on the y-axis.

We follow a workflow to collect the data, process it and plot it in data visualization for each of the TV shows. The steps we follow are:
* Collect 7 days' worth of tweets for the respective hashtag of the TV show using Twitter API.
* Extract and organize the relevant information from tweets in an array.
* Assign sentiment to each tweet using Sentiment140 API.
* Store the organized data to .txt files (one file is allocated to one TV show).
* Retrieve data from the files and remove duplicate entires.
* Convert the data to JSON objects and store them in file.
* Retrieve JSON objects. 
* Plot the data using D3.

We used a fixed number of TV shows for demonstration purposes. We tried to cover multiple genres in our selection. The TV shows we included, with their respective hash tags, are:

*Animations*
* Family Guy - #familyguy
* South Park - #SouthPark

*Comedy*
* 30 Rock - #30Rock
* How I Met Your Mother - #HIMYM
* Modern Family - #ModernFamily
* New Girl - #NewGirl

*Drama*
* Bones - #bones
* Criminal Minds - #CriminalMinds
* The Walking Dead - #TheWalkingDead

*Reality Shows*
* Dancing With The Stars - #DWTS
* Mythbusters - #MythBusters
* The Voice - #TheVoice

## Team Members and Roles
* [Derek Kan]() - sentiment analysis, main back-end functionalities
* [Suhani N Mehta]() - data collection from Twitter, additional back-end functionalities
* [Raymon Sutedjo-The](http://ray-mon.com/) -- interaction & interface design, data visualization

## Technologies Used
* Code - HTML, CSS, Javascript/jQuery, JSON, PHP
* APIs - Twitter, Sentiment140
 
## Demo Version 
http://ray-mon.com/tweevee/

## Known Bugs
* The removal of duplicate entries has not been tested. We are unsure if it functions properly.
* Most of the tweets are either positive or neutral (no negatives) based on Sentiment140.
* The Sentiment Analysis is not 100% accurate. For example, if a person tweets a dialogue from the show, the analysis is done of the dialogue instead of the intention of the user who tweeted it.
* We are filtering tweets based on hash tag values only. They may not necessarily be of the TV show. For example, "#bones" may have been mentioned without allusion to the TV show.

