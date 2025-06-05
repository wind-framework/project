<?php



use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class InitTables extends AbstractMigration
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
        $this->admin();
        $this->attachment();
        $this->user();
        $this->star();
        $this->other();
    }

    protected function admin()
    {
        $table = $this->table('admins', ['comment' => '管理员表']);

        $table
            ->addColumn('username', 'string', ['length' => 50, 'null' => false, 'comment' => '用户名'])
            ->addColumn('real_name', 'string', ['length' => 30, 'null' => false, 'default' => '', 'comment' => '姓名'])
            ->addColumn('phone', 'string', ['length' => 20, 'null' => false, 'default' => '', 'comment' => '手机号码'])
            ->addColumn('avatar', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '头像'])
            ->addColumn('password', 'string', ['length' => 64, 'null' => false])
            ->addColumn('status', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('last_active_at', 'timestamp', ['comment' => '最后活跃时间'])
            ->addColumn('last_active_ip', 'string', ['length' => 15, 'null' => false, 'default' => '127.0.0.1'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('username', ['unique' => true, 'name' => 'uniq_username'])
            ->create();
    }

    protected function attachment()
    {
        $table = $this->table('attachment_files', ['comment' => '附件表']);

        $table
            ->addColumn('mime', 'string', ['length' => 50, 'null' => false, 'comment' => '媒体类型'])
            ->addColumn('sha1', 'string', ['length' => 40, 'null' => false, 'comment' => '文件加密值'])
            ->addColumn('path', 'string', ['length' => 255, 'null' => false, 'comment' => '文件路径'])
            ->addColumn('filename', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '文件名'])
            ->addColumn('filesize', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '文件大小'])
            ->addColumn('width', 'integer', ['length' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '图片宽度'])
            ->addColumn('height', 'integer', ['length' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '图片高度'])
            ->addColumn('created_at', 'timestamp')
            ->addIndex('sha1', ['unique' => true, 'name' => 'uniq_sha1'])
            ->addIndex('created_at', ['name' => 'created_at'])
            ->create();

        $table = $this->table('attachment_relations', ['comment' => '附件关联表']);

        $table
            ->addColumn('file_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '文件ID'])
            ->addColumn('target_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '目标ID'])
            ->addColumn('target_type', 'string', ['length' => 30, 'null' => false, 'signed' => false, 'comment' => '目标类型'])
            ->addColumn('created_at', 'timestamp')
            ->addIndex('file_id')
            ->addIndex(['target_id', 'target_type'], ['name' => 'target_id'])
            ->create();
    }

    protected function user()
    {
        $table = $this->table('users', ['comment' => '用户表']);
        $table
            ->addColumn('username', 'string', ['length' => 21, 'null' => false, 'comment' => '用户名'])
            ->addColumn('nickname', 'string', ['length' => 30, 'null' => false, 'comment' => '昵称'])
            ->addColumn('avatar', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '头像'])
            ->addColumn('iac', 'string', ['length' => 6, 'null' => false, 'default' => '86', 'comment' => '国际区号'])
            ->addColumn('phone', 'string', ['length' => 20, 'null' => false, 'comment' => '手机号码'])
            ->addColumn('email', 'string', ['length' => 50, 'null' => true, 'comment' => '邮箱地址'])
            ->addColumn('password', 'string', ['length' => 64, 'null' => false])
            ->addColumn('status', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 1])
            ->addColumn('last_logged_at', 'timestamp', ['comment' => '最后登录时间'])
            ->addColumn('last_logged_ip', 'string', ['length' => 15, 'null' => false, 'default' => '127.0.0.1'])
            ->addColumn('last_active_at', 'timestamp', ['comment' => '最后活跃时间'])
            ->addColumn('last_active_ip', 'string', ['length' => 15, 'null' => false, 'default' => '127.0.0.1'])
            ->addColumn('updated_username_at', 'timestamp', ['comment' => '更新用户名时间'])
            ->addColumn('created_at', 'timestamp', ['comment' => '注册时间'])
            ->addColumn('updated_at', 'timestamp')
            ->addColumn('deleted_at', 'timestamp')
            ->addIndex('username', ['unique' => true, 'name' => 'uniq_username'])
            ->addIndex(['phone', 'iac'], ['unique' => true, 'name' => 'uniq_phone'])
            ->addIndex('email', ['unique' => true, 'name' => 'uniq_email'])
            ->addIndex('last_active_at', ['name' => 'last_active_at'])
            ->addIndex('created_at', ['name' => 'created_at'])
            ->create();

        $this->execute(sprintf('ALTER TABLE `%s` AUTO_INCREMENT = 1000', 'users'));


        $table = $this->table('user_binds', ['comment' => '用户绑定关系表']);
        $table
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '用户ID'])
            ->addColumn('platform', 'string', ['length' => 20, 'null' => false, 'comment' => '应用平台'])
            ->addColumn('nickname', 'string', ['length' => 50, 'null' => false, 'default' => '', 'comment' => '昵称'])
            ->addColumn('avatar', 'string', ['length' => 255, 'null' => false, 'default' => '', 'comment' => '头像'])
            ->addColumn('open_id', 'string', ['length' => 40, 'null' => false, 'comment' => 'open_id'])
            ->addColumn('union_id', 'string', ['length' => 40, 'null' => false, 'default' => '', 'comment' => 'union_id'])
            ->addColumn('last_authorized_at', 'timestamp', ['comment' => '最后授权时间'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('user_id', ['name' => 'user_id'])
            ->addIndex(['open_id', 'platform'], ['unique' => true, 'name' => 'open_id'])
            ->addIndex(['union_id'], ['name' => 'union_id'])
            ->create();

        $table = $this->table('user_devices', ['comment' => '用户设备表']);
        $table
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '用户ID'])
            ->addColumn('device_id', 'string', ['length' => 32, 'null' => false, 'comment' => '设备ID'])
            ->addColumn('registration_id', 'string', ['length' => 32, 'null' => false, 'comment' => '推送平台的注册ID'])
            ->addColumn('push_count', 'integer', ['length' => MysqlAdapter::INT_SMALL, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '推送次数'])
            ->addColumn('push_lasted_at', 'timestamp', ['comment' => '最后一次推送时间'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('user_id', ['name' => 'user_id'])
            ->create();
    }

    public function star()
    {
        $table = $this->table('stars', ['comment' => '明星表']);
        $table
            ->addColumn('sid', 'string', ['length' => 21, 'null' => false, 'comment' => '对外ID'])
            ->addColumn('name', 'string', ['length' => 10, 'null' => false, 'comment' => '姓名'])
            ->addColumn('avatar', 'string', ['length' => 255, 'null' => false, 'comment' => '头像'])
            ->addColumn('sex', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'comment' => '性别'])
            ->addColumn('birthday', 'date', ['comment' => '生日'])
            ->addColumn('subscription', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '订阅人数'])
            ->addColumn('status', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 1])
            ->addColumn('last_post_at', 'timestamp', ['comment' => '最新动态时间'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('sid', ['unique' => true, 'name' => 'uniq_sid'])
            ->addIndex('name', ['name' => 'name'])
            ->create();

        $table = $this->table('star_social_accounts', ['comment' => '明星社交的平台账号']);
        $table
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '明星ID'])
            ->addColumn('platform', 'string', ['length' => 20, 'null' => false, 'comment' => '平台'])
            ->addColumn('platform_user_id', 'string', ['length' => 128, 'null' => false, 'comment' => '平台用户ID'])
            ->addColumn('platform_nickname', 'string', ['length' => 30, 'null' => false, 'comment' => '平台昵称'])
            ->addColumn('last_post_id', 'string', ['length' => 50, 'null' => false, 'comment' => '最后一条动态ID'])
            ->addColumn('last_post_at', 'timestamp', ['comment' => '最后一条动态发布时间'])
            ->addColumn('last_scan_at', 'timestamp', ['comment' => '上次扫码时间'])
            ->addColumn('next_scan_at', 'timestamp', ['comment' => '下次扫码时间'])
            ->addColumn('status', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 1])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('star_id', ['name' => 'star_id'])
            ->addIndex('next_scan_at', ['name' => 'next_scan_at'])
            ->create();


        $table = $this->table('star_subscriptions', ['comment' => '订阅']);
        $table
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '用户ID'])
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '明星ID'])
            ->addColumn('cover_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '封面ID'])
            ->addColumn('is_subscribe', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'comment' => '是否订阅'])
            ->addColumn('is_notice', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '是否通知'])
            ->addColumn('notice_count', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '通知次数'])
            ->addColumn('open_original_weibo', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '开启原创微博通知'])
            ->addColumn('open_relay_weibo', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '开启转发微博通知'])
            ->addColumn('open_xhs', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '开启小红书通知'])
            ->addColumn('open_dy', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '开启抖音通知'])
            ->addColumn('open_ks', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '开启快手通知'])
            ->addColumn('created_at', 'timestamp', ['comment' => '订阅时间'])
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('star_id', ['name' => 'star_id'])
            ->addIndex('user_id', ['name' => 'user_id'])
            ->addIndex('created_at', ['name' => 'created_at'])
            ->create();

        $table = $this->table('star_posts', ['comment' => '明星发布的动态']);
        $table
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '明星ID'])
            ->addColumn('social_account_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('platform', 'string', ['length' => 20, 'null' => false, 'comment' => '平台'])
            ->addColumn('post_id', 'string', ['length' => 50, 'null' => false, 'default' => '', 'comment' => '动态ID'])
            ->addColumn('post_type', 'string', ['length' => 10, 'null' => false, 'signed' => false, 'default' => 'text', 'comment' => '动态类型'])
            ->addColumn('send_type', 'string', ['length' => 10, 'null' => false, 'signed' => false, 'default' => 'send', 'comment' => '发送类型'])
            ->addColumn('content', 'text', ['comment' => '发布的内容'])
            ->addColumn('images', 'text', ['comment' => '发布的图片'])
            ->addColumn('video', 'text', ['comment' => '发布的视频'])
            ->addColumn('retweet', 'text', ['comment' => '转发的内容'])
            ->addColumn('send_at', 'timestamp', ['comment' => '动态发布时间'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('star_id', ['name' => 'star_id'])
            ->addIndex('post_id', ['name' => 'post_id'])
            ->addIndex('social_account_id', ['name' => 'social_account_id'])
            ->addIndex('send_at', ['name' => 'send_at'])
            ->addIndex('created_at', ['name' => 'created_at'])
            ->create();

        $table = $this->table('star_post_stats', ['comment' => '明星动态的统计']);
        $table
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '明星ID'])
            ->addColumn('social_account_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('platform', 'string', ['length' => 20, 'null' => false, 'comment' => '平台'])
            ->addColumn('day_at', 'date', ['null' => false, 'comment' => '日期'])
            ->addColumn('quantity', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0, 'comment' => '动态数量'])
            ->addColumn('hour_0', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0, 'comment' => '每小时动态数量'])
            ->addColumn('hour_1', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_2', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_3', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_4', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_5', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_6', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_7', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_8', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_9', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_10', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_11', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_12', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_13', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_14', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_15', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_16', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_17', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_18', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_19', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_20', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_21', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_22', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('hour_23', 'integer', ['null' => false, 'length' => MysqlAdapter::INT_SMALL, 'signed' => false, 'default' => 0])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('star_id', ['name' => 'star_id'])
            ->addIndex('social_account_id', ['name' => 'social_account_id'])
            ->addIndex('day_at', ['name' => 'day_at'])
            ->create();

        $table = $this->table('crawler_accounts', ['comment' => '爬虫账号']);
        $table
            ->addColumn('platform', 'string', ['length' => 20, 'null' => false, 'comment' => '平台'])
            ->addColumn('username', 'string', ['length' => 50, 'null' => false, 'comment' => '用户名称，区分平台账号'])
            ->addColumn('type', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 0, 'comment' => '类型'])
            ->addColumn('status', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 1])
            ->addColumn('access_token', 'string', ['length' => 50, 'null' => false, 'comment' => '授权令牌'])
            ->addColumn('cookies', 'text', ['comment' => 'cookies'])
            ->addColumn('parameters', 'text', ['comment' => '其他参数'])
            ->addColumn('authorize_at', 'timestamp', ['comment' => '账号授权时间'])
            ->addColumn('expired_at', 'timestamp', ['comment' => '账号有效期至'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->create();
    }

    protected function other()
    {
        $table = $this->table('covers', ['comment' => '封面']);
        $table
            ->addColumn('star_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '明星ID'])
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '用户ID'])
            ->addColumn('path', 'string', ['length' => 255, 'null' => false, 'comment' => '文件路径'])
            ->addColumn('status', 'integer', ['length' => MysqlAdapter::INT_TINY, 'null' => false, 'signed' => false, 'default' => 1])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('star_id', ['name' => 'star_id'])
            ->addIndex('user_id', ['name' => 'user_id'])
            ->create();

        $table = $this->table('statistics', ['comment' => '统计表']);
        $table
            ->addColumn('day_at', 'date', ['comment' => '日期'])
            ->addColumn('user_register', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '用户注册数量'])
            ->addColumn('star', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '明星数量'])
            ->addColumn('star_post', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '动态数量'])
            ->addColumn('star_subscription', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '订阅数量'])
            ->addColumn('chat_role', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '会话数量'])
            ->addColumn('chat_message', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '会话消息数量'])
            ->addColumn('parse_url', 'integer', ['null' => false, 'signed' => false, 'default' => 0, 'comment' => '图片解析数量'])
            ->addColumn('created_at', 'timestamp')
            ->addIndex('day_at', ['unique' => true, 'name' => 'uniq_day_at'])
            ->create();

        $table = $this->table('parse_urls', ['comment' => '解析链接表']);
        $table
            ->addColumn('url', 'string', ['length' => 255, 'null' => false, 'comment' => '链接地址'])
            ->addColumn('sha1', 'string', ['length' => 40, 'null' => false, 'comment' => '链接加密值'])
            ->addColumn('data', 'text', ['comment' => '解析的结果'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex('sha1', ['unique' => true, 'name' => 'uniq_sha1'])
            ->create();

        $table = $this->table('parse_records', ['comment' => '解析记录表']);
        $table
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '用户ID'])
            ->addColumn('url_id', 'integer', ['null' => false, 'signed' => false, 'comment' => '链接ID'])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp')
            ->addIndex(['user_id'], ['name' => 'user_id'])
            ->addIndex(['url_id'], ['name' => 'url_id'])
            ->addIndex(['created_at'], ['name' => 'created_at'])
            ->create();
    }
}
