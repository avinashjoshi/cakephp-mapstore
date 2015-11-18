<?php
/**
 * MapStore - CakePHP Key Value Store
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Avinash Joshi
 * @link          http://github.com/avinashjoshi/cakephp-mapstore
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace MapStore\Test\TestCase\Store;

use Cake\Core\Configure;
use Cake\Utility\Security;
use Cake\Core\Exception\Exception;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use MapStore\Store\MapStore;

class MapStoreTest extends TestCase
{

    public $fixtures = [
        'plugin.map_store.map_stores'
    ];

    public function setUp()
    {
        parent::setUp();
        
        Configure::write('Security.key', '2an`(oxsc7uVkfSZ}@xdf4ti;/F79`4=>2;d>A5OhRDCeo1_n0vc[nmf+&3RMy2');
        Configure::write('Security.salt', 'iU7s9~DQo1F4_u8Vr8VU3<H7#3H3"k5svJ0haqUC`HX16Gr#K2RO7yNj49F?=ve');

        $this->Store = MapStore::load('1');
        $this->Model = TableRegistry::get('MapStore.MapStores');
    }

    public function tearDown()
    {
        unset($this->Store);
        unset($this->Model);

        parent::tearDown();
    }

    public function testInstance()
    {
        $instance = MapStore::load('1');
        $this->assertInstanceOf('MapStore\Store\MapStoreDB', $instance);
    }

    public function testInstanceWithInvalidName()
    {
        try {
            $instance = MapStore::load('!invalidStoreName');
            
        } catch (Exception $e) {
            $this->assertEquals('Invalid characters in store ID', $e->getMessage());
        }
    }

    public function testExistingStoreValue()
    {
        $this->assertEquals(1, $this->Model->find()->count());
    }

    public function testValueIsAddedToDatabaseWithEncryption()
    {
        $value = '555';
        $store = MapStore::load('2');
        $store->set('access_token', $value);

        $entity = $this->Model->get(['2', 'access_token']);
        $dbValue = stream_get_contents($entity->value);
        $dbValueDecrypted = Security::decrypt($dbValue, Configure::read('Security.key'), Configure::read('Security.salt'));

        $this->assertNotEquals($value, $dbValue);
        $this->assertEquals($value, $dbValueDecrypted);
    }

    public function testValueIsAddedToDatabaseWithoutEncryption()
    {
        $value = '666';
        $store = MapStore::load('3', ['encrypt' => false]);
        $store->set('access_token', $value);

        $entity = $this->Model->get(['3', 'access_token']);
        $dbValue = stream_get_contents($entity->value);

        $this->assertEquals($value, $dbValue);
    }

    public function testDeleteExistingKey()
    {
        $store = MapStore::load('2');
        $store->set('access_token', 'something');
        $this->assertTrue($store->delete('access_token'));
        $this->assertFalse($store->get('access_token'));
    }

    public function testFlushStore()
    {
        $store1 = MapStore::load('1');
        $store1->set('access_token', '5555');

        $store2 = MapStore::load('2');
        $store2->set('access_token', '12345');
        $store2->set('refresh_token', '67890');
        $this->assertTrue($store2->flush());
        $this->assertFalse($store2->get('access_token'));
        $this->assertFalse($store2->get('refresh_token'));
        $this->assertFalse($store2->flush());

        $this->assertEquals('5555', $store1->get('access_token'));
    }

}
