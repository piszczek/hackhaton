FROM nginx:1.15.0

# INSTALL OPEN SSL
RUN apt-get update && apt-get install -y \
  openssl \
  htop \
  nano \
  iputils-ping \
  curl

# CLEAN APT AND TMP
RUN apt-get clean && apt-get autoremove && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# CREATE SSL CERT
RUN mkdir -p /etc/nginx/ssl

RUN openssl req \
        -new \
        -newkey rsa:4096 \
        -days 365 \
        -nodes \
        -x509 \
        -subj "/C=US/ST=Denial/L=Springfield/O=Dis/CN=orlen.loc" \
        -keyout /etc/nginx/ssl/nginx.key \
        -out /etc/nginx/ssl/nginx.crt

# COPY VHOST DEFINTIONS
COPY conf.d/* /etc/nginx/templates/

# pass env variables to .conf files
COPY run-nginx.sh /bin/run-nginx.sh
