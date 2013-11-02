$(function() {
    console.log("Started..");
    
    ko.applyBindings(new DeviceViewModel());
});

function Device(data) {
    var self = this;
    self.dev_id = data.dev_id;
    self.nickname = data.nickname;
    self.schedule = data.schedule;
    self.max_power_usage = data.max_power_usage;
    self.max_cost = data.max_cost;
    self.user_set_state = data.user_set_state;
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