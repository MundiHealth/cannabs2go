# Use a imagem oficial do PHP
FROM php:8.1-apache

# Instale extensões necessárias do PHP e ferramentas de depuração
RUN docker-php-ext-install pdo pdo_mysql \
    && apt-get update \
    && apt-get install -y vim curl

# Habilite o módulo mod_rewrite do Apache
RUN a2enmod rewrite

# Copie o código do projeto para o diretório padrão do Apache
COPY . /var/www/html/

# Defina as permissões corretas para o diretório
RUN chown -R www-data:www-data /var/www/html

# Adicione configuração para permitir .htaccess
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/allow-override.conf \
    && a2enconf allow-override

# Exponha a porta 80
EXPOSE 80
