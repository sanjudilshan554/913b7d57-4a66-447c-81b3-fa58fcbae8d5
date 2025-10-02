FROM php:8.2-cli

WORKDIR /app

# Install composer to docker environment
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies to docker environment
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

COPY . /app

RUN composer install

CMD ["bash"]
