### The Application will consist of a php front end with a node and postgresql backend

### POSTGRES CONTAINER -sql Database
- We create the script to run during container creation - docker-compose

```
mkdir db
touch db/Dockerfile
touch db/init.sql
```
### Inside init.sql
```
CREATE TABLE apparel(
    name character varying(50)
);

INSERT INTO apparel (name) VALUES ('Agbada'),
('Buba'),
('Ankara'),
('Lace');

```

### Next we add the db instruction to the dockerfile
- postgres base image
- copy the initialisation script to the default entry point postgres folder

```
FROM postgres

COPY ./init.sql /docker-entrypoint-initdb.d/
```
### run docker-compose up

```
docker-compose up
```
### This failed as superuser password wasn't specified.  We must specify -e POSTGRES_PASSWORD=PASSWORD on docker run or use the dangerous POSTGRES_HOST_AUTH_METHOD=trust to allow all connections

### Updated Dockerfile. It is set as an enviroment variable

```
FROM postgres

ENV POSTGRES_HOST_AUTH_METHOD=trust

COPY ./init.sql /docker-entrypoint-initdb.d/
```

```
docker-compose up
```




To see our inserted data inserted by our init script, we could connect to the container with the shell using the container id

```
docker container ls
```

### Then i'll connect to the container using the exec command

```
docker exec -it <container id> bash
```