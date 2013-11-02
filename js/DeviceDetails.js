$(function() {
    console.log("Started..");

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