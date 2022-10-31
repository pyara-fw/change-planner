#!/bin/sh
export DOLLAR='$'
envsubst < /root/site-backend.conf > /etc/nginx/conf.d/site-backend.conf
envsubst < /root/nginx.conf > /etc/nginx/nginx.conf
umask 000
nginx -g "daemon off;"