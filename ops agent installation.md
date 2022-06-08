**I. Создать сервисный аккаунт в Gooole Cloud и выдать ему права на исполнение мониторинга.**
  https://cloud.google.com/monitoring/agent/ops-agent/authorization
  
  1. Проверить свои области авторизации в Compute Engine, используя следующую команду:
  ``` 
  curl --silent --connect-timeout 1 -f -H "Metadata-Flavor: Google" http://169.254.169.254/computeMetadata/v1/instance/service-accounts/default/scopes
  ```
  2. Ищем в выходных данных одну или несколько из следующих областей авторизации:
  ```
  https://www.googleapis.com/auth/logging.write
  https://www.googleapis.com/auth/logging.admin
  https://www.googleapis.com/auth/monitoring.write
  https://www.googleapis.com/auth/monitoring.admin
  https://www.googleapis.com/auth/cloud-platform 
  ```
  3. Создаем сервисный аккаунт.

  * В нужном проекте (Webserver) выбираем создание аккаунта. 
  * В пункте Roles ищем и добавялем 2 роли:
    * Monitoring > Monitoring Metric Writer.
    * Logging > Logs Writer.
  * Выбрать создание ключа и скопировать его на сервер в директорию, в которой права доступа минимум 755. 
  ```
  Linux only: /etc/google/auth/application_default_credentials.json
  ```


**II. Привязать аккаунт к VM.**
1. В файле  /etc/systemd/system.conf  прописать след. строку: 
    ```
     DefaultEnvironment="GOOGLE_APPLICATION_CREDENTIALS=path_to_credentials_file"
    ```
2. Перезагрузить конфигуранию переменных и агенты на VM
    ```
     sudo systemctl daemon-reload
     sudo service google-cloud-ops-agent restart
    ```

**III. Выполнить установку OPS Agent.**
https://cloud.google.com/monitoring/agent/ops-agent/installation

1. Выполнить след. команты в директории, где есть достаточно прав доступа (или использовать sudo).
    ```
    curl -sSO https://dl.google.com/cloudagents/add-google-cloud-ops-agent-repo.sh
    sudo bash add-google-cloud-ops-agent-repo.sh --also-install
    ```
2. Проверить статус работы агента. Не должно быть ошибок.
  ```
  sudo systemctl status google-cloud-ops-agent"*"
  ```
_________________________________________

**Appendix. Полезные команды:**
```
 sudo systemctl daemon-reload
 sudo service google-cloud-ops-agent restart
 sudo systemctl status google-cloud-ops-agent"*"
```
