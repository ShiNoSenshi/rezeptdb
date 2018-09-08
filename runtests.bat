call composer install
set DATABASE_URL=mysql://root:@127.0.0.1:3306/rezeptdb_test
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
copy phpunit.xml.dist phpunit.xml
call vendor\bin\phpunit --configuration phpunit.xml --coverage-clover build/logs/clover.xml
pause