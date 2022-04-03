FROM nginx:mainline-alpine

RUN apk update --no-cache && \
  apk add --no-cache bash vim && \
  apk add --no-cache openssl

RUN mkdir /etc/certs && cd /etc/certs && \
  openssl genrsa -out server.key && \
  openssl req -new -key server.key -out server.csr -subj "/C=JP/CN=local.me0.info" && \
  openssl x509 -req -in server.csr -days 3650 -signkey server.key > server.crt

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/
