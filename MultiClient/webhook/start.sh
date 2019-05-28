#!/bin/sh

nohup ./webhook webhook.conf >> webhook.log 2>&1 &
