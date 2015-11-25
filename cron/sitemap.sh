#!/bin/sh

cd $(dirname $0)


#今日を求める
nen=`date '+%Y'`
tuki=`date '+%m'`
hi=`date '+%d'`

#ヘッダー(sitemap.xml)
HEADER=`cat << EOF
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
EOF
`

#フッター(sitemap.xml)
FOOTER=`cat << EOF
</urlset>
EOF
`
#SITEURL
URL=""

rm ../sitemap*.xml

#物件個別ページ
VAL=`psql -t -A -F,<<EOF
select 
'${URL}/room.php?fld000='||t.fld000
from hp_rains as t
left outer join hp_blacklist as t1 on
t.fld000=t1.fld000
where 
t1.fld000 is null
order by 
t.fld001,t.fld002,t.fld003,t.fld000
EOF`
ARY=($VAL)

#40000行ごとに区切る
fileno=1
i=0
for TARGET in ${ARY[*]}
do
 if [ $i -eq 0 ] ; then
  echo "${HEADER}" > ../sitemap${fileno}.xml
  ((i++))
  ((i++))
 fi
 echo "<url><loc>"${TARGET}"</loc></url>" >> ../sitemap${fileno}.xml
 ((i++))
 if [ $i -ge 40000 ] ; then
  i=0
  echo "${FOOTER}" >> ../sitemap${fileno}.xml
  ((fileno++))
 fi
done
echo ${FOOTER} >> ../sitemap${fileno}.xml

#固定ページ作成
((fileno++))
cat << EOF >> ../sitemap${fileno}.xml
 <?xml version="1.0" encoding="UTF-8"?>
 <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
 <url>
  <loc>${URL}/annai.php</loc>
 </url> 
 <url>
  <loc>${URL}/index.php</loc>
 </url> 
 <url>
  <loc>${URL}/interview.php</loc>
 </url> 
 <url>
  <loc>${URL}/privacy.php</loc>
 </url> 
 <url>
  <loc>${URL}/q_and_a.php</loc>
 </url> 
 <url>
  <loc>${URL}/yanusi.php</loc>
 </url> 
</urlset>
EOF

#sitemapリスト作成
i=0
f=1

echo '<?xml version="1.0" encoding="UTF-8"?>' >>../sitemap.xml
echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' >> ../sitemap.xml

#サイトマップリスト生成
while :
do
 echo "<sitemap>" >> ../sitemap.xml
 echo "<loc>${URL}/sitemap${f}.xml</loc>" >> ../sitemap.xml
 echo "</sitemap>" >> ../sitemap.xml
 ((f++))
 if [ $f -gt $fileno ] ; then
  break
 fi
done

echo "</sitemapindex>" >> ../sitemap.xml

