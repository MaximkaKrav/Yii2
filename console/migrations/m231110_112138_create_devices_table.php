<?php

use yii\db\Expression;
use yii\db\Migration;

class m231110_112138_create_devices_table extends Migration
{
    /**
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $this->createTable('store', [
            'id' => $this->primaryKey(),
            'name_store'=>$this->string(50)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ]);

        $this->createTable('device', [
            'id' => $this->primaryKey(),
            'serial_number' => $this->string()->unique()->notNull(),
            'store_id' => $this->integer(),
            'about' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ]);

        $this->createIndex('idx-device-store_id', 'device', 'store_id');
        $this->addForeignKey('fk_device_store', 'device', 'store_id', 'store', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
        ]);

        $security = new \yii\base\Security();
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password_hash' => $security->generatePasswordHash('test'),
            'status' => 10,
        ]);
        $this->insert('store', [
            'id' => '1',
            'name_store'=>'Number1'
        ]);
        $this->insert('store', [
            'id' => '2',
            'name_store'=>'Number2'

        ]);
        $this->insert('store', [
            'id' => '3',
            'name_store'=>'Number3'

        ]);



        $this->insert('device', [
            'serial_number' => '111111111111',
            'store_id' => 1,
            'about' => 'ddddddddddddd',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_device_store', 'device');
        $this->dropTable('device');
        $this->dropTable('store');
        $this->dropTable('{{%user}}');
    }

}