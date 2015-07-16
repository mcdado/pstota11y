#!/bin/bash

foldername=$(dirname $(pwd))
projname=$(basename $(pwd))
rsync -a --exclude-from=.rsyncrc $(pwd) $TMPDIR
cd $TMPDIR
mkdir -p $foldername/$projname/dist/
zip -rq $foldername/$projname/dist/$projname-latest.zip $projname
cd $foldername/$projname
rm -rf $TMPDIR/$projname
