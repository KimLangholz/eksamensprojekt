#!/bin/bash

# Start by checking out git (or creating /var/www/storage/logs/worker.log here - as it gets overridden because of a volume
# i think). Then supervisord will run without errors.

mkdir -p /var/log/supervisor && mkdir -p /var/www/storage/logs && touch /var/www/storage/logs/worker.log
exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf

exec /bin/bash -c "trap : TERM INT; sleep infinity & wait"