@echo off
:P_START
cls
echo /*****************************************/
echo /        rains     エクスポート           /
echo /*****************************************/

set /p INP="エクスポートしますか?(Y/n)"
echo %INP%
if %INP%==Y goto P_EXPORT
if %INP%==y goto P_EXPORT
if %INP%==N goto P_END
if %INP%==n goto P_END
goto P_START

:P_EXPORT
echo %date% %time% 出力を開始します
REM %APPDATA%\postgresql\pgpass.confにユーザー名とパスワードを登録する

echo rainsデータ出力中・・・
"C:\Program Files"\PostgreSQL\9.4\bin\psql -f rains.txt -d rains -U kennpin1 -o rains.csv -A -F, -q -t

echo imglistデータ出力中・・・
"C:\Program Files"\PostgreSQL\9.4\bin\psql -f imglist.txt -d rains -U kennpin1 -o imglist.csv -A -F, -q -t

echo rankデータ出力中・・・
"C:\Program Files"\PostgreSQL\9.4\bin\psql -f rank.txt -d rains -U kennpin1 -o rank.csv -A -F, -q -t

echo entryデータ出力中・・・
"C:\Program Files"\PostgreSQL\9.4\bin\psql -f entry.txt -d rains -U kennpin1 -o entry.csv -A -F, -q -t

:P_END
echo %date% %time% 終了しました
pause
