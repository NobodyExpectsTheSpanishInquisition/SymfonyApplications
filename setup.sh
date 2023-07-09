echo "---------- COPY ENV ----------"
cp .env.example .env

echo "------ BUILD CONTAINERS ------"
docker compose up --build -d

echo "------- RUN MIGRATIONS ------"
echo "MODULE: app-1"
docker exec app-1 bin/console d:m:m --no-interaction

echo "------ BUILD FINISHED -------"
echo "----- CONTAINERS STATES -----"
docker ps

