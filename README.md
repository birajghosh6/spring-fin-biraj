## Backend Laravel

This is the backend of the demo project and contains the endpoints that 
frontend uses to call to render content.

In order to set it up:

* Install [XAMPP](https://www.apachefriends.org/download.html)
* Set MySQL port to 3307
* Run Apache and MySQL
* Open your PHPMyAdmin and create a database called `spring_fin`
* In your php.ini file uncomment the line `extension=zip` by removing the
`;` in front of it.

In order to start the backend run these:
```
php artisan migrate # creates the required database tables
php artisan serve
php artisan queue:work  # for downloading the QR codes
php artisan schedule:work # for adding to the winners table
```

The .env values are:

```
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=spring_fin
DB_USERNAME=root
DB_PASSWORD=
QUEUE_CONNECTION=database

SPRING_API_KEY=mU1FEZdTaKtesL54mr1fXTEAKjDNR8rxib4FwKLMhl0ZPjclwAva96QThGn6WRmA
FRONTEND_DOMAIN=http://localhost:3000
```

The endpoints are:

- **GET** */players*

    QueryParams: `"SortBy"` ('points', 'name') | `"Order"` ('ASC', 'DESC')

    This fetches the list of players

- **PUT** */player/{playersId}*
    
    QueryParams: `"IncrementPoint"` (true, false) | `"DecrementPoint"` (true, false)

    This updated the player score to increase by 1 or decrease by 1. Cannot decrease score below 0.

- **DELETE** */player/{playersId}*

    This deletes the player in the path param.

- **POST** */player*

    Body: `"Name"` | `"Age"` | `"Address"`

    This adds a new player that starts with 0 points.

- **GET** */point-groups*

    This returns a json of keys as points and values as names in array and average ages.

### Authentication

Authorization for endpoints is handled by the `X-API-Key` header where the API Key(mentioned in environment 
variables section) is passed.
