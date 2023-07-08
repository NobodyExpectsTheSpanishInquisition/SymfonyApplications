# README

## BUILD

### Containerization

**docker-compose.yaml** is entry point to build the every container. Inside are defined containers parameters.

e.g

```
services:
  app-1:
    env_file:
      - .env
    build:
      context: .
      dockerfile: Dockerfile.app1
      args:
        - IMAGE_TAG=${PHP_IMAGE_TAG}
    container_name: app-1
    volumes:
      - ./app1:/var/www/html:rw
```

Each service has his own **Dockerfile** named in convention Dockerfile.{service_name}

### Execution

Preferred way to build containers is to run **setup.sh** scripts. It will do all necessary operations to correctly
run containers. E.g update **.env** file, run docker-compose up etc. etc.  