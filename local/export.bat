@echo off
:P_START
cls
echo /*****************************************/
echo /        rains     �G�N�X�|�[�g           /
echo /*****************************************/

set /p INP="�G�N�X�|�[�g���܂���?(Y/n)"
echo %INP%
if %INP%==Y goto P_EXPORT
if %INP%==y goto P_EXPORT
if %INP%==N goto P_END
if %INP%==n goto P_END
goto P_START

:P_EXPORT
echo %date% %time% �o�͂��J�n���܂�
REM %APPDATA%\postgresql\pgpass.conf�Ƀ��[�U�[���ƃp�X���[�h��o�^����

echo rains�f�[�^�o�͒��E�E�E
"C:\Program Files"\PostgreSQL\9.4\bin\psql -f rains.txt -d rains -U kennpin1 -o rains.csv -A -F, -q -t

echo imglist�f�[�^�o�͒��E�E�E
"C:\Program Files"\PostgreSQL\9.4\bin\psql -f imglist.txt -d rains -U kennpin1 -o imglist.csv -A -F, -q -t

echo rank�f�[�^�o�͒��E�E�E
"C:\Program Files"\PostgreSQL\9.4\bin\psql -f rank.txt -d rains -U kennpin1 -o rank.csv -A -F, -q -t

echo entry�f�[�^�o�͒��E�E�E
"C:\Program Files"\PostgreSQL\9.4\bin\psql -f entry.txt -d rains -U kennpin1 -o entry.csv -A -F, -q -t

:P_END
echo %date% %time% �I�����܂���
pause
