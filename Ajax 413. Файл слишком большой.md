Ошибка при поптыке загрузки файла на сайт. Размер превышен
[error] 744#744:  client intended to send too large body:

Проверить параметры:
 1. php.ini
 ```  
      ...
      post_max_size = 12M
      upload_max_filesize = 12M
  ```
 
 2. etc/nginx/nginx.conf 
 ```
      ...
      http{
        #Fix ajax error on upload file size
	       client_max_body_size 64M;
      }
  ```
  3. service nginx reload
  
* https://devanswers.co/nginx-error-client-intended-send-large-body/#:~:text=If%20you%20are%20trying%20to,client_max_body_size%20value%20is%20too%20low.&text=It%20may%20also%20be%20located,%2Fnginx%2Fconf%2Fnginx.
* https://stackoverflow.com/questions/7754133/php-post-max-size-overrides-upload-max-filesize
