var the_plot;
$(function() {
    console.log("Started..");
    the_plot = $.jqplot('usage', [the_points], {
	title:'Current Usage',
	axes:{
	    xaxis:{label:'date',
		   labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		   renderer:$.jqplot.DateAxisRenderer
	    },
            yaxis:{label:'amps',
		   labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		   min:0, max:1000
	    }
	},
	series:[{lineWidth:4, markerOptions:{style:'square'}}]
    });
    ko.applyBindings(new ReadingViewModel());
});

function Reading(data) {
    var self = this;
    self.time_id = ko.observable(data.time_id);
    self.amps = ko.observable(data.amps);
    self.volts = ko.observable(data.volts);
    self.state =  ko.observable(data.state);
}

function ReadingViewModel() {
    var self = this;
    console.log("reading model started..");
    self.readings = ko.observableArray(the_readings);
    console.log("len of readings: " + self.readings().length);
}