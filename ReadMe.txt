Project title:
TweeVee
 
Team member names:
Derek Kan, Raymon Sutedjo-The, Suhani N Mehta
 
Project Description:
TweeVee displays the trends of sentiments of TV shows' auidences based on their tweets on Twitter. It allows comparison of sentiments among the shows over a period of time.

We wanted to include multiple years of data. Due to lack of knowledge and resources, we worked on only 7 days of data. However, this data can be used to see differences in sentiments of audiences before/during/after the telecast of weekly shows. 

The visualizaton shows total number of tweets and average sentiment value of those tweets per day per TV show for past 7 days. The sentiment values are plotted on y axis on a rank of 1 to 10. The more positive the tweet, the higher rank it gets.

We follow a workflow to collect the data, process it and plot it in data visualization for each of the TV shows. The steps we follow are:
1. Collect 7 days of tweets for the respective hashtag of the TV show using Twitter API
2. Extract and organize the relevanr information from tweets in an array
3. Assign sentiment to each tweet using Sentiment140 API
4. Store the organized data to .txt files (one file is allocated to one TV show)
5. Retrieve the data from the files
6. Remove duplicate entires from the data
7. Convert the data to JSON objects and store them in file
8. Retrieve JSON objects and find the maximum no. of tweets for a show
9. Decide the size of the bubbles on the visualization based on step 8.
10. Plot the information using D3


We used a fixed number of TV shows for demonstration purposes. We tried to cover multiple genres in our selection. The TV shows we included, with their respective hash tags, are:

*Comedy*
30 Rock - #30Rock
Modern Family - #ModernFamily
New Girl - #NewGirl
How I Met Your Mother - #HIMYM


*Drama*
Walking Dead - #TheWalkingDead
Bones - #bones
Criminal Minds - #CriminalMinds



*Reality based*
Dancing With The Stars - #DWTS
The Voice - #TheVoice
Mythbusters - #MythBusters



*Cartoons*
Family Guy - #familyguy
South Park - #SouthPark


 
Technologies used:
HTML, PHP, Jquery, JSON, Twitter API, Sentiment140 API, Github
 
URL of the repository on github:
https://github.com/raymonst/IOLab-project-03
 
Live URL of where it's hosted:
??
 
 
Known bugs:
- The removal of duplicate entries has not been tested. We are unsure if it functions properly
- Most/All of the tweets are either positive or neutral (no negatives) based on Sentiment140 
- The Sentiment Analysis is inaccurate in many ways. One of the example is if a person tweets a dialogue from the show, the analysis is done of the dialogue instead of the intention of the user who tweeted it
- We are filtering tweets based on hash tag values only. They may not necessarily be of the TV show. For example, "#bones" may have been mentioned without allusion to the TV show

