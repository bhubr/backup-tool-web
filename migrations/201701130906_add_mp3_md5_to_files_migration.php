<?php

use \bhubr\HashBack\Migration\Migration;

class AddMp3Md5ToFilesMigration extends Migration
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
        $files = $this->table('files');
        $files->addColumn('mp3_md5', 'string', array('limit' => 32, 'null' => true))
            ->save();
    }

    public function down()
    {
        $this->schema->drop('files');
        $files->dropColumn('mp3_md5');
    }
}
