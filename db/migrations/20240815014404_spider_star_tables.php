<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class SpiderStarTables extends AbstractMigration
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
        $table = $this->table('spider_stars', ['comment' => '明星百科']);
        $table
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('lemma_id', 'integer', ['length' => MysqlAdapter::INT_BIG, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('name', 'string', ['length' => 10, 'null' => false, 'comment' => '姓名'])
            ->addColumn('sex', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '性别'])
            ->addColumn('birthday', 'date', ['comment' => '生日', 'default' => null])
            ->addColumn('real_name', 'string', ['length' => 10, 'null' => false, 'default' => '', 'comment' => '本名'])
            ->addColumn('ethnicity', 'string', ['length' => 10, 'null' => false, 'default' => '', 'comment' => '民族'])
            ->addColumn('nationality', 'string', ['length' => 10, 'null' => false, 'default' => '', 'comment' => '国籍'])
            ->addColumn('birthplace', 'string', ['length' => 20, 'null' => false, 'default' => '', 'comment' => '出生地'])
            ->addColumn('graduated_from', 'string', ['length' => 30, 'null' => false, 'default' => '', 'comment' => '毕业学校'])
            ->addColumn('zodiac', 'string', ['length' => 10, 'null' => false, 'default' => '', 'comment' => '星座'])
            ->addColumn('chinese_zodiac', 'string', ['length' => 10, 'null' => false, 'default' => '', 'comment' => '生肖'])
            ->addColumn('blood', 'string', ['length' => 10, 'null' => false, 'default' => '', 'comment' => '血型'])
            ->addColumn('height', 'string', ['length' => 10, 'null' => false, 'default' => '', 'comment' => '身高'])
            ->addColumn('weight', 'string', ['length' => 10, 'null' => false, 'default' => '', 'comment' => '体重'])
            ->addColumn('occupation', 'string', ['length' => 150, 'null' => false, 'default' => '', 'comment' => '职业'])
            ->addColumn('agency', 'string', ['length' => 30, 'null' => false, 'default' => '', 'comment' => '经纪公司'])
            ->addColumn('major_works', 'string', ['length' => 1000, 'null' => false, 'default' => '', 'comment' => '代表作品'])
            ->addColumn('intro', 'text', ['comment' => '个人简介'])
            ->addColumn('award_records', 'text', ['comment' => '获奖记录'])
            ->addColumn('social_activities', 'text', ['comment' => '社会活动'])
            ->addColumn('commercial_activities', 'text', ['comment' => '商业活动'])
            ->addColumn('lemma_data', 'text', ['comment' => '百科数据'])
            ->addColumn('status', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('next_scan_at', 'timestamp', ['comment' => '下次扫描时间'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('lemma_id', ['name' => 'lemma_id'])
            ->addIndex('star_id', ['name' => 'star_id', 'unique' => true])
            ->addIndex('name', ['name' => 'name'])
            ->addIndex('next_scan_at', ['name' => 'next_scan_at'])
            ->create();

        $table = $this->table('spider_works', ['comment' => '作品百科']);
        $table
            ->addColumn('lemma_id', 'integer', ['length' => MysqlAdapter::INT_BIG, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('classify', 'string', ['length' => 20, 'null' => false, 'default' => '', 'comment' => '类型'])
            ->addColumn('name', 'string', ['length' => 30, 'null' => false, 'comment' => '作品名称'])
            ->addColumn('url', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '作品地址'])
            ->addColumn('cover', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '作品封面'])
            ->addColumn('desc', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '作品描述'])
            ->addColumn('foreign_name', 'string', ['length' => 50, 'null' => false, 'default' => '', 'comment' => '英文名'])
            ->addColumn('alternate_name', 'string', ['length' => 50, 'null' => false, 'default' => '', 'comment' => '别名'])
            ->addColumn('type', 'string', ['length' => 50, 'null' => false, 'default' => '', 'comment' => '作品类型'])
            ->addColumn('director', 'string', ['length' => 100, 'null' => false, 'default' => '', 'comment' => '导演'])
            ->addColumn('scriptwriter', 'string', ['length' => 100, 'null' => false, 'default' => '', 'comment' => '编剧'])
            ->addColumn('producer', 'string', ['length' => 100, 'null' => false, 'default' => '', 'comment' => '制片人'])
            ->addColumn('starring', 'string', ['length' => 100, 'null' => false, 'default' => '', 'comment' => '主演'])
            ->addColumn('running_time', 'integer', ['length' => MysqlAdapter::INT_SMALL, 'null' => false, 'default' => 0, 'comment' => '时长（分钟）'])
            ->addColumn('episodes', 'integer', ['length' => MysqlAdapter::INT_SMALL, 'null' => false, 'default' => 0, 'comment' => '集数'])
            ->addColumn('producer_region', 'string', ['length' => 50, 'null' => false, 'default' => '', 'comment' => '拍摄地区'])
            ->addColumn('playing_platform', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '网络播放平台'])
            ->addColumn('original_channel', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '首播电视台'])
            ->addColumn('album', 'string', ['length' => 50, 'null' => false, 'default' => '', 'comment' => '所属专辑'])
            ->addColumn('shooting_date', 'date', ['default' => null, 'comment' => '拍摄日期'])
            ->addColumn('finishing_date', 'date', ['default' => null, 'comment' => '杀青日期'])
            ->addColumn('release_date', 'date', ['default' => null, 'comment' => '上映/发行日期'])
            ->addColumn('awards', 'text', ['comment' => '获奖记录'])
            ->addColumn('intro', 'text', ['comment' => '简介'])
            ->addColumn('lemma_data', 'text', ['comment' => '百科数据'])
            ->addColumn('status', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('lemma_id', ['name' => 'lemma_id'])
            ->addIndex(['name', 'classify'], ['name' => 'name_classify'])
            ->create();

        $table = $this->table('spider_star_works', ['comment' => '明星作品']);
        $table
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('work_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '作品ID'])
            ->addColumn('created_at', 'timestamp')
            ->addIndex('star_id', ['name' => 'star_id'])
            ->addIndex('work_id', ['name' => 'work_id'])
            ->create();

        $table = $this->table('spider_star_events', ['comment' => '明星事件']);
        $table
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('classify', 'string', ['length' => 30, 'null' => false, 'comment' => '事件分类'])
            ->addColumn('type', 'string', ['length' => 30, 'null' => false, 'comment' => '事件类型'])
            ->addColumn('name', 'string', ['length' => 50, 'null' => false, 'default' => '', 'comment' => '事件名称 作品名称、获奖名称'])
            ->addColumn('desc', 'string', ['length' => 50, 'null' => false, 'default' => '', 'comment' => '事件描述，如主演，嘉宾，获奖结果等'])
            ->addColumn('work_id', 'integer', ['null' => false, 'signed' => false, 'default' => '0', 'comment' => '作品ID'])
            ->addColumn('work_name', 'string', ['length' => 50, 'null' => false, 'default' => '', 'comment' => '作品名称'])
            ->addColumn('work_play', 'string', ['length' => 10, 'null' => false, 'default' => '', 'comment' => '饰演'])
            ->addColumn('date', 'date', ['default' => null, 'comment' => '时间'])
            ->addColumn('status', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('star_id', ['name' => 'star_id'])
            ->addIndex('status', ['name' => 'status'])
            ->create();
    }
}
