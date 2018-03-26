# Fox Framework

[![Version](https://img.shields.io/badge/version-1.2.1-red.svg)]()
[![PHP Version](https://img.shields.io/badge/PHP-7.1-red.svg)]()
[![CLI Version](https://img.shields.io/badge/CLI-OnDevelopment-blue.svg)]()
[![License](https://img.shields.io/badge/Licence-Apache--2.0-green.svg)]()

## About Fox Framework
**Fox Framework** is a **lightweight MVC PHP framework**, is as easy as powerful and it is the best choice for a short learning curve to develop really nice and strong products. Fox is designed to attack the most common problems in the project development process, implementing multiple design patterns both in development and architectural. **Fox is not a black box**, it is **easy to use**, **to understand** and **to modify** to fit the needs of your projects.

### Fox Framework features:

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
	|-- admin                        |=>| The Apanel is here
	|---- controllers                |=>| all the views logics are here 
	|---- public                     |=>| admin assets here
	|---- views                      |=>| all the admin views in folders with the controller name
	|---- index.php                  |=>| the magic one file you should leave alone.
	|-- bridges                      |=>| Place all your bridges here
	|-- bussinesLogic                |=>| All the project logic must be here
	|-- database                     |=>| if you want to store SQL files, well, store them here
	|-- factories                    |=>| Place all your abstract factories here
	|---- ModelFactory.php
	|-- Fox                          |=>| All the framework core is here
	|---- Core
	|---- Utils
	|---- Abstractions
	|---- FoxController.php
	|---- FoxModel.php
	|---- FoxServiceController.php
	|-- interfaces
	|---- IModelFactory.php
	|-- libs                         |=>| All your global (to project) libs must be here
	|-- models                       |=>| All your models here
	|-- public                       |=>| All your global (to project) assets be here
	|-- Services                     |=>| The REST services area
	|---- controllers                |=>| all the services logics are here 
	|---- public                     |=>| services assets here
	|---- index.php                  |=>| the magic one file you should leave alone.
	|---- WSD                        |=>| Services descriptors here
	|-- site                         |=>| The website demo
	|---- controllers                |=>| all the views logics are here 
	|---- public                     |=>| site assets here
	|---- views                      |=>| all the site views in folders with the controller name
	|---- index.php                  |=>| the magic one file you should leave alone.
	|-- tests                        |=>| The tests with codeception!
	|-- codeception.yml
	|-- config.php                   |=>| Database, encryption and gloabals are here
	|-- loader.php                   |=>| Autoload is managed here
	|-- mvcBootstrap.php             |=>| MVC magic starts here
	|-- restBootstrap.php            |=>| REST magic starts here
```

## FoxModel a swift ORM
Now FoxModel has been redisegned to be even more semantic featuring:

### Relation types
Our ORM currently supports 4 relation types:

#### One to One
This is the very basic relation you can define. For example, the `KonohaVillage` model have a current one `Hokage`; this can be define as this:

```php
	$konohaVillage->hasOne("CurrentHokage",$hokage);
```
where `CurrentHogage` is a relation rule defined at `KonohaVillage` class like this:

```php
class KonohaVillage extends \Fox\FoxModel {

    private $hasOne = array(
      'CurrentHokage'=>array(
          'class'=>'Hokage',
          'join_as'=>'id',
          'join_with'=>'village_id'
          )
      );
      
     public function getHasOne(){
     	return $this->hasOne;
     }

}
```
once you call for the relation to be done, don't forget to create your brand new object with its **one to one** relation: `$konohaVillage->create();`.

Remember, the One to One A.K.A hasOne **relation rule template** is this:

```php
private $hasOne = array(
	'RuleName'=>array(
		'class'=>'[Obj class expected]',
       'join_as'=>'[my primary key attr name]',
       'join_with'=>'[foreign key name in the other table]'
    )
);
```

#### Inverse One to One
So, if you want to define the inverse relation on the `Hokage` model, you can use `belongsTo` method:

```php
	$hokage->belongsTo("HokaguePositionAt",$konohaVillage);
```
where `HokaguePositionAt` is a relation rule defined at `Hokage` class like this:

```php
class Hokage extends \Fox\FoxModel {

    private $belongsTo = array(
        
            'HokaguePositionAt' => array(
                'class' => 'KonohaVillage',
                'join_as' => 'id',
                'join_with' => 'village_id'
            )
        
     );
      
     public function getBelongsTo(){
     	return $this->belongsTo;
     }

}
```
once you call for the relation to be done, don't forget to create your brand new object with its **one to one** relation: `$konohaVillage->create();`.

Remember, the Belongs to A.K.A belongsTo **relation rule template** is this:

```php
private $belongsTo = array(
   'Country' => array(
   		'class' => '[Obj class expected]',
       'join_as' => '[primary key name of the foreign key]',
       'join_with' => '[foreign key name in my table]'
	)
);
```

#### One to Many
Let's define a one to many relation between a `State` model and `City` model:

```php
	$state->hasMany("Cities",$city);
```
where "Cities" is a relation rule defined at `State` class like this:

```php
class State extends \Fox\FoxModel {

    private $hasMany = array(
      'Cities'=>array(
          'class'=>'City',
          'join_as'=>'id',
          'join_with'=>'state_id'
          )
        );
      
     public function getHasMany(){
     	return $this->hasMany;
     }

}
```
once you call for the relation to be done, don't forget to create your brand new object with its **one to one** relation: `$state->create();`.

Remember, the One to Many A.K.A hasMany **relation rule template** is this:

```php
private $belongsTo = array(

	'RuleName' => array(
   		'class' => '[Obj class expected]',
       'join_as' => '[primary key name of the foreign key]',
       'join_with' => '[foreign key name in my table]'
	)
);
```
#### Many to Many
Let's define a many to many relation between a `User` model and `Rol` model:

```php
	$user->belongsToMany("UserRols",$rol);
```
where "UserRols" is a relation rule defined at `User` class like this:

```php
class State extends \Fox\FoxModel {

    private $belongsToMany = array(
        'UserRols'=>array(
            'class'=>'Rol',
            'my_key'=>'id',
            'other_key'=>'id',
            'join_as'=>'user_id',
            'join_with'=>'rol_id',
            'join_table'=>'user_rols',
            'data'=> array(
               '[table attr]'=>'[variable type demo]' // 'aFloat' => 0.0, 'aString' => '' 
              )
            )
        );
      
     public function getBelongsToMany(){
     	return $this-> belongsToMany;
     }

}
```
once you call for the relation to be done, don't forget to update your object with its **many to many** relation: `$user->update();`.

Remember, the Many to Many A.K.A belongsToMany **relation rule template** is this:

```php
private $belongsToMany = array(
        'RuleName'=>array(
            'class'=>'[Obj class expected]',
            'my_key'=>'[my primary key attr]',
            'other_key'=>'[the other entity primary key attr]',
            'join_as'=>'[my attr at n to n table]',
            'join_with'=>'[the other attr at n to n table]',
            'join_table'=>'[N to N table name]',
            'data'=> array(
               '[table attr]'=>'[variable type demo]' // 'aFloat' => 0.0, 'aString' => '' 
              )
            )
        );
```

### Queriying Relations
Now you can query for your defined relations like this:

```php
	$cali = State::getBy("name","CALIFORNIA");
	$caliCities = $cali->has("many","Cities")); // 1st param could be "one" or "many", 2nd param is the defined rule name.
```
it will return all the California state cities at your database as an object array.

### Populating your objects
You can also populate your objects choosing by populate all its defined relations or just one of them like this:

```php
	$cali = State::getBy("name","CALIFORNIA");
	$cali->populate("many","Cities");
```
it will set a new attribute to the object called as the rule, in this case it will be called `cities`.

```php
	$cali = State::getBy("name","CALIFORNIA");
	$cali->populateAll();
```
it will look for all the relations rules defined and populate all adding attributes to the object called as the rule name.

## Learning Fox Framework
We are currently working on our brand new (and super lit) documentation by video tutorials and classic web documentation and tutorials, in fact all our current documentation is writed in spanish so we are translating it to support both English and Spanish langs.
