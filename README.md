# Working redis 
Working with redis cache

## Examples of the requests:
#### Cache calculating, POST:
```
curl --location --request POST 'localhost:7777/calculate' --header 'Content-Type: application/json' --data-raw '{
    "table_name": "stats_dep_a",
    "datetime": "2023-02-21T08:00",
    "data": {
        "id": "2",
        "price": "20.5" 
    }
}'
```

#### Query cache, GET:
```
curl --location -g --request GET 'http://localhost:7777/query?datamarts[]=stats_dep_a&date_time_from=2022-02-21T07:00&date_time_to=2022-02-21T12:00'
```
