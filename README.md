### Чистка кеша
	redis-cli
	(flushdb - to clean)
	config set maxmemory 8gb
	config set maxmemory-policy volatile-lru
	exit

### Перезапуск редис
	/etc/init.d/redis-server stop
      ИЛИ
	sudo service redis-server stop
	redis-server

### Связка старый компосер+php7.4
	/usr/bin/php7.4 /usr/bin/composer 
	перед установкой модулей можно делать —dry-run для теста

### Новый компосер 
	 /usr/bin/composer.phar
    По умолчанию дергает php8.1.4

### ОБновление кора. Внимание на версию php
    /usr/bin/php7.4 /usr/bin/composer update drupal/core "drupal/core-*" --with-all-dependencies
    

### Change php default version
      sudo update-alternatives --config php
      Делать аккуратно. Могут перестать работы некоторые модули

### Пароли от БД лежат 
      в services.php
      mysql -h localhost -u root -p schmidt_db

### Сервисы twig модем подключить в Schmidt-new/we/sites/default/serives.yml. напр. Debug-mode=true

### Установка модулей принудительно 
	sudo composer require --no-update 'drupal/svg_embed:^2.0@beta'
	composer require 'drupal/svg_embed:^2.0@beta'
