#!/bin/bash

# validating service
echo "validating service...."
result=$(curl -s -o /dev/null -I -w "%{http_code}" http://localhost/v1/user/self)
if [[ "$result" -eq "401" ]]; then
    exit 0
else
    exit 1
fi
echo "tests executed"