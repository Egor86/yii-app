<?php

use yii\db\Migration;
use yii\db\Schema;

class m161013_112714_comment_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%comment}}', [
            'id' => Schema::TYPE_PK,
            'product_id' => $this->integer(10)->notNull()->unsigned(),
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'agree' => $this->boolean()->notNull()->defaultValue('0'),
            'favorite' => $this->boolean()->notNull()->defaultValue('0'),
            'user_name' => Schema::TYPE_CHAR . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);
        $this->addForeignKey('fk_comment_product_id', '{{%comment}}','product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%comment}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
