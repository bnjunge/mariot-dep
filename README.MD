## What is Mariot API?

Mariot API is an abstraction PHP collection for CRUD Operations. At my own free time, I decided to automate the common things I do especially CRUD on a PHP stack.

Mariot Helps with the heavy lifting of manually writing complex data structure queries to
create, fetch, update and delete operations in one or two lines.

example:
A query normally written as

```php

// prepare
$saveUser = $con->prepare("INSERT INTO users(username, password, email_verified_at, is_active, role) VALUES(:username, :password, :email_verified_at, :is_active, :role)");
// execute
$saveUser->execute(array(
    ':username' => 'jdoe@email.com',
    ':password' => password_hash('plainTextP@ssWord'),
    ':email_verified_at' => '2021-02-10',
    ':is_active' => 1
    ':role',  => 'admin'
));

// fetch affected rows
$saveCount = $con->rowCount();
```

In Mariot converts it to

```php
$saveUser = (new Accessor)->insert->insert_db(
    'users', // table
    array(
        'username' => 'jdoe@email.com',
        'password' => password_hash('plainTextP@ssWord'),
        'email_verified_at' => '2021-02-10',
        'is_active' => 1
        'role',  => 'admin'
    )
);

```

```$saveUser ``` will now contain an object of whether insert was successful and also resturn the data that was inserted(Inspired by MongoDB Ops)

## Create Tables
```php
$mariotApi = new Accessor;

/**
 * To create table 'users'
 *  please note that each table created will have three additional entries/columns i.e
 * id, created_at, updated_at
 */
$usersTable = new Migrator('users');
$usersTable->int('userid')->notNull()->increment()->isPrimary('userid');
$usersTable->string('username', 100)->notNull();
$usersTable->string('username', 100)->notNull();
$usersTable->string('password', 128)->notNull();
$usersTable->->string('role')->notNull()->default("user");
$usersTable>int('is_active')->notNull()->default(1);
$usersTable->create();

// finally create table
$create_table = $mariotApi->db->create_table($usersTable->sqlLang);

```


## Insert
```php
$mariotApi = new Accessor;

// insert
$insertResponse = $mariotApi->insert->insert_db(String table_name, Array data_array);
```

## Select
Select has many options and we will highlight two of them, ```select_all``` and ```select_all_but```

```select_all``` use it to get all te data that you want to on a given table

```select_all_but``` obtains data for a specified condition

```php
$mariotApi = new Accessor;

# select all Equivalent
$selectAll = $mariotApi->select->select_all(String table_name);

# eg
$selectAll = $mariotApi->select->select_all('users'); // will return all users

# select with condition
$selectWithCondition = $mariotApi->select->select_all_but(String table_name, Array associative_array_of_your_condition, String sqlCondition);

# eg
$selectWithCondition = $mariotApi->select->select_all_but('users', ['username' => 'jdoe@email.com'], 'WHERE username = :username'); // will return all users with username jdoe@email.com

