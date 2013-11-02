$(function() {
    console.log("Started..");
    
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
}

function DeviceViewModel() {
    var self = this;

    self.devices = ko.observableArray(the_devices);

    self.pull = function() {
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

    self.push = function(device) {
	console.log("dev_id is " + device.dev_id);
	$.ajax({
	    type: "POST",
	    url: "http://yoursmartsocket.com/SmartSocket/php_scripts/updateDevices.php",
	    dataType: "json",
	    context: this,
	    data: JSON.stringify(device)
	}).done(function(resp) {
	    console.log("update ajax returned! resp = [" + resp + "]");
	});
    };

}