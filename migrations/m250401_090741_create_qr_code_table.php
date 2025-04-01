<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%qr_code}}`.
 */
class m250401_090741_create_qr_code_table extends Migration
{
    const TABLE_NAME = 'qr_code';
    private string $table = '{{%' . self::TABLE_NAME . '}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->string()->notNull()->unique()->comment('ID'),
            'url' => $this->text()->notNull()->comment('Url'),
            'generalUrl' => $this->string()->notNull()->comment('Короткий url'),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()->notNull(),
        ], Yii::$app->params['tableOptions']);
        $this->createIndex(
            'idx-generalUrl-' . self::TABLE_NAME,
            $this->table,
            'generalUrl'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
