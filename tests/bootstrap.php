<?php
/**
 * MapStore - CakePHP Key Value Store
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Avinash Joshi
 * @link          http://github.com/avinashjoshi/cake-key-value-store
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

require_once 'vendor/autoload.php';

Configure::write('debug', true);

// Ensure default test connection is defined
if (!getenv('db_class')) {
    putenv('db_dsn=sqlite:///:memory:');
}

ConnectionManager::config('test', ['url' => getenv('db_dsn')]);
