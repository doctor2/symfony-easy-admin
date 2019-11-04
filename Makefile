#!/bin/sh
GREEN='\033[0;32m'

echo "\n${GREEN}Prepare settings...${NC}"


docker-compose run --rm --no-deps app composer install

echo "\n${GREEN}DONE"

echo "Now run"
docker-compose up -d
echo "${NC}"

docker-compose exec app php bin/console doctrine:migrations:migrate
docker-compose exec app php bin/console server:start
