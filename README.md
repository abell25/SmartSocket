SmartSocket
===========

The was my teams' senior design project at UW-Milwaukee.  Our project was to create a electrical socket that could be monitored 
and scheduled to be turned on or off during certain times of the day/week.  We had a web interface that was a
mixture of php, html5, and javascript with the knockout.js library.  The socket was controlled with an arduino
microcontroller that could connect to the internet to upload readings.  The readings were sent to a central 
server that ran on a amazon ec2 instance (which was also the server for the web interface).  The user could 
view graphs of usage over selected date intervals, schedule the device to turn on or off at specific times and 
dates.

