#!/bin/bash

mainIP=10.128.82.112

while true;
do
	ping -c 1 $mainIP > /dev/null 2>&1
	if [ $? -ne 0 ]
	then
	       	echo "Main server down"
		python3 /home/kevin/git/IT490Comic/pythonScript/createMatchup.py
	fi

done
