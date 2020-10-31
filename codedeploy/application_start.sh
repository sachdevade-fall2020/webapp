#!/bin/bash

# start apache service
echo "starting apache service...."
sudo systemctl start apache2
echo "exit code: $?"
echo "apache service started"