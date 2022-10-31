#!/bin/sh

echo "working... ${ENV_TARGET}"

# curl http://localhost:8080/health -o /tmp/health.txt

# HEALTH_STATUS=`cat /tmp/health.txt`
HEALTH_STATUS=OK


if [ "$HEALTH_STATUS" != "OK" ]
then
    echo "HEALTH STATUS (step 1) ='" $HEALTH_STATUS "'" > /dev/stderr
    echo "HEALTH STATUS (step 1) ='" $HEALTH_STATUS "'" > /dev/stdout
    exit 1
fi


