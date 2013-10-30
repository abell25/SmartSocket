#!/bin/bash

VOLTAGE=$(( $RANDOM % 10 + 120 ));
AMPS=$(( $RANDOM % 300 + 400 ));
THE_TIME=`date +"%Y-%m-%d%%20%T"`;
STATE=1;
curl "http://yoursmartsocket.com/SmartSocket/insertrecord.php?dev_id=$1&time_id=$THE_TIME&amps=$AMPS&volts=$VOLTAGE&state=$STATE";