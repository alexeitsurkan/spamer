<?php

use yii\db\Migration;

/**
 * Class m211125_193706_CreateTableCitatyTheme
 */
class m211125_193706_CreateTableCitatyTheme extends Migration
{

    public function safeUp()
    {
        $this->createTable(
            'citaty_theme',
            [
                'id'   => $this->primaryKey(),
                'name' => $this->text(),
            ]
        );

        $themes = Yii::$app->db->createCommand('SELECT distinct(theme) from citaty;')->queryAll();
        foreach ($themes as $item) {
            $this->insert(
                'citaty_theme',
                [
                    'name' => $item['theme']
                ]
            );
        }

        $array = Yii::$app->db->createCommand('select * from citaty_theme;')->queryAll();

        foreach ($array as $item) {
            $sql = "UPDATE citaty SET theme ='" . $item['id'] . "' WHERE theme='" . $item['name']."'";
            Yii::$app->db->createCommand($sql)->execute();
        }

        $this->execute("alter table citaty alter column theme type integer using theme::integer;");
        $this->renameColumn('citaty','theme','theme_id');

        $this->addForeignKey(
            'fk-citaty-theme_id',
            'citaty',
            'theme_id',
            'citaty_theme',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {

    }
}