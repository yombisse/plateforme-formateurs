# ============================================================
# ÉTAPE 1 : Compiler les assets Vite
# ============================================================
FROM node:24-bookworm-slim AS frontend

WORKDIR /app

# Copier les fichiers npm en premier pour profiter du cache Docker
COPY package.json package-lock.json ./

# Installer les dépendances
RUN npm ci

# Copier le reste du projet
COPY . .

# Compiler Vite
RUN npm run build


# ============================================================
# ÉTAPE 2 : Application Laravel
# ============================================================
FROM serversideup/php:8.4-fpm-nginx

WORKDIR /var/www/html

USER root

# ------------------------------------------------------------
# Installer les dépendances Composer
# ------------------------------------------------------------

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts


# ------------------------------------------------------------
# Copier l'application Laravel
# ------------------------------------------------------------

COPY --chown=www-data:www-data . .


# ------------------------------------------------------------
# Copier les assets Vite compilés
# ------------------------------------------------------------

COPY --from=frontend --chown=www-data:www-data \
    /app/public/build \
    ./public/build


# ------------------------------------------------------------
# Finaliser Composer après avoir copié Laravel
# ------------------------------------------------------------

RUN composer dump-autoload \
    --no-dev \
    --optimize


# ------------------------------------------------------------
# Permissions Laravel
# ------------------------------------------------------------

RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache


# ------------------------------------------------------------
# Configuration production
# ------------------------------------------------------------

ENV APP_ENV=production
ENV APP_DEBUG=false

# Racine publique Laravel
ENV NGINX_WEBROOT=/var/www/html/public

# Activer OPcache
ENV PHP_OPCACHE_ENABLE=1


# ------------------------------------------------------------
# Retour à l'utilisateur non privilégié
# ------------------------------------------------------------

USER www-data


# Render utilise le port HTTP 8080 avec cette image
EXPOSE 8080

CMD ["/init"]
