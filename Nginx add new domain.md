1. Создать SSL сертификаты
```sudo certbot --nginx -d schmidt-and-schmidt.kz -d www.schmidt-and-schmidt.kz```
2. Сделать новый файл настроек по аналогии с остальными. /etc/nginx/sites-avaliable
3. Сделать ссылку на этот файл. 
``` ln -s /etc/nginx/sites-available/www.example.org /etc/nginx/sites-enabled/ ```
4. Прописать домен в настройках сайта. /var/www/html/schmidt-new/web/sites/default/settings.php
``` $config['language.negotiation']['url']['domains']['fr'] = 'schmidt-and-schmidt.kz'; ```
5. Проверка кода и перезапуск nginx. 
```
sudo nginx -t
service nginx reload```
