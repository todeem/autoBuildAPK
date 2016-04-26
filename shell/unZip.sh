#!/bin/bash
apk="$1"
apkName=`echo ${apk}|awk -F '.' '{print $1}'`
cd $2
APKTMP="`pwd`/tmp/"
cd -
unzip -d  ${APKTMP}${apkName} ${APKTMP}${apk}
sourceid=`cat ${APKTMP}${apkName}/assets/sourceid.txt`
rm -fr {${APKTMP}${apk},${APKTMP}${apkName}}
echo ${sourceid}
