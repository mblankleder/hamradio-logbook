#!/bin/bash
mysqldump --opt -hlocalhost -u [dbUser] -p [dbName] > backup.sql && uuencode backup.sql | mail -s "Backup Logbook" my_email@something.com
