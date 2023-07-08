cp .env.example .env
docker compose up --build -d

echo "------- BUILD FINISHED -------"
echo "----- CONTAINERS STATES -----"
docker ps

