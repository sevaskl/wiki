Инструкция как устанавливать патчи.

1. Сделать снепшот текущего состояния, на всякий случай.
2. Поместить файл патча в нужный модуль. | Если core -> web/, если commerce -> modules/contrib/commerce  etc. 
3. Проверить кодировку патча. Должно быть UTF-8 LF. Если она не совпадет, патч может не примениться.
4. Выполнить команду 
```
git apply -v patch_path.patch
```
