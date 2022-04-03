#!/bin/bash

WORK_DIR=/var/www/html

find ${WORK_DIR}/storage -type d | xargs chmod a+w
chmod a+w ${WORK_DIR}/bootstrap/cache
