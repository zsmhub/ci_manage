#!/bin/bash
SAVE_DIR=$1
if [ ! -d "${SAVE_DIR}" ]; then
  SAVE_DIR=`pwd`
fi
MYSQL_DIR=/usr/local/mysql/bin
${MYSQL_DIR}/mysqldump -h115.238.100.176 -uwx -p"jdx3#ds@!9pass_wx" --skip-lock-tables wx > ${SAVE_DIR}/wx.sql

MYSQL_PASSWORD=`cat /data/save/mysql_password`

${MYSQL_DIR}/mysql -h127.0.0.1 -uroot -p${MYSQL_PASSWORD} -e "CREATE DATABASE IF NOT EXISTS wx"

${MYSQL_DIR}/mysql -h127.0.0.1 -uroot -p${MYSQL_PASSWORD} wx < ${SAVE_DIR}/wx.sql

exist=`${MYSQL_DIR}/mysql -h127.0.0.1 -uroot -p${MYSQL_PASSWORD} -Dmysql -e "SELECT User FROM user WHERE User='wx' LIMIT 1"`
if [ ! -n "${exist}" ];then
	${MYSQL_DIR}/mysql -h127.0.0.1 -uroot -p${MYSQL_PASSWORD} -e "GRANT ALL on wx.* to wx@'localhost' Identified by 'jdx3#ds@!9pass_wx'"
fi
