<?php

use \bhubr\HashBack\Migration\Migration;

class AddHostIdToVolumesMigration extends Migration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $volumes = $this->table('volumes');
        $volumes->addColumn('host_id', 'integer')
            ->addForeignKey('host_id', 'hosts', 'id')
            ->save();
    }

    public function down()
    {
        $volumes = $this->table('volumes');
        $volumes->dropColumn('host_id');
    }
}
