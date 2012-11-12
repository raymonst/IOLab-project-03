var data = {

    //----------------------------------------------------------------------------------------------------------
    init : function() {
    
		d3.json("_js/data.json", function(data) {


			// initial variables
			this.w = 800;
			this.h = 500;
			this.svg = d3.select("#chart").append("svg").attr("width",w).attr("height",h);
			this.padding = 1;

			this.xScale = d3.scale.linear().domain([0, w]).range([0, w]).nice();
			this.yScale = d3.scale.linear().domain([0, h]).range([h, 0]).nice();
			this.rScale = d3.scale.linear().domain([0, d3.max(data.values, function(d) { return d.count; })]).range([3, 120]).nice();

			this.xScaleAxis = d3.scale.linear().domain([0, 8]).range([0, w]).nice();
			this.yScaleAxis = d3.scale.linear().domain([0, 10]).range([h, 0]).nice();
			this.xAxis = d3.svg.axis().scale(xScaleAxis).orient("bottom").ticks(8);
			this.yAxis = d3.svg.axis().scale(yScaleAxis).orient("left").ticks(8);


																	
			// create data points

/*
			var line = d3.svg.line()
			    .x(function(d) { 
			    	return d.day * 100; 
			    })
			    .y(function(d) { 
			    	return h - d.sentiment * 50; 
			    })
			svg.append("svg:path").attr("d",line(data.values)).attr("id","line-graph"); 
*/


			svg.selectAll("circle")
			    .data(data.values)
			    .enter().append("circle")
			    .attr("class", function(d) { 
			    	return d.show.replace("#",""); 
			    })
			    .attr("id", function(d) { 
			    	return (d.show.replace("#","") + d.day); 
			    })
			    .attr("cx", function(d) { 
			    	return d.day * 100; 
			    })
			    .attr("cy", function(d) { 
			    	return h - (d.sentiment * 10/4) * 50; 
			    })
			    .attr("r", function(d) { 
			    	return rScale(d.count); 
			    })
			    // d3 doesn't work with "mouseenter"/"mouseleave"
			    .on("mouseover",function(self) {
					self = $(this);
					var radius = self.attr("r");
					var dataLabel = "." + self.attr("id");
					self.animate({"opacity":1}, 100);
					self.parent().find(dataLabel).css({"display":"block"});
					d3.select(this).transition()
						.attr("r", function() { return radius*1.05 })
						.delay(0)
						.duration(500)
						.ease("elastic", 1, 2);
				})
				.on("mouseout", function() {
				    self = $(this);
					var radius = self.attr("r");
					var dataLabel = "." + self.attr("id");
				    self.animate({"opacity":.1}, 100);
					self.parent().find(dataLabel).hide();
					d3.select(this).transition()
						.attr("r", function() { return (1/1.05)*radius })
						.delay(0)
						.duration(500)
						.ease("elastic", 1, 2);
				})



			// labels
			svg.selectAll("text")
			    .data(data.values)
			    .enter()
			    .append("text")
			    .text(function(d) {
			    	return d.count + " tweets, " + d.sentiment + " average sentiment";
			    })
			    .attr("class", function(d) {
			    	return (d.show.replace("#","") + d.day); 
			    })
			    .attr("x", function(d) {
			    	return d.day * 100;
			    })
			    .attr("y", function(d) {
			    	return h - d.sentiment * 50 - 10;
			    });

			
			// x-axis
			svg.append("g")
				.attr("class", "axis")
				.attr("transform", "translate(0," + (h - padding) + ")")
				.call(xAxis);
			    
			// y-axis
			svg.append("g")
			    .attr("class", "axis")
			    .attr("transform", "translate(" + padding + ",0)")
			    .call(yAxis);
			    



			// assign random color to each show
/*
			$.each(data.shows,function(key, value) {
				$getClass = $("." + value);
				randomColor = '#' + (0x1000000 + Math.random() * 0xFFFFFF).toString(16).substr(1,6);
				$getClass.css({
					"fill":randomColor
				});
			});
*/
			
		});
		
		data.interaction();
		
    },

    //----------------------------------------------------------------------------------------------------------
    interaction : function() {

		$("#shows a").on("mouseenter",function(self) {
		    self = $(this);
		    var show = "." + self.parent().attr("id");
		    if (!(self.hasClass("off"))) {
			    $("#chart").find(show).animate({"opacity":1}, 100);		    
		    }
/*
       .attr("width", function(d) { return d * 20; } )
       .attr("fill", newColor);
*/
		}).on("mouseleave", function(self) {
		    self = $(this);
		    var show = "." + self.attr("id");
		    if (!(self.hasClass("off"))) {
			    $("#chart").find("circle").animate({"opacity":.1}, 100);		    
		    }
		}).on("click", function(self) {
		    self = $(this);
		    if (self.hasClass("off")) {
			    self.removeClass("off");
			    var dataSet = "." + self.parent().attr("id");
			    $("#chart").find(dataSet).fadeIn(100);
		    } else {
			    self.addClass("off");
			    var dataSet = "." + self.parent().attr("id");
			    $("#chart").find(dataSet).fadeOut(100);
		    }
			return false;
		});

	}

}

//--------------------------------------------------------------------------------------------------------------
$(document).ready(function() {

    data.init();

});
