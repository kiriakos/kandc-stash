#! /bin/bash

dir=`dirname $0`
cd "$dir"


while inotifywait ../../
do
    ./test.sh $@
done

