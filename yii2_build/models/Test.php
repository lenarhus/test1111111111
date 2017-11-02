<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property integer $category
 * @property string $question
 * @property string $a1
 * @property string $a2
 * @property string $a3
 * @property string $a4
 * @property integer $answer
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'answer'], 'integer'],
            [['question'], 'string'],
            [['a1', 'a2', 'a3', 'a4'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'question' => 'Question',
            'a1' => 'A1',
            'a2' => 'A2',
            'a3' => 'A3',
            'a4' => 'A4',
            'answer' => 'Answer',
        ];
    }
}
