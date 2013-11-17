#!/bin/bash

VOLTAGE=$(( $RANDOM % 10 + 120 ));
AMPS=$(( $RANDOM % 300 + 400 ));
THE_TIME=`date +"%Y-%m-%d%%20%T"`;
STATE=1;
THE_HOUR=`date +%H`
MIN_HOUR=6
MAX_HOUR=22
if [ $1 -le 2 ]; then
    if [ $THE_HOUR -gt $MIN_HOUR -a $THE_HOUR -lt $MAX_HOUR ]; then
	curl "http://yoursmartsocket.com/SmartSocket/insertrecord.php?dev_id=$1&time_id=$THE_TIME&amps=$AMPS&volts=$VOLTAGE&state=$STATE";
    fi
else
    curl "http://yoursmartsocket.com/SmartSocket/insertrecord.php?dev_id=$1&time_id=$THE_TIME&amps=$AMPS&volts=$VOLTAGE&state=$STATE";
fi