<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CreateChatTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('chat_sessions', ['comment' => '会话表']);
        $table
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('type', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '类型 0:助理，1:马甲'])
            ->addColumn('name', 'string', ['length' => 20, 'null' => false, 'comment' => '名称'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('user_id', ['name' => 'user_id'])
            ->addIndex('star_id', ['name' => 'star_id'])
            ->addIndex('created_at', ['name' => 'created_at'])
            ->create();

        $table = $this->table('chat_messages', ['comment' => '会话消息表']);
        $table
            ->addColumn('session_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('type', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '类型 0:助手，1:用户'])
            ->addColumn('like', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '赞 0：无 1：赞 2：踩'])
            ->addColumn('content', 'text', ['comment' => '会话内容'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('user_id', ['name' => 'user_id'])
            ->addIndex('session_id', ['name' => 'session_id'])
            ->addIndex('created_at', ['name' => 'created_at'])
            ->create();
    }
}
