#!/bin/sh

DATADIR=$(cd $(dirname $0)/..;pwd)/data
#BACKDIR=$(cd $(dirname $0)/..;pwd)/backup

DNAME=`date +%Y`/`date +%m`/`date +%d`
FNAME=`date +%H%M%S`.tar.gz

cd $DATADIR
tar cfvz $FNAME *.csv >/dev/null

if [ ! -e $DNAME ]; then
 mkdir -p $DATADIR/$DNAME
fi

mv $DATADIR/$FNAME $DATADIR/$DNAME
