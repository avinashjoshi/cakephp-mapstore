# MapStore

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)
[![Build Status](https://travis-ci.org/avinashjoshi/cakephp-mapstore.svg?branch=master)](https://travis-ci.org/avinashjoshi/cakephp-mapstore)
[![Coverage Status](https://coveralls.io/repos/avinashjoshi/cakephp-mapstore/badge.svg?branch=master&service=github)](https://coveralls.io/github/avinashjoshi/cakephp-mapstore?branch=master)

MapStore is a key-value store plugin for [CakePHP](http://cakephp.org) framework.

## Installation

The easiest & recommended way to install MapStore is via [composer](http://getcomposer.org). Run the following command:

```
composer require avinashjoshi/cakephp-mapstore
```

After that you should load the plugin in your app editing `config/bootstrap.php`:
```
Plugin::load('MapStore');
```

After loading the plugin you need to migrate the tables for the plugin using:
```
bin/cake migrations migrate -p MapStore
```

## Configuration
Configuration allows to specify if the value shoud be encrypted or not.

* **encrypt** (required/optional): Set to false if you would like to disable encryption (Default is `true`).
* **key** (required/optional): you can specify a key to be used by Security class to encrypt/decrypt value.
* **salt** (required/optional): you can specify a salt to be used by Security class to encrypt/decrypt value.

*key* and *salt* can also be set globally by adding them to CakePHP's application configuration at `app.php`:
```php
<?php
return [
    'Security' => [
        'salt' => 'some long & random salt',
        'key' => 'some long & random key'
    ]
];
```

You can grab a good pair of key and salt at [Random Key Generator](http://randomkeygen.com/).

## Basic Usage

```php
<?php
use MapStore\Store\MapStore;

$store = MapStore::load('store_1');

$store->set('name', 'Avinash Joshi');
$store->get('name'); // Returns 'Avinash Joshi'
$store->delete('name');
$store->flush();

```

## More Examples
```php
// Load the databases without database encryption
$store_2 = MapStore::load('store_2', ['encrypt' => false]);

```

## Support
Feel free to open an [issue](https://github.com/avinashjoshi/cakephp-mapstore) if you need help or have ideas to improve this plugin.

## Contributing
Contributions and Pull Requests are always more than welcome!

* Follow [CakePHP coding standard](http://book.cakephp.org/3.0/en/contributing/cakephp-coding-conventions.html).
* Please, add [Tests](http://book.cakephp.org/3.0/en/development/testing.html) to new features.
