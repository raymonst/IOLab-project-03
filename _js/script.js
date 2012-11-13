var data = {

    //----------------------------------------------------------------------------------------------------------
    init : function() {
		data.plot();
		data.interaction();
    },

    plot : function() {

		d3.json("allShows.json", function(data) {

			// initial variables
			this.w = 800;
			this.h = 400;
			this.svg = d3.select("#chart").append("svg").attr("width",w).attr("height",h);
			this.padding = 1;

			this.xScale = d3.scale.linear().domain([0, w]).range([0, w]).nice();
			this.yScale = d3.scale.linear().domain([0, h]).range([h, 0]).nice();
			this.rScale = d3.scale.linear().domain([0, d3.max(data.values, function(d) { return d.count; })]).range([5, 150]).nice();

			this.xScaleAxis = d3.scale.linear().domain([0, 8]).range([0, w]).nice();
			this.yScaleAxis = d3.scale.linear().domain([3, 10]).range([h, 0]).nice();
			this.xAxis = d3.svg.axis().scale(xScaleAxis).orient("bottom").ticks(8);
			this.yAxis = d3.svg.axis().scale(yScaleAxis).orient("left").ticks(7);
			

																	
			// create data points
			svg.selectAll("circle")
			    .data(data.values)
			    .enter().append("circle")
			    .attr("class", function(d) { 
			    	return ("c-" + d.show.replace("#","")); 
			    })
			    .attr("id", function(d) { 
			    	return ("c-" + (d.show.replace("#","")) + d.day); 
			    })
			    .attr("cx", function(d) { 
			    	return d.day * 100; 
			    })
			    .attr("cy", function(d) { 
					return h - (((d.sentiment * 2.5) - 3) * h/7);
			    })
			    .attr("r", function(d) { 
			    	return rScale(d.count); 
			    })
			    // d3 doesn't work with "mouseenter"/"mouseleave"
			    .on("mouseover",function(self) {
					self = $(this);
					var radius = self.attr("r");
					var dataLabel = "." + self.attr("id");
					self.animate({"opacity": 1}, 100);
					d3.select(this).transition()
						.attr("r", function() { return radius * 1.05 })
						.delay(0)
						.duration(500)
						.ease("elastic", 1, 2);
					var statsInfo = self.parent().find(dataLabel).text();
					var getClass = "." + d3.select(this).attr("class");
					var getColor = $(getClass).css("fill");
					$("#tweets-info").css({"color":getColor}).show().html(statsInfo);
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
					$("#tweets-info").hide();
				})



			// tweets info
			svg.selectAll("text")
			    .data(data.values)
			    .enter()
			    .append("text")
			    .text(function(d) {
			    	return ("<h3>" + d.show + "</h3>" + d.count + " tweets<br/>" + Math.round(d.sentiment * 2.5 * 100) / 100 + " average sentiment");
			    })
			    .attr("class", function(d) {
				    var newClass = "c-" + d.show.replace("#","") + d.day + " stats";
			    	return newClass; 
			    })
			    .attr("x", function(d) {
			    	return 800;
			    })
			    .attr("y", function(d) {
			    	return 50;
			    });


			
			// x-axis
			svg.append("g")
				.attr("class", "axis")
				.attr("id", "x-axis")
				.attr("transform", "translate(0," + (h - padding) + ")")
				.call(xAxis);
			    
			// y-axis
			svg.append("g")
			    .attr("class", "axis")
				.attr("id", "y-axis")
			    .attr("transform", "translate(" + padding + ",0)")
			    .call(yAxis);
			    
			// horizontal grids
			for (var j = 0; j < w - (h/7); j = j + (h/7)) {
			    svg.append("svg:line")
			    	.attr("x1", 0)
			    	.attr("y1", j)
			    	.attr("x2", w)
			    	.attr("y2", j);
			};

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
				
    },

    //----------------------------------------------------------------------------------------------------------
    interaction : function() {

	    // highlight data points when user hovers over the show name, and show/hide when user clicks the show name
		$("#shows a").on("mouseenter",function(self) {
		    self = $(this);
		    var show = "." + self.parent().attr("id");
		    if (!(self.hasClass("off"))) {
			    $("#chart").find(show).animate({"opacity":1}, 100);		    
		    }
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
			    setTimeout(function() {
			        $("#chart").find(dataSet).each(function(i) {
			            var self = $(this); 
			            setTimeout(function() { 
			            	self.fadeIn(150);
			            }, 150 * i);
			        });
			    }, 150);   	
		    } else {
			    self.addClass("off");
			    var dataSet = "." + self.parent().attr("id");
			    setTimeout(function() {
			        $("#chart").find(dataSet).each(function(i) {
			            var self = $(this); 
			            setTimeout(function() { 
			            	self.fadeOut(150);
			            }, 150 * i);
			        });
			    }, 150);   	
		    }
			return false;
		});

	    // show/hide all data points
		$("#toggle-all").on("click", function(self) {
			self = $(this);
			if (self.hasClass("off")) {
				$("#chart circle").css({"opacity":.1}).fadeIn(500);
				self.text("hide all").removeClass("off");
				$("#shows a").removeClass("off");
			} else {
				$("#chart circle").fadeOut(100);
				self.text("show all").addClass("off");
				$("#shows a").addClass("off");
			}
			return false;
		});

	}

}

//--------------------------------------------------------------------------------------------------------------
$(document).ready(function() {

    data.init();

});
