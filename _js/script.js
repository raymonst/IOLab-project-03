var tweet = {

    //----------------------------------------------------------------------------------------------------------
    init : function() {
    },

    //----------------------------------------------------------------------------------------------------------
    functionOne : function() {
    }

}

//--------------------------------------------------------------------------------------------------------------
$(document).ready(function() {
    tweet.init();

    var test = {"data": [{"text": 'I love titanic.'},
                         {"text": 'I hate titantic'}]};

    $.post('http://www.sentiment140.com/api/bulkClassifyJson?appid=derek@ischool.berkeley.com', test, function(data){
        
        if(!data)
        {
            console.log(data);
        }
        else
        {
            console.log("meh");
        }
    });

});