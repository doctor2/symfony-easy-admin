#!/bin/sh
GREEN='\033[0;32m'

echo "\n${GREEN}Prepare settings...${NC}"


docker-compose run -u1000 php-cli composer install

echo "\n${GREEN}DONE"

echo "Now run"
docker-compose up -d
echo "${NC}"

sudo chgrp -R www-data public/uploads
sudo chmod -R ug+rwx public/uploads

docker-compose exec php-cli php bin/console doctrine:migrations:migrate
docker-compose exec php-cli php bin/console doctrine:fixtures:load
