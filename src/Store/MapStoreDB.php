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
namespace MapStore\Store;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;

/**
 * MapStoreDB class
 */
class MapStoreDB
{
    private $default_options = [
        'encrypt' => true,
        'key' => null,
        'salt' => null
    ];

    private $store_id = null;
    private $model = null;

    /**
     * MapStore constructor
     *
     * @param string $storeId the store ID
     * @param array  $options an array of options
     *
     * @throws \Cake\Core\Exception\Exception for invalid characters
     */
    public function __construct($storeId, array $options = [])
    {
        if (! preg_match('/^[\w-]+$/', $storeId)) {
            throw new Exception('Invalid characters in store ID');
        }
        $this->options = array_merge($this->default_options, $options);
        $this->store_id = $storeId;

        $this->model = TableRegistry::get('MapStore.MapStores');

        if ($this->options['encrypt']) {
            if (!$this->options['salt']) {
                $this->options['salt'] = Configure::read('App.Security.salt');
            }

            if (!$this->options['key']) {
                $this->options['key'] = Configure::read('App.Security.key');
            }
        }
    }

    /**
     * Get a key from the database
     *
     * @param string $key the key
     *
     * @return mixed the data
     */
    public function get($key)
    {
        $value = false;
        $conditions = [
            'store_id' => $this->store_id,
            'key' => $key
        ];
        
        $store = $this->model
            ->find()
            ->where($conditions)
            ->first();

        if ($store) {
            $value = $store->value;
            if (is_resource($value)) {
                $value = stream_get_contents($value);
            }

            if ($this->options['encrypt']) {
                $value = $this->_decrypt($value);
            }
        }

        return $value;
    }

    /**
     * Set a key to store in the database
     *
     * @param string $key  the key
     * @param mixed  $value the data to store
     *
     * @return bool successful set
     */
    public function set($key, $value)
    {
        $success = false;

        $entity = $this->model->newEntity();

        if ($this->options['encrypt']) {
            $value = $this->_encrypt($value);
        }

        $entity->set('store_id', $this->store_id);
        $entity->set('key', $key);
        $entity->set('value', $value);

        if ($this->model->save($entity)) {
            $success = true;
        }

        return $success;
    }

    /**
     * Delete a key from the database
     *
     * @param string $key the key
     *
     * @return bool successful delete
     */
    public function delete($key)
    {
        $success = false;
        if ($this->get($key) !== false) {
            $entity = $this->model->get([$this->store_id, $key]);
            if ($this->model->delete($entity)) {
                $success = true;
            }
        }
        return $success;
    }

    /**
     * Flush the database
     *
     * @return bool successful flush
     */
    public function flush()
    {
        if ($this->model->deleteAll(['store_id' => $this->store_id])) {
            return true;
        }
        return false;
    }

    /**
     * Encrypt a value
     *
     * @param type $value Value to be encrypted
     * @return type Encrypted value
     */
    protected function _encrypt($value)
    {
        return Security::encrypt($value, $this->options['key'], $this->options['salt']);
    }

    /**
     * Decrypt an encrypted value
     *
     * @param type $encryptedValue Value to be decrypted
     * @return type Decrypted value
     */
    protected function _decrypt($encryptedValue)
    {
        return Security::decrypt($encryptedValue, $this->options['key'], $this->options['salt']);
    }
}
