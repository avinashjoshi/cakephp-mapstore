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
namespace MapStore\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MapStoresFixture
 *
 */
class MapStoresFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'store_id' => [
            'type' => 'string'
        ],
        'key' => [
            'type' => 'string'
        ],
        'value' => [
            'type' => 'binary'
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['store_id', 'key'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB', 'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'store_id' => '1',
            'key' => 'access_token',
            'value' => '123456'
        ],
    ];
}
