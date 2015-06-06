#!/bin/sh

FTPSERVER=133.242.158.131
FTPUSER=kennpin1
FTPPASS=1
FTPPATH="/public_html/rains/img"

IMGDIR="/home/rains/rains/img"
DATADIR="/home/rains/rains/data"
FTPTXT=$DATADIR"/ftp.txt"

DBNAME=rains
DBUSER=rains

cd $DATADIR

#Apacheがpsqlを実行しないため以下ボツ

set PASSWORD=rains

#echo レインズデータ出力中・・・
#psql -A -F, -t -c "select fld000,fld001 ,fld002 ,fld003 ,fld004 ,fld005 ,fld006 ,fld007 ,fld008 ,fld009 ,fld010 ,fld011 ,fld012 ,fld013 ,fld014 ,fld015 ,fld016 ,fld017 ,fld018 ,fld019 ,fld020 ,fld021 ,fld022 ,fld023 ,fld024 ,fld025 ,fld026 ,fld027 ,fld028 ,fld029 ,fld030 ,fld031 ,fld032 ,fld033 ,fld034 ,fld035 ,fld036 ,fld037 ,fld038 ,fld039 ,fld040 ,fld041 ,fld042 ,fld043 ,fld044 ,fld045 ,fld046 ,fld047 ,fld048 ,fld049 ,fld050 ,fld051 ,fld052 ,fld053 ,fld054 ,fld055 ,fld056 ,fld057 ,fld058 ,fld059 ,fld060 ,fld061 ,fld062 ,fld063 ,fld064 ,fld065 ,fld066 ,fld067 ,fld068 ,fld069 ,fld070 ,fld071 ,fld072 ,fld073 ,fld074 ,fld075 ,fld076 ,fld077 ,fld078 ,fld079 ,fld080 ,fld081 ,fld082 ,fld083 ,fld084 ,fld085 ,fld086 ,fld087 ,fld088 ,fld089 ,fld090 ,fld091 ,fld092 ,fld093 ,fld094 ,fld095 ,fld096 ,fld097 ,fld098 ,fld099 ,fld100 ,fld101 ,fld102 ,fld103 ,fld104 ,fld105 ,fld106 ,fld107 ,fld108 ,fld109 ,fld110 ,fld111 ,fld112 ,fld113 ,fld114 ,fld115 ,fld116 ,fld117 ,fld118 ,fld119 ,fld120 ,fld121 ,fld122 ,fld123 ,fld124 ,fld125 ,fld126 ,fld127 ,fld128 ,fld129 ,fld130 ,fld131 ,fld132 ,fld133 ,fld134 ,fld135 ,fld136 ,fld137 ,fld138 ,fld139 ,fld140 ,fld141 ,fld142 ,fld143 ,fld144 ,fld145 ,fld146 ,fld147 ,fld148 ,fld149 ,fld150 ,fld151 ,fld152 ,fld153 ,fld154 ,fld155 ,fld156 ,fld157 ,fld158 ,fld159 ,fld160 ,fld161 ,fld162 ,fld163 ,fld164 ,fld165 ,fld166 ,fld167 ,fld168 ,fld169 ,fld170 ,fld171 ,fld172 ,fld173 ,fld174 ,fld175 ,fld176 ,fld177 ,fld178 ,fld179 ,fld180 ,fld181 ,fld182 ,fld183 ,fld184 ,fld185 ,fld186 ,fld187 ,fld188 ,fld189 ,fld190 ,fld191 ,fld192 ,fld193 ,fld194 ,fld195 ,fld196 ,fld197 ,fld198 ,fld199 ,fld200 ,fld201 ,fld202 ,fld203 ,fld204 ,fld205 ,fld206 ,fld207 ,fld208 ,fld209 ,fld210 ,fld211 ,fld212 ,fld213 ,fld214 ,fld215 ,fld216 ,fld217 ,fld218 ,fld219 ,fld220 ,fld221 ,fld222 ,fld223 ,fld224 ,fld225 ,fld226 ,fld227 ,fld228 ,fld229 ,fld230 ,fld231 ,fld232 ,fld233 ,fld234 ,fld235 ,fld236 ,fld237 ,fld238 ,fld239 ,fld240 ,fld241 ,fld242 ,fld243 ,fld244 ,fld245 ,fld246 ,fld247 from hp_rains order by fld000" -U $DBUSER -d $DBNAME >$DATADIR/rains.csv


#echo レインズ関連データ出力中・・・
#psql -A -F, -t -c "select fldname,fld001,fld002,bnum,bname from hp_rainsfld order by fldname,fld001,fld002,bnum" -U $DBUSER -d $DBNAME >$DATADIR/rainslfld.csv

#echo 画像データ出力中・・・
#psql -A -F, -t -c "select fld000,fld001,fld002,fld003 from hp_imglist order by fld000,fld001,fld003 " -U $DBUSER -d $DBNAME >$DATADIR/imglist.csv

#echo ランキングタイトル出力中・・・
#psql -A -F, -t -c "select rank,rankname,rcomment,startday,endday from hp_rank order by rank " -U $DBUSER -d $DBNAME >$DATADIR/rank.csv

#echo エントリーデータ出力中・・・
#psql -A -F, -t -c "select rank,fld000,fld001,ecomment from hp_entry order by rank,fld000,fld001 " -U $DBUSER -d $DBNAME >$DATADIR/entry.csv

#echo 物件コメントデータ出力中・・・
#psql -A -F, -t -c "select fld000,fld001,fld002,fld003,fld004,fld005 from hp_bcomment order by fld000 " -U $DBUSER -d $DBNAME >$DATADIR/bcomment.csv

echo データファイル送信中・・・
cat << EOF > $FTPTXT
open ${FTPSERVER}
user ${FTPUSER} ${FTPPASS}
binary
prompt
cd ${FTPPATH}
cd ../data
lcd ${DATADIR}
mput *.csv
EOF

echo 画像ファイル送信中・・・
cd $IMGDIR
echo "cd ${FTPPATH}">>$FTPTXT
echo "lcd ${IMGDIR}">>$FTPTXT
echo "mput ${IMGDIR}/*.*">>$FTPTXT

for filepath in ${IMGDIR}/*; do
 if [ -d $filepath ] ; then
  echo "cd ${FTPPATH}">>$FTPTXT
  echo "mkdir ${filepath##*/}">>$FTPTXT
  echo "cd ${filepath##*/}">>$FTPTXT
  echo "lcd ${filepath}">>$FTPTXT
  echo "mput *.*">>$FTPTXT
 fi
done

echo "bye">>$FTPTXT

#cat $FTPTXT
/usr/bin/ftp -n < $FTPTXT

rm $FTPTXT

echo データ送信しました
