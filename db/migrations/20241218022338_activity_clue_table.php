<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class ActivityClueTable extends AbstractMigration
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
        $table = $this->table('activity_clues', ['comment' => '事件线索']);

        $table
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '明星ID'])
            ->addColumn('user_id', 'integer', ['null' => false, 'default' => 0, 'comment' => '用户ID'])
            ->addColumn('status', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '状态 0 待采纳，1 已采纳，2 未采纳'])
            ->addColumn('describe', 'text', ['comment' => '描述'])
            ->addColumn('source', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '来源'])
            ->addColumn('source_image', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '来源截图'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('star_id', ['name' => 'idx_star_id'])
            ->addIndex('user_id', ['name' => 'idx_user_id'])
            ->addIndex('status', ['name' => 'idx_status'])
            ->addIndex('created_at', ['name' => 'idx_created_at'])
            ->create();
    }
}
