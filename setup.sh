echo "---------- COPY ENV ----------"
cp .env.example .env

echo "------ BUILD CONTAINERS ------"
docker compose up --build -d

echo "------- RUN MIGRATIONS ------"
echo "MODULE: users"
docker exec users bin/console d:m:m --no-interaction

echo "------ BUILD FINISHED -------"
echo "----- CONTAINERS STATES -----"
docker ps

