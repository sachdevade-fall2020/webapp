#!/bin/bash

# stop apache service
echo "stopping apache service...."
sudo systemctl stop apache2
echo "exit code: $?"
echo "apache service stopped"

# remove application files
echo "removing files...."
sudo rm -rf /var/www/html/*
echo "exit code: $?"
echo "files removed"