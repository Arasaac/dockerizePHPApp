FROM debian:jessie

MAINTAINER juanda <juandacorreo@gmail.com>

RUN apt-get update && \
    apt-get install mysql-client cron bzip2 -y && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    mkdir /backups

RUN echo Europe/Madrid | tee /etc/timezone && dpkg-reconfigure --frontend noninteractive tzdata
ADD crontab /etc/cron.d/backups

ADD docker-entrypoint.sh /entrypoint.sh
ADD backup /bin/
ADD restore /bin/
#Add env variables so they can be used by crontab:
ENTRYPOINT ["/entrypoint.sh"]


# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/backups

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Run the command on container startup
CMD cron && tail -f /var/log/cron.log
#CMD ["cron", "-f"]

