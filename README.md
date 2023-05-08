# API Backend Coding Task

This is the technical test project for API oriented backends.

## Technical requirements

- [Docker](https://www.docker.com/)

## Build

```bash
make build
```

This command executes the Docker image building process and performs the [Composer](https://getcomposer.org) dependencies installation.

---

Type `make help` for more tasks present in `Makefile`.

## Functional requirements

**Implement a CRUD (Create-Read-Update-Delete) API.**

The following add-ons will be positively evaluated:

- Authentication
- Authorization
- Cache
- Documentation

---

A light infrastructure is provided with a populated MySQL database with example data and a web server using PHP built-in development server.

## Non functional requirements

- The presence of unit, integration and acceptance tests will positively appreciated.
- Use whatever you want to achieve this: MVC, hexagonal arquitecture, DDD, etc.
- A deep knowledge about SOLID, YAGNI or KISS would be positively evaluated.
- DevOps knowledge (GitHub Actions, Jenkins, etc.) would be appreciated too.
- It's important to find a balance between code quality and deadline; releasing a non functional application in time or a perfect application out of time may be negatively evaluated.
- Good and well-documented commits will be appreciated.
- Efficient and smart use of third party libraries will be positively appreciated.

---

Beyond the requirements of this test we want to see what you can do, feel free to show us your real potential and, the
most important part, have fun!

# The Solution

The following stack was used for the technical test:

* Slim 4
* Doctrine ORM
* JWT Tokens
* Symfony/cache
* Symfony/validator
* OpenAPI/swagger
* PHPUnit

The project consists of a simple API rest where a Hexagonal + DDD architecture has been used with the following layers:

### Infrastructure layer

In this layer I have put everything related to HTTP requests technical specifications, security layer and caching.

### Application layer

In this layer we have put the use cases of the application such as list, create, update, etc.

### Domain layer

This layer is where the heart of the business model and its entities and repositories are located, all in an agnostic way and communicating with the upper layers through interfaces as specified by the DI dependency inversion pattern.

### Bundled context

Two domain contexts have been created:

* Lotr
* Security

Lotr is where the API itself is stored with a relational model, while for the authentication layer it is stored in a domain that in principle should not be coupled to the API and has been kept in a different context.

Each context is separated by folders within `/src` where each has its own folder with corresponding layers:

* Application
* Domain
* Infrastructure

# Configuration of the application

For the configuration of the application we have used very simple .php files that contain an array with all the configuration according to their responsibilities. These files are two:

* settings.php: Default configuration
* settings_test.php: Configuration for test environment

This test file has been necessary because a database other than the development one has been used to load test data.

In addition, the application can easily have other environments, whose configuration files will be setting_{env}.php.

This way we can have different configurations per environment.

```php

		security' => [
            'jwt_secret' => '24985a4bcbc230e1b3389888b5427231',
            'jwt_issuer' => $_SERVER['SERVER_NAME'] ?? 'localhost',
            'jwt_expires_at' => 3600 //1 hour
        ],
        'slim' => [
            // Returns a detailed HTML page with error details and
            // a stack trace. Should be disabled in production.
            'displayErrorDetails' => true,

            // Whether to display errors on the internal PHP log or not.
            'logErrors' => true,

            // If true, display full errors with message and stack trace on the PHP log.
            // If false, display only "Slim Application Error" on the PHP log.
            // Doesn't do anything when 'logErrors' is false.
            'logErrorDetails' => true,
        ],

        'doctrine' => [
            // Enables or disables Doctrine metadata caching
            // for either performance or convenience during development.
            'dev_mode' => true,

            // Path where Doctrine will cache the processed metadata
            // when 'dev_mode' is false.
            'cache_dir' => APP_ROOT . '/var/doctrine',

            // List of paths where Doctrine will search for metadata.
            // Metadata can be either YML/XML files or PHP classes annotated
            // with comments or PHP8 attributes.
            'metadata_dirs' => [
                APP_ROOT . '/src/Lotr/Infrastructure/config/doctrine',
                APP_ROOT . '/src/Security/Infrastructure/config/doctrine',
            ],

            // The parameters Doctrine needs to connect to your database.
            // These parameters depend on the driver (for instance the 'pdo_sqlite' driver
            // needs a 'path' parameter and doesn't use most of the ones shown in this example).
            // Refer to the Doctrine documentation to see the full list
            // of valid parameters: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html
            'connection' => [
                'dsn' => 'mysql://root:root@db:3306/lotr?charset=utf8mb4',
            ]
        ],
        'validator' => [
            'paths' => [
                APP_ROOT . '/src/Lotr/Infrastructure/config/validator/validation.yaml',
                APP_ROOT . '/src/Security/Infrastructure/config/validator/validation.yaml'
            ]
        ],
        'cache' => [
            'filesystem_adapter' => [
                'namespace' => '',
                'default_life_time' => 3600,  //1 hour (time in seconds)
                'directory' => APP_ROOT.'/var/cache/dev'
            ]
        ]
```

The sections are:

* security
* slim
* doctrine
* validator
* cache

# Data fixtures

The project comes with a simple data load. For the tests we needed to use the `doctrine/data-fixtures` library to be able to load data into the database efficiently.

We have also added a bootstrap file that is started when running the tests in such a way that it deletes the previous data, regenerates the schema according to the model and loads some initial data with which to launch the tests. This ensures that the tests are always run in a controlled state.

# Tests PHPUnit

PHPunit has been used for testing. All API use cases have been tested. To launch the tests just run inside the container:

`$ vendor/bin/phpunit`.

To get inside the docker container:

`$ docker exec -it api-coding-task-php-1 sh`.

The tests are run on the **lotr_test** database. This database must exist (tables are generated automatically). This database is created when the doctrine container is raised using the **init_test.sql** file.


# Modelo de datos

The initial tables of the project have been mapped with doctrine via XML file. In this way we avoid having to couple the data model that is part of the domain with infrastructure, as indicated by the best practices with hexagonal architectures.

The mapping files are located in the *Infrastructure* / **config/doctrine** folders.

# Authentication

For authentication, two users have been created in a new entity called *User*. 

1. username: user@gmail.com / password: 1234
2. username: admin@gmail.com / password: 1234

These users are created automatically when the Docker container is lifted. The user starting with user can access the user profile.

API actions that do not mutate the database state, i.e. GET calls, do not require authentication and any anonymous user would have access.

All other POST, PUT, PATH and DELETE calls, only the user admin@gmail.com has access.

## Login

There is a `POST /users/login` call where the user credentials are sent via email and password in a JSON document in the body of the request.

If the login is successful, the response returns an authentication token.

To make requests with authentication, the following header must be set:

```
Authorization: Bearer {token}
```

# Cache

A cache has been added to improve the performance of the application. The cache has been implemented using the `symfony/cache` library and a file-based adaptor has been used.

The cache is stored by default in the `/var/cache/{env}` folder.

An interface has been used so that the adapter can be easily changed. This would make it very easy to use more sophisticated solutions such as redis or memcached in production environments.

When a non-GET request is made, the cache is automatically cleared only for the resource in question, keeping the cache for the rest of the API.

# Documentación

The OpenAPi standard has been used for the generation of the documentation. It can be seen in the following path:

**http://localhost:8080/docs**

In order to use swagger UI it can be installed via a Docker container:

```bash
docker pull swaggerapi/swagger-ui
docker run -p 9090:8080 -e SWAGGER_JSON_URL=http://localhost:8080/docs swaggerapi/swagger-ui
```

In the browser go to the following url:

**http://localhost:9090/**

Where we will have all the documentation and we can test it online.

We also have the file in the root of the project : **Freepik.postman_collection.json** where we have the collection to be used by Postman.
