FROM kyma/docker-nginx
COPY default /etc/nginx/sites-enabled/default
COPY src/ /var/www
CMD 'nginx'