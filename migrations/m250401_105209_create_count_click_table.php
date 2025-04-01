<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%count_click}}`.
 */
class m250401_105209_create_count_click_table extends Migration
{
    const TABLE_NAME = 'count_click';
    private string $table = '{{%' . self::TABLE_NAME . '}}';

    private string $tableCode = '{{%qr_code}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->string()->notNull()->unique()->comment('ID'),
            'idCode' => $this->string()->notNull()->comment('ID qr code'),
            'ipUser' => $this->binary()->notNull()->comment('IP пользователя'),
            'counter' => $this->bigInteger()->defaultValue(0)->comment('Счетчик переходов'),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()->notNull(),
        ], Yii::$app->params['tableOptions']);
        $this->createIndex(
            'idx-idCode-count_click-' . self::TABLE_NAME,
            $this->table,
            'idCode'
        );
        $this->addForeignKey(
            'fk-idCode-id-qr_code-' . self::TABLE_NAME,
            $this->table,
            'idCode',
            $this->tableCode,
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-idCode-' . self::TABLE_NAME, $this->table);
        $this->dropTable($this->table);
    }
}
