# Apache Kafka Laravel Example

## Setup

- Environment 
    - Copy `producer/.env.example` to `producer/.env`
    - Copy `consumer/.env.example` to `consumer/.env`
- Build and run containers
    - `docker-compose build`
    - `docker-compose up -d`
- Install vendors
    - Producer
        - `docker-compose exec producer bash`
        - `composer i`
    - Consumer
        - `docker-compose exec consumer_1 bash`
        - `composer i`

## Prepare

- Start sending messages
    - `docker-compose exec producer bash`
    - `php artisan messages:send`
- Set two partitions for two consumers
    - `docker-compose exec kafka bash`
    - `kafka-topics.sh --bootstrap-server kafka:9092 --alter --topic topic --partitions 2`


## Start example
- Make third splits:
    - First
        - `docker-compose exec consumer_1 bash`
        - `php artisan messages:listen`
    - Second
        - `docker-compose exec consumer_2 bash`
        - `php artisan messages:listen`
    - Third
        - `docker-compose exec producer bash`
        - `php artisan messages:send`

## Result

Producer send messages, each consumer read message, one by one.
