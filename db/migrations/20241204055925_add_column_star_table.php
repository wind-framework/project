<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddColumnStarTable extends AbstractMigration
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
        $table = $this->table('stars');

        $table
            ->addColumn('widget_avatar', 'string', ['length' => 255, 'null' => false, 'comment' => '挂件头像', 'after' => 'avatar'])
            ->addColumn('widget_background', 'string', ['length' => 255, 'null' => false, 'comment' => '挂件背景', 'after' => 'widget_avatar'])
            ->update();
    }
}
