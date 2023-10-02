# Sync Currency Rates

Simple API application for getting currency rates by dates.

Technology stack:

- PHP 8.2
- nginx
- Redis
- Docker
- Symfony Framework

## Install project

For using the project you have to use docker and docker composer.

To install all dependencies and run the project just call the following command:

```bash
docker compose up -d
```

Wait for the docker containers to be built and run.

You can override docker ports in `docker-compose.override.yaml` and override Symfony environments in `.env.local` file

## Get currency rates

You can use REST API endpoint for getting currency rates.

Endpoint to get currency rates is `/api/v1/currency/rate`.

Example of using the endpoint:
```
curl -i "http://localhost:8126/api/v1/currency/rate?date=2023-09-09&currency=USD"
```

You can change parameters:

- date (format Y-m-d)
- currency (currency code, eg: USD, EUR, BYN)
- base_currency (currency code)

## Console command for syncing currencies

Run the following command to register new job for the message broker:

```
docker exec -i centralbank-app bin/console app:fetch-currencies
```

By default, it will register a job for sync currencies on 180 days. You can change the period by "days" parameter. Example:

```
docker exec -i centralbank-app bin/console app:fetch-currencies --days=181
```

Of course this command you can run from the app container.
