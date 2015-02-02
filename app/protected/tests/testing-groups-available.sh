#! /bin/bash

cd `dirname $0`


find * -type f | grep "\.php" | xargs grep -ho '@group.*' 2> /dev/null | sort | uniq
