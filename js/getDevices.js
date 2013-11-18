$(function() {
    console.log("Started..");

    var start_date = (5).days().ago().toString('yyyy-MM-dd')
    var end_date = Date.parse('today').toString('yyyy-MM-dd');

    $('#start_date').val(start_date);
    $('#end_date').val(end_date);

    if (the_devices.length > 0) { GetAllPoints(); }
    ko.applyBindings(new DeviceViewModel());
});

function Device(data) {
    var self = this;
    self.dev_id = ko.observable(data.dev_id);
    self.nickname = ko.observable(data.nickname);
    self.schedule = ko.observable(data.schedule);
    self.max_power_usage = ko.observable(data.max_power_usage);
    self.max_cost = ko.observable(data.max_cost);
    self.user_set_state = ko.observable(data.user_set_state);
    self.IsChecked = ko.computed({
	read: function() {
	    if (+self.user_set_state() == "2") {
		return getStateFromSchedule(self);
	    } else if (+self.user_set_state() == "1") {
		return true;
	    } else {
		self.user_set_state("0");
		return false;
	    }
	},
	write: function(val) {
	    self.user_set_state((val)?"1":"0")
	}
    });
    self.use_schedule = ko.computed({
	read: function() {
	    return (+self.user_set_state() >= 2);
	},
	write: function(val) {
	    if (val) {
		self.user_set_state("2");
	    } else {
		var on = getStateFromSchedule(self);
		self.user_set_state(on?"1":"0");
	    }
	}
    }); 
    self.nickname.subscribe(function() { self.onChange(); });
    self.max_cost.subscribe(function() { self.onChange(); });
    self.user_set_state.subscribe(function() { self.onChange(); });
    //self.use_schedule.subscribe(function() { self.onChange(); });
}
Device.prototype = {
    onChange: function() { 
	console.log("Postback: " + ko.toJSON(this)); 
	updateDevice(this);
    }
}

function DeviceViewModel() {
    var self = this;

    self.devices = ko.observableArray(the_devices);

    self.refresh = function() {
	console.log("user_id is " + user_id);
	$.ajax({
	    url: "http://yoursmartsocket.com/SmartSocket/php_scripts/getDevices.php",
	    dataType: "json",
	    context: this,
	    data: {'user_id': user_id}
	}).done(function(resp) {
	    console.log("ajax returned!");
	    self.devices(resp);
	});
    };
}

function getStateFromSchedule(device) {
    console.log('schedule says: false');
    //TODO: get status by reading schedule and calculating
    return false;
}

function updateDevice(device) {
    data = JSON.parse(ko.toJSON(device));
    console.log("GETing!  dev_id is " + data.dev_id);
	$.ajax({
	    type: "GET",
	    url: "http://yoursmartsocket.com/SmartSocket/php_scripts/updateDevices.php",
	    dataType: "json",
	    context: this,
	    data: data
	}).done(function(resp) {
	    console.log("update ajax returned! resp = [" + resp + "]");
	});
};

var the_plot;
function RenderPlot() {
    console.log("rendering!");

    if (the_plot) { the_plot.destroy(); }
    
    var dateFormat = "%Y-%m-%d";
    the_plot = $.jqplot('usage', the_points, {
	title:'Current Usage',
	axes:{
	    xaxis:{label:'date',
		   labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		   renderer:$.jqplot.DateAxisRenderer,
		   tickRenderer: $.jqplot.CanvasAxisTickRenderer,
		   tickOptions: {
                       angle: -30,
                       formatString: dateFormat
                   },
		   
	    },
            yaxis:{label:'amps',
		   labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		   min:0, max:1000
	    }
	},
	series:[{lineWidth:4, markerOptions:{style:'square'}}]
    });
}
var i = 0;
function GetAllPoints() {
    var dev_ids = the_devices.map(function(x) { return x.dev_id(); });
    i = 0;
    dev_ids.forEach(function(dev_id) {
	GetPoints(dev_id);
    });
}

function GetPoints(dev_id) {
    var start = $('#start_date').val();
    var end = $('#end_date').val() + ' 23:59:59';
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
	    console.log("ajax returned!dev_id="+dev_id);
	    the_data = resp;
	    the_points[dev_id] = resp.map(function(el) { 
		return [el.time_id, el.amps]; 
	    });
	    i = i+1;
	    console.log("i="+i);
	    if (i == the_devices.length) { 
		var dev_ids = the_devices.map(function(x) { return x.dev_id(); });
		the_points = dev_ids.map(function(x) { return the_points[x]; });
		RenderPlot(); 
	    }
	    
	});
    return false;
}
