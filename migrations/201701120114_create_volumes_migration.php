<?php

use \bhubr\HashBack\Migration\Migration;

class CreateVolumesMigration extends Migration
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
         $this->schema->create('volumes', function(Illuminate\Database\Schema\Blueprint $table){
            // Auto-increment id
            $table->increments('id');
            $table->string('name');
            $table->string('mount_point');
            $table->string('uuid');
        });
    }

    public function down()
    {
        $this->schema->drop('volumes');
    }
}
