<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class Widget extends AbstractMigration
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
        $this->activity();
        $this->activityTimeline();
        $this->activityClassify();
        $this->activityTimelineLike();
        $this->activityTimeLineComment();
        $this->star();
        $this->cover();
        $this->starSubscription();
    }

    protected function activity()
    {
        $table = $this->table('activities', ['comment' => '事件表']);

        $table
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '明星ID'])
            ->addColumn('classify_id', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '事件类型ID'])
            ->addColumn('user_id', 'integer', ['null' => false, 'default' => 0, 'comment' => '用户ID'])
            ->addColumn('name', 'string', ['length' => 20, 'null' => false, 'default' => '', 'comment' => '事件名称'])
            ->addColumn('status', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '状态 0 待审核，1 已审核'])
            ->addColumn('detail', 'json', ['comment' => '详情'])
            ->addColumn('source', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '来源'])
            ->addColumn('source_image', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '来源截图'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('star_id', ['name' => 'idx_star_id'])
            ->addIndex('classify_id', ['name' => 'idx_classify_id'])
            ->addIndex('user_id', ['name' => 'idx_user_id'])
            ->addIndex('name', ['name' => 'idx_name'])
            ->addIndex('status', ['name' => 'idx_status'])
            ->addIndex('created_at', ['name' => 'idx_created_at'])
            ->create();
    }

    protected function activityTimeline()
    {
        $table = $this->table('activity_timelines', ['comment' => '事件时间线表']);

        $table
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '明星ID'])
            ->addColumn('date', 'date', ['null' => false, 'comment' => '日期'])
            ->addColumn('activity_id', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '事件ID'])
            ->addColumn('classify_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '事件类型ID'])
            ->addColumn('timeline_type', 'string', ['length' => 20, 'null' => false, 'default' => '', 'comment' => '时间线类型'])
            ->addColumn('text', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '文案'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('star_id', ['name' => 'idx_star_id'])
            ->addIndex('date', ['name' => 'idx_date'])
            ->addIndex('activity_id', ['name' => 'idx_activity_id'])
            ->addIndex('created_at', ['name' => 'idx_created_at'])
            ->create();
    }

    protected function activityTimelineLike()
    {
        $table = $this->table('activity_timeline_likes', ['comment' => '事件时间线点赞表']);

        $table
            ->addColumn('timeline_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '时间线ID'])
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '用户ID'])
            ->addColumn('created_at', 'timestamp')
            ->addIndex('timeline_id', ['name' => 'idx_timeline_id'])
            ->addIndex('user_id', ['name' => 'idx_user_id'])
            ->create();
    }

    protected function activityTimeLineComment()
    {
        $table = $this->table('activity_timeline_comments', ['comment' => '事件时间线评论表']);

        $table
            ->addColumn('timeline_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '时间线ID'])
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '用户ID'])
            ->addColumn('type', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 1, 'comment' => '类型 1 评论，2 纠错'])
            ->addColumn('comment', 'string', ['length' => 500, 'null' => false, 'default' => '', 'comment' => '评论内容'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('timeline_id', ['name' => 'idx_timeline_id'])
            ->addIndex('user_id', ['name' => 'idx_user_id'])
            ->addIndex('type', ['name' => 'idx_type'])
            ->create();
    }

    protected function activityClassify()
    {
        $table = $this->table('activity_classifies', ['comment' => '事件类型表']);

        $table
            ->addColumn('name', 'string', ['length' => 20, 'null' => false, 'comment' => '名称'])
            ->addColumn('sort', 'integer', ['length' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '排序（数字越大越靠前）'])
            ->addColumn('template', 'json', ['comment' => '模板'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->create();
    }

    protected function star()
    {
        $table = $this->table('stars');

        $table->addColumn('intro', 'text', ['comment' => '简介'])
            ->addColumn('real_name', 'string', ['after' => 'intro', 'length' => 10, 'null' => false, 'default' => '', 'comment' => '本名'])
            ->addColumn('nation', 'string', ['after' => 'real_name', 'length' => 10, 'null' => false, 'default' => '', 'comment' => '民族'])
            ->addColumn('nationality', 'string', ['after' => 'nation', 'length' => 10, 'null' => false, 'default' => '', 'comment' => '国籍'])
            ->addColumn('birthplace', 'string', ['after' => 'nationality', 'length' => 20, 'null' => false, 'default' => '', 'comment' => '出生地'])
            ->addColumn('school', 'string', ['after' => 'birthplace', 'length' => 30, 'null' => false, 'default' => '', 'comment' => '毕业学校'])
            ->addColumn('constellation', 'string', ['after' => 'school', 'length' => 10, 'null' => false, 'default' => '', 'comment' => '星座'])
            ->addColumn('height', 'string', ['after' => 'constellation', 'length' => 10, 'null' => false, 'default' => '', 'comment' => '身高'])
            ->addColumn('weight', 'string', ['after' => 'height', 'length' => 10, 'null' => false, 'default' => '', 'comment' => '体重'])
            ->addColumn('blood', 'string', ['after' => 'weight', 'length' => 10, 'null' => false, 'default' => '', 'comment' => '血型'])
            ->addColumn('company', 'string', ['after' => 'blood', 'length' => 50, 'null' => false, 'default' => '', 'comment' => '经济公司'])
            ->addColumn('masterpiece', 'text', ['after' => 'company', 'comment' => '代表作品'])
            ->addColumn('career', 'string', ['after' => 'masterpiece', 'length' => 255, 'null' => false, 'default' => '', 'comment' => '职业'])
            ->addColumn('awards', 'text', ['after' => 'career', 'comment' => '所获奖项'])
            ->update();
    }

    protected function cover()
    {
        $table = $this->table('covers');

        $table
            ->addColumn('type', 'integer', ['after' => 'id', 'length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 1, 'comment' => '类型 1 首页，2 大事件'])
            ->update();
    }

    public function starSubscription()
    {
        $table = $this->table('star_subscriptions');

        $table
            ->addColumn('activity_cover_id', 'integer', ['after' => 'cover_id', 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '大事件封面ID'])
            ->update();
    }
}
