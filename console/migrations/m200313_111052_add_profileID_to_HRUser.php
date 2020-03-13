<?php

use yii\db\Migration;

/**
 * Class m200313_111052_add_profileID_to_HRUser
 */
class m200313_111052_add_profileID_to_HRUser extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%HRUser}}','profileID','string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('{{%HRUser}}','profileID');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200313_111052_add_profileID_to_HRUser cannot be reverted.\n";

        return false;
    }
    */
}
