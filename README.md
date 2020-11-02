# Stock notification
Notify the stock movements

## Run project with docker-compose in local
### build images
```shell script
     docker-compose -f local.yml build
```
### Up containers 
```shell script
    docker-compose -f local.yml up
```

### Use Composer 
```shell script
    docker-compose -f local.yml run --rm  app composer {command}
```

### Run tests 
```shell script
  docker-compose -f local.yml run --rm  app php artisan test
```
