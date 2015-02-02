#! /bin/bash

rsync -avuz --exclude="assets/*" app/ root@mail.kindstudios.gr:/srv/vhttp/kindstudios.gr/largefiles/kandc/

