#!/bin/bash
# $1:id
# sourceid: $1/$1.source
# file Name: $1/
ID="$1"
PackName="$2"
BK=$LANG
LANG=en_GB.UTF-8
HOME_PATH="$(dirname `pwd`)/"
HOME_KEY="${HOME_PATH}shell/lingxin"
#密钥密码
KEY_STR=4741811932
Directory_Id="${HOME_PATH}progressDirectory/$ID/"
Progress="${HOME_PATH}progress/$ID.progress"
Directory_source="${Directory_Id}$ID.source"
Unsign="${HOME_PATH}upfile/$PackName"
logadmin="${HOME_PATH}error/makeRun.log"
log="${Directory_Id}apk/${ID}.log"
JAVAHOME=/usr/java/jdk1.6.0_30/
PATH=${PATH}:${JAVAHOME}bin/
############# mysql db 
mysqlname="source"
mysqlpasswd=source
mysqldb="sourceid"
mysqlhost=localhost
mysqlport=3306
# -----------
sql2="update source set s_status=2 where s_id=$ID"
mysql -h${mysqlhost} -P${mysqlport} -u${mysqlname} -p${mysqlpasswd} ${mysqldb} -e"${sql2}"
############# ftp
ftp_adds="pekdc1-mob-02.kinggoo.cn"
ftp_user="phpftp"
ftp_passwd="phpftpwrite"

function funFtp()
#function start
{
frd=$1
fid=$2
/usr/bin/ftp -n<<!
open ${ftp_adds}
user ${ftp_user}  ${ftp_passwd}
prompt
lcd ${frd}
cd ${fid}
mput ./*
close
bye
!
}
############## 
export PATH JAVAHOME
# ------- Function ----------

# --------------------------------------------------------------------
if [ ! -d "${Directory_Id}" ] || [ ! -w "${Directory_Id}" ];then
	echo "`date` - warn | ${Directory_Id} 不可写或目录不存在" 2> ${logadmin}
	exit
fi
if [ ! -e "${Directory_source}" ];then
	 echo "`date` - warn | ${Directory_source} 目录不存在" 2>>${logadmin}
	exit
fi
mkdir -p "${Directory_Id}temp/"
mkdir -p "${Directory_Id}apk/"
Id_temp="${Directory_Id}temp/"
Id_apk="${Directory_Id}apk/"
cp "${Unsign}" "${Id_temp}"
cd ${Id_temp}/
unzip "${PackName}" -d ./todeem 2>> ${log}
#L=`cat ${Directory_source} |wc -l`
YY="1"
for line in $(<"${Directory_source}")
    do
	if [[ -e ./todeem/assets/sourid.txt ]];then
      echo $line  > ./todeem/assets/sourid.txt
    else 
      echo $line > ./todeem/assets/sourceid.txt
    fi  
	echo $YY > ${Progress}
	echo "`date` - info | Sourceid Add ==> TRUE" >> ${log}
	cd todeem
	zip -r  ../${line}.apk ./*
	jarsigner -verbose -keystore ${HOME_KEY} -storepass ${KEY_STR} -signedjar ../../apk/${line}.apk ../${line}.apk yek 2>> ${log}
	if [ ! -e ../../apk/${line}.apk ];then echo "`date` - error | Singner ==> Error" >> ${log} ; fi
	rm -fr ../${line}.apk
	((YY=$YY+1))
	cd -
    done
#rm -fr ../temp
sql="update source set s_status=0 where s_id=$ID"
mysql -h${mysqlhost} -P${mysqlport} -u${mysqlname} -p${mysqlpasswd} ${mysqldb} -e"${sql}"
sleep 1 
cp ${Directory_source} ${Id_apk}
funFtp "${Id_apk}" "${ID}"
LANG=$BK
