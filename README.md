# test-frigate.ru

Инструкция по установке.

Требования к ОС:
- Windows 10 pro,
- Ubuntu 20.04.

Требования к ПО:
- Docker-desktop latest version,
- 8гБ ОЗУ и более,
- Git bash.

Установка(для Windows):
Открыть git.exe

cd C:\path/projects

git clone https://github.com/DmiTryAgain/test-frigate.ru.git

Открыть от имени Администратора cmd.exe

cd C:\path/projects/test-frigate.ru/laradock

docker-compose build php-fpm nginx postgres

Дождаться установки.

docker-compose up -d php-fpm nginx postgres

Дождаться, пока поднимутся контейнеры.

docker-compose exec postgres bash

psql -U default -W

Ведите пароль (secret)

\c frigate

\q

exit

docker-compose exec workspace bash

cd app/

composer install

Ждём, пока установятся зависимости.

php yii migrate

yes

Далее открываем хост файл (C:\Windows\System32\drivers\etc)

и добавляем:

127.0.0.1 test-frigate.ru

Сохраняем, выходим. Открываем браузер, в URL вводим test-frigate.ru

Смотрим, пользуемся, тестируем
