# CLSlim

For developers, CLSlim is an _opinionated_ PHP framework used to quickly create CRUD based RESTful APIs.

CLSlim is a marriage between [Slim 4](http://slimframework.com) and [Eloquent ORM](https://github.com/illuminate/database)
with [Robo](http://robo.li/) as your [wedding planner](https://en.wikipedia.org/wiki/Wedding_planner). 

CLSlim is _opinionated_ meaning that CLSlim stresses convention over configuration.

CLSlim works best as a framework in the following situation:
* You need to quickly spin up a [RESTful](https://restfulapi.net/) [datacentric](https://www.codecademy.com/articles/what-is-crud) API
* You already have defined your database with entities (tables/views) already in place
* You are just starting your project (for the backend API handler) and need to _hit the ground running_

### Requirements
* PHP 7.1+
* MySQL 5.6+ or SQLite3 (Postgres and MSSQL should also work but are untested)
* [Composer](https://getcomposer.org)

### Installation
From a terminal / command window run:

```
composer create-project clsystems/clslim [your-project-name]
cd [your-project-name]

// Linux / Mac users do this:
./clslim clslim:sample

// Windows execute this:
php -S localhost:8088 -t public
// Then in your favorite web browser go to: localhost:8088/v1/sample/hello-world
```

The result should look something like this:

```json
{
  "authenticated": true,
  "success": true,
  "status": 200,
  "data": {
    "id": "hello-world"
  },
  "missing": [ ],
  "message": "Sample test",
  "timestamp": 1556903905
}
```
