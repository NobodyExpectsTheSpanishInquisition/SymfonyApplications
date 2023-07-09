echo "---------- COPY ENV ----------"
cp .env.example .env

echo "------ BUILD CONTAINERS ------"
docker compose up --build -d

echo "------ BUILD FINISHED -------"
echo "----- CONTAINERS STATES -----"
docker ps

