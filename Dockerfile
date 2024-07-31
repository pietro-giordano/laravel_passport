# Usa PHP con Apache come immagine di base
FROM php:8.2-apache 

# Installa le dipendenze di sistema aggiuntive
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    curl \
    gnupg \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libxslt-dev \
    git \
    unzip

# Pulisci la cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Abilita il modulo mod_rewrite di Apache per la riscrittura degli URL
RUN a2enmod rewrite

# Installa le estensioni PHP necessarie
RUN docker-php-ext-install pdo_mysql zip gd intl xsl

# Configura DocumentRoot di Apache per puntare alla directory pubblica di Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Installa Node.js e npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# Imposta la directory di lavoro
WORKDIR /var/www/html

# Installa Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia i file di configurazione e il codice sorgente dell'applicazione
COPY . /var/www/html

# Installa le dipendenze PHP tramite Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Installa le dipendenze Node.js (se presente un file package.json)
RUN if [ -f package.json ]; then npm install; fi

# Esegui eventuali altre configurazioni necessarie 
RUN php artisan key:generate

# Espone la porta 80 per Apache
EXPOSE 80

# Avvia Apache
CMD ["apache2-foreground"]
