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

```
db_1  | PostgreSQL init process complete; ready for start up.        
db_1  |
db_1  | 2022-10-30 08:51:52.657 UTC [1] LOG:  starting PostgreSQL 15.0 (Debian 15.0-1.pgdg110+1) on x86_64-pc-linux-gnu, compiled by gcc (Debian 10.2.1-6) 10.2.1 20210110, 64-bit
db_1  | 2022-10-30 08:51:52.658 UTC [1] LOG:  listening on IPv4 address "0.0.0.0", port 5432
db_1  | 2022-10-30 08:51:52.658 UTC [1] LOG:  listening on IPv6 address "::", port 5432
db_1  | 2022-10-30 08:51:52.708 UTC [1] LOG:  listening on Unix socket "/var/run/postgresql/.s.PGSQL.5432"
db_1  | 2022-10-30 08:51:52.795 UTC [63] LOG:  database system was shut down at 2022-10-30 08:51:52 UTC
db_1  | 2022-10-30 08:51:52.818 UTC [1] LOG:  database system is ready to accept connections
```


To see our inserted data inserted by our init script, we could connect to the container with the shell using the container id

```
docker container ls
```
```
PS C:\Users\deles\Documents\docker-custom-network-multi-container> docker container ls
CONTAINER ID   IMAGE                                      COMMAND                  CREATED         STATUS          PORTS      NAMES      
886ddbf3581e   docker-custom-network-multi-container_db   "docker-entrypoint.s…"   2 minutes ago   Up 22 seconds   5432/tcp   docker-custom-network-multi-container_db_1
```
### Then i'll connect to the container using the exec command

```
docker exec -it <container id> bash
```

### Now that we are in the container, we can execute our sql script using the psql command with ourdefault postgres user - postgres on our database also called postgres

```
psql -U postgres postgres
```

### This will now give us the postgres prompt and we can now interact with our database using sql

```
SELECT * from apparel;
```

```
PS C:\Users\deles\Documents\docker-custom-network-multi-container> docker exec -it 886ddbf3581e bash
root@886ddbf3581e:/# psql -U postgres postgres
psql (15.0 (Debian 15.0-1.pgdg110+1))
Type "help" for help.

postgres=# SELECT * FROM apparel;
  name     
--------   
 Agbada    
 Buba      
 Ankara    
 Lace      
(4 rows)   

postgres=# 
```

### Stoprunning container with Control + C
### Now we have our postgress container at the backend. We shall now set up other containers that can manipulate that data


### Let's create 2 more containers
Container 1: Node Express    Serve up Core container Data
Container 2: Flask Container  Additional items to core data - Enhances core data

### Create container to serve up core data
### Let's edit the docker-compose.yml file

### Create new service (node express) called apparel to get data from database from a /get endpoint

### Updated docker-compose.yml
```
version: "3"

services:
  db:
    build: ./db
 
  apparel:
    build: ./apparel

```
### We create a volume for instant updates and depends on the db service

```
version: "3"

services:
  db:
    build: ./db
 
  apparel:
    build: ./apparel

  volumes:
    - ./apparel:/app   
  depends_on  
    - db

```

### We shall create the apparel directory containing
```
    Dockerfile
    server.js
    package.json
```
