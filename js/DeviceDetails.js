var the_plot;
var vm;
$(function() {
    console.log("Started..");
    
    var start_date = (5).days().ago().toString('yyyy-MM-dd')
    var end_date = Date.parse('today').toString('yyyy-MM-dd');

    $('#start_date').val(start_date);
    $('#end_date').val(end_date);

    RenderPlot();
    vm = new ReadingViewModel();
    ko.applyBindings(vm);
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

function GetPoints() {
    var start = $('#start_date').val();
    var end = $('#end_date').val();
    $.ajax({
	url: "http://yoursmartsocket.com/SmartSocket/php_scripts/getReadings.php",
	    dataType: "json",
	    context: this,
	data: {
	       'dev_id': dev_id, 
	    'start_time': start,
	       'end_time': end
	      }
	}).done(function(resp) {
	    console.log("ajax returned!");
	    console.log(resp);
	    the_data = resp;
	    the_readings = the_data.map(function(el) { return new Reading(el); });
	    the_points = the_data.map(function(el) { 
		return [el.time_id, el.amps]; 
	    });
	    vm.readings(the_readings);
	    RenderPlot();
	});
    return false;
}

var the_plot;
function RenderPlot() {
    if (the_plot) { the_plot.destroy(); }

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
}