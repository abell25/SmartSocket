var the_plot1;
var the_plot2;
var vm;
$(function() {
    console.log("Started..");
    
    var start_date = (5).days().ago().toString('yyyy-MM-dd')
    var end_date = Date.parse('today').toString('yyyy-MM-dd');

    $('#start_date').val(start_date);
    $('#end_date').val(end_date);
    GetPoints();
    UsageInfo();
    MakeCSV();
    //RenderPlot();
    vm = new ReadingViewModel();
    ko.applyBindings(vm);
    $('#device_name').text('Device: ' + nickname);
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
    var end = $('#end_date').val() + ' 23:59:59';
    console.log('start='+start+',end='+end);
    $.ajax({
	url: "http://yoursmartsocket.com/SmartSocket/php_scripts/getReadings.php",
	    dataType: "json",
	    context: this,
	data: {
	       'dev_id': dev_id, 
	    'start_time': start,
	    'end_time': end,
	    'num_points':30
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
	    the_points2 = UsageInfo();
	    RenderPlot('usage', the_plot1, the_points);
	    RenderPlot2('cost', the_plot2, the_points2);
	});
    return false;
}

function RenderPlot(div_name, the_plot, the_plot_data) {
    if (the_plot) { the_plot.destroy(); }

    var mindate = $('#start_date').val();
    var maxdate = $('#end_date').val() + ' 23:59:59';
    console.log('mindate=' + mindate + ',maxdate=' + maxdate);
    var min = Math.min.apply(Math, the_plot_data.map(function(x) { return x[1]; }));
    var max = Math.max.apply(Math, the_plot_data.map(function(x) { return x[1]; }));
    var dateFormat = (((Date.parse(maxdate)-Date.parse(mindate))/1000/60/60) < 48)? "%H:%M" : "%Y-%m-%d";
    console.log('min='+min+',max='+max+',dateFormat='+dateFormat);

    the_plot = $.jqplot(div_name, [the_plot_data], {
 	title:'Current Usage',
	axes:{
	    xaxis:{
		   min: mindate,
		   max: maxdate,
		   labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		   renderer:$.jqplot.DateAxisRenderer,
		   tickRenderer: $.jqplot.CanvasAxisTickRenderer,
		   tickOptions: {
                       angle: -30,
                       formatString: dateFormat
                   },
		   
	    },
            yaxis:{
		   labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		   min:min, 
		   max:max,
		   tickRenderer: $.jqplot.CanvasAxisTickRenderer,
		   tickOptions: {
                       formatString: "%d mA"
                   },
	    }
	},
	//series:[{lineWidth:4, markerOptions:{style:'square'}}],
	legend: { show: false, location: 'se'},
        cursor: { show: true, zoom: true, showTooltip: false }
    });
}

function RenderPlot2(div_name, the_plot, the_plot_data) {
    if (!max_cost) {
	console.log("no max cost!");
	return;
    }
    if (the_plot) { the_plot.destroy(); }

    var mindate = $('#start_date').val();
    var maxdate = $('#end_date').val() + ' 23:59:59';
    console.log('mindate=' + mindate + ',maxdate=' + maxdate);
    var min = Math.min.apply(Math, the_plot_data.map(function(x) { return x[1]; }));
    var max = Math.max.apply(Math, the_plot_data.map(function(x) { return x[1]; }));
    var dateFormat = (((Date.parse(maxdate)-Date.parse(mindate))/1000/60/60) < 48)? "%H:%M" : "%Y-%m-%d";
    console.log('min='+min+',max='+max+',dateFormat='+dateFormat);

    the_plot = $.jqplot(div_name, [the_plot_data, the_limit], {
 	title:'Total cost',
	series:[{showMarker:true}, {showMarker:false}],
	axes:{
	    xaxis:{
		   min: mindate,
		   max: maxdate,
		   labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		   renderer:$.jqplot.DateAxisRenderer,
		   tickRenderer: $.jqplot.CanvasAxisTickRenderer,
		   tickOptions: {
                       angle: -30,
                       formatString: dateFormat
                   },
		   
	    },
            yaxis:{
		   labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		   min:min, 
		   max:max,
		   //tickRenderer: $.jqplot.CanvasAxisTickRenderer,
		   tickOptions: {
                       formatString: "$%d"
                   },
	    }
	},
	//series:[{lineWidth:4, markerOptions:{style:'square'}}],
	legend: { show: false, location: 'se'},
        cursor: { show: true, zoom: true, showTooltip: false }
    });
}

function UsageInfo() {
    var max_cost = parseFloat(usageInfo['max_cost']);
    var max_power_usage = parseFloat(usageInfo['max_power_usage']);
    var power_cost = parseFloat(usageInfo['power_cost']);

    the_points2 = []; the_limit = [];
    var totalmAmps = 0; var totalTime = 0;
    for (var i=0; i<the_data.length; i++){
	if (i == 0) {
	    the_points2[i] = [the_data[i].time_id, 0];
	    the_limit[i] = [the_data[i].time_id, max_cost];
	} else {
	    var deltaTime = (new Date(the_data[i].time_id) - 
			     new Date(the_data[i-1].time_id))/1000;
	    totalTime += deltaTime;
	    totalmAmps += +the_data[i].amps;
	    var columbs = totalmAmps*totalTime/1000; // mA -> A
	    var amp_hrs = columbs/3600; // 3600 columns per hour
	    var kW_hrs = (amp_hrs*120)/1000;//volts=120, /1000 is kilo-
	    var cost = kW_hrs * power_cost/100; /*cents=100*/
	    the_points2[i] = [the_data[i].time_id, cost];
            the_limit[i] = [the_data[i].time_id, max_cost];
	}
    }
    return the_points2;
}

var the_content;
function MakeCSV() {
    var csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "date,time,state,amps,volts,cost\n";
    the_data.forEach(function(data, index) {
	var dataStr = data['time_id'] + "," + data['state'] + "," 
	    + data['amps'] + "," + data['volts'] + "," 
	    + the_points2[index][1] + "\n"; 
	csvContent += dataStr;
    });
    the_content = csvContent;

    var encodedUri = encodeURI(csvContent);
    $('#download_data').attr("href", encodedUri);
    $('#download_data').attr("download", "smartsocket_data.csv");
}