#! /bin/bash

rsync -avuz --exclude="assets/*" \
    --exclude="images/*" \
    --exclude="thumbnails/*" \
    app/ root@mail.kindstudios.gr:/srv/vhttp/kindstudios.gr/largefiles/kandc/

