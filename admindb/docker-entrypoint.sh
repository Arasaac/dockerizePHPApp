#!/bin/bash
sed -i 's/\${MYSQL_DATABASE}/'"$MYSQL_DATABASE"'/g' /bin/backup
sed -i 's/\${MYSQL_ROOT_PASSWORD}/'"$MYSQL_ROOT_PASSWORD"'/g' /bin/backup
sed -i 's/\${MYSQL_DATABASE}/'"$MYSQL_DATABASE"'/g' /bin/restore
sed -i 's/\${MYSQL_ROOT_PASSWORD}/'"$MYSQL_ROOT_PASSWORD"'/g' /bin/restore
exec "$@"

