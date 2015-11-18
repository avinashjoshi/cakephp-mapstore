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
namespace MapStore\Store;

/**
 * MapStore component
 */
class MapStore
{

    private static $instance = [];

    /**
     * Load the MapStore Database
     *
     * @param string $storeId the store name / id
     * @param string $options an array of options
     *
     * @return \MapStore\MapStoreDB class
     */
    public static function load($storeId, array $options = [])
    {
        return new MapStoreDB($storeId, $options);
    }

}
