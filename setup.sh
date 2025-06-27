# just to be sure that no traces left
docker-compose down -v

# building and running docker-compose file
docker-compose build && docker-compose up -d

# container id by image name
apache_container_id=$(docker ps -aqf "name=mp2go-php-apache")
db_container_id=$(docker ps -aqf "name=mp2go-mysql")

# checking connection
echo "Please wait... Waiting for MySQL connection..."
while ! docker exec ${db_container_id} mysql --user=root --password=root -e "SELECT 1" >/dev/null 2>&1; do
    sleep 1
done

# creating empty database for bagisto
echo "Creating empty database for bagisto..."
while ! docker exec ${db_container_id} mysql --user=root --password=root -e "CREATE DATABASE bagisto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" >/dev/null 2>&1; do
    sleep 1
done

# creating empty database for bagisto testing
echo "Creating empty database for bagisto testing..."
while ! docker exec ${db_container_id} mysql --user=root --password=root -e "CREATE DATABASE bagisto_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" >/dev/null 2>&1; do
    sleep 1
done

# installing composer dependencies inside container
docker exec -i ${apache_container_id} bash -c "cd mp2go && composer install --ignore-platform-reqs"

# moving `.env` file
docker cp .configs/.env ${apache_container_id}:/var/www/html/mp2go/.env
docker cp .configs/.env.testing ${apache_container_id}:/var/www/html/mp2go/.env.testing

# executing final commands
docker exec -i ${apache_container_id} bash -c "cd mp2go && php artisan optimize:clear && php artisan migrate:fresh --seed && php artisan storage:link && php artisan bagisto:publish --force && php artisan optimize:clear"

