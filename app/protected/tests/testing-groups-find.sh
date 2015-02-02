#! /bin/bash

find * -type f | grep '\.php' | xargs grep '@group '"$1"  #| awk '{ print $1 }'
