<?php

use \bhubr\HashBack\Migration\Migration;

class CreateFilesMigration extends Migration
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
         $this->schema->create('files', function(Illuminate\Database\Schema\Blueprint $table){
            // Auto-increment id
            $table->increments('id');
            $table->string('name');
            $table->enum('type', ['F', 'D']);
            $table->timestamps();
        });
        $files = $this->table('files');
        $files->addColumn('parent_id', 'integer', array('null' => true));
        $files->addColumn('md5', 'string', array('limit' => 32))
            ->save();
    }

    public function down()
    {
        $this->schema->drop('files');
    }
}
