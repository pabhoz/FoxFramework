# Fox Framework

[![Version](https://img.shields.io/badge/version-1.1.0-red.svg)]()
[![PHP Version](https://img.shields.io/badge/PHP-7.1-red.svg)]()
[![CLI Version](https://img.shields.io/badge/CLI-On Development-blue.svg)]()
[![License](https://img.shields.io/badge/Licence-Apache--2.0-green.svg)]()

## About Fox Framework
**Fox Framework** is a **lightweight MVC PHP framework**, is as easy as powerful and it is the best choice for a short learning curve to develop really nice and strong products. Fox is designed to attack the most common problems in the project development process, implementing multiple design patterns both in development and architectural. **Fox is not a black box**, it is **easy to use**, **to understand** and **to modify** to fit the needs of your projects.

###Fox Framework features:

- **MVC pattern** to a better maintainibility.
- An easy to go configuration file to define DB info and security keys.
- **PDO integration** to support multiple DBE as MySQL, PostgreSQL, MariaDB, etc.
- **Fox Model**, the easy way **database ORM**.
- **RESTful** services support added by default at ``/services``
- An **Admin Panel** with [**AdminLTE**](https://adminlte.io/) integrated to the framework by default at ``/admin``
- A **sample site** by default with [**Twitter Bootstrap**](http://getbootstrap.com/2.3.2/) and [**JQuery**](https://jquery.com/) at ``/site``.
- A complete **test suite** integrated by using [**Codeception**](https://codeception.com/)
- **Clean URL's** based on .htaccess configurations.
- Easy data **encryptation** by the Hash class.
- A badass **CLI** to go even faster (Comming soon).
- A simple structure made with **<3**.

## A really fast overview

So a fast archetype review would be:

```
FoxFramework
	|-- admin --> The Apanel is here
	|---- controllers --> all the views logics are here 
	|---- public --> admin assets here
	|---- views --> all the admin views in folders with the controller name
	|---- index.php --> the magic one file you should leave alone.
	|-- bridges --> Place all your bridges here
	|-- bussinesLogic --> All the project logic must be here
	|-- database --> if you want to store SQL files, well, store them here
	|-- factories --> Place all your abstract factories here
	|---- ModelFactory.php
	|-- Fox --> All the framework core is here
	|---- Core
	|---- Utils
	|---- Abstractions
	|---- FoxController.php
	|---- FoxModel.php
	|---- FoxServiceController.php
	|-- interfaces
	|---- IModelFactory.php
	|-- libs --> All your global (to project) libs must be here
	|-- models --> All your models here
	|-- public --> All your global (to project) assets be here
	|-- Services --> The REST services area
	|---- controllers --> all the services logics are here 
	|---- public --> services assets here
	|---- index.php --> the magic one file you should leave alone.
	|---- WSD --> Services descriptors here
	|-- site --> The website demo
	|---- controllers --> all the views logics are here 
	|---- public --> site assets here
	|---- views --> all the site views in folders with the controller name
	|---- index.php --> the magic one file you should leave alone.
	|-- tests --> The tests with codeception!
	|-- codeception.yml
	|-- config.php --> Database, encryption and gloabals are here
	|-- loader.php --> Autoload is managed here
	|-- mvcBootstrap.php --> MVC magic starts here
	|-- restBootstrap.php --> REST magic starts here
```

## Learning Fox Framework
We are currently working on our brand new (and super lit) documentation by video tutorials and classic web documentation and tutorials, in fact all our current documentation is writed in spanish so we are translating it to support both English and Spanish langs.