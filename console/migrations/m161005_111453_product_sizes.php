<?php

use yii\db\Migration;
use yii\db\Schema;

class m161005_111453_product_sizes extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_size}}', [
            'id' => Schema::TYPE_PK,
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'size_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'amount' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], $tableOptions);
        $this->createIndex('ps_product_id', '{{%product_size}}', 'product_id');
        $this->createIndex('ps_status', '{{%product_size}}', 'status');

        $this->createTable('{{%product_size_color}}', [
            'id' => Schema::TYPE_PK,
            'product_size_id' => Schema::TYPE_INTEGER,
            'color_id' => Schema::TYPE_INTEGER,
        ], $tableOptions);


    }

    public function down()
    {
        $this->dropTable('{{%product_size}}');
        $this->dropTable('{{%product_size_color}}');
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
