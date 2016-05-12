# LiquidoORM
LiquidoORM is a simple object relational mapping which helps you query database easily with just a minimum amount of code.

## How to Install

```bash
composer require hidejec/liquido-orm "0.0.1"
```

then autoload in your project
```bash
require 'vendor/autoload.php';
```

## Configuration

Create a configuration file for your database and name it **dbconfig.liquido.php**

```bash

# File name: dbconfig.liquido.php

  <?php
  	define( "DB_DSN", "mysql:host=localhost;dbname=Database_Name" );
  	define( "DB_USERNAME", "Database_Username" );
  	define( "DB_PASSWORD", "Database_Password" );
 ?>
```
And save it inside your project root directory.

Intialize the LiquidoORM in your index.php

```bash
  new Liquido\App;
```

## Usage

Create a model and extend the LiquidoORM. For example a Customer Model

```bash

  #File: app/Model/Customer.php
  
  namespace Model;

  use Liquido\Model\LiquidoORM; #Requirement!

  class Customer extends LiquidoORM{ #Requirement!
  }
```

The Model automatically set the table with the plural name of the Model so you don't have to write again and again the table you want to run the query. 
> In our example, The table is set to `customers`. So be sure that you have a table named `customers` inside your database. 
> Another example: if you have a model class name ``Product``, the table will be set to `products` automatically. 

**Get all result and store it in a variable**

```bash
 $list = Customer::all();
```
Simple right ? :) 
It returns an array of results which you can manipulate using inside a loop.

###### Example if you are using a twig view

```bash
  {% for customer in list %}
		{{ customer.Email|e }}
		#or 
		{{ customer["Email"] }}
	{% endfor %}
```

**Get a single result passing a primary key ID**

```bash
  $customer = Customer::withId(1);
  
  echo $customer["Username"]; # Prints the username of the customer
```

**Get result with predefined conditions**

###### Example I will fetch all data with the first name "Jacob". To do this...

```bash
  $list = Customer::with([
			      'First_Name' => 'Jacob'
			    ]);
```

###### Fetching with multiple conditions

```bash
$list = Customer::with([
      			'Status'=> 'Single',
      			'First_Name' => 'Jacob',
      			'condition-type'=> 'AND'
			  ]);
```
>This will going to select all rows with a Status "Single" AND  First_Name "Jacob".

**_condition-type_** can be a
- AND
- &&
- OR
- ||

How about an OR inside a condition-type AND. 

**Example _Select all rows with a Status "Single" AND First_Name "Jacob" AND (Last_Name "Ramos" OR "Reyes")_ To do this...**

```bash
  $list = Customer::with([
        			'Status'=> 'Single',
        			'First_Name' => 'Jacob',
        			'Last_Name' => ['Ramos', 'Reyes'],
        			'condition-type'=> 'AND'
    			]);
```

The ` 'Last_Name' => ['Ramos', 'Reyes']` Automatically pertains to the conditional statement "OR". So in normal query it will be **WHERE Last_Name = 'Ramos' OR Last_Name = 'Reyes';**


I prefer the above method if your going the search for a data with a specified string. But what if your going to fetch the data with the id's less than 10.

**Get data for numerical conditions**

>Note that you can also use this similar to the above **_::with()_** but I prefer to use the liquid method **_::where()_** if you have a condition related to numbers since it's much easy to use. 

```bash
$list = Customer::where("id", "<", "10");
```

**How to Add/Insert a data**

```bash
$list = Customer::add([
    			'Username' => 'Jacob123',
    			'First_Name' => 'Jacob',
    			'Last_Name' => 'Ramos',
    			'Status' => 'Single',
    			'Email' => 'jacob123@yahoo.com'
			  ]);
```

You can pass any amount of columns depending on your needs. 

## Tip

_Optionally_ you can specify a column name to the queries. 
>The default was set to all. _SELECT * FROM table;_

To query to a specific column example the liquid method **_::withId()_**

```bash
$customer = Customer::withId(1, "Email"); # Single Column
$customer = Customer::withId(1, "Email, Username, First_Name"); # You can also specify multiple column names
```

Note that this is applicable to all **_LIQUID METHODS_** just add another argument prior to the required arguments of the liquid methods.









**NOTE THAT THIS IS A PRE_RELEASED!**

_Further improvements and functionalities will be released in the future builds. 
Thank you :)_



**Cheers,**

Hidejec - _Developer of Team Liquido_





