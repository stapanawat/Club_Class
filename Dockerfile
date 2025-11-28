FROM serversideup/php:8.2-fpm-nginx

# Switch to root to install dependencies
USER root

# Install Node.js and NPM
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Copy project files
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install Node dependencies and build assets
RUN npm install && npm run build

# Set permissions
RUN chown -R webuser:webgroup /var/www/html

# Switch back to webuser
USER webuser
