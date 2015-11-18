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
use Phinx\Migration\AbstractMigration;

class MapStoresInitial extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
     * public function change()
     * {
     * }
     */

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('map_stores', ['id' => false, 'primary_key' => ['store_id', 'key']]);
        $table
            ->addColumn('store_id', 'string')
            ->addColumn('key', 'string')
            ->addColumn('value', 'blob')
            ->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('map_stores');
    }
}
