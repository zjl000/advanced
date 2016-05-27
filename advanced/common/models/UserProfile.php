<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property string $id
 * @property string $user_id
 * @property string $avatar
 * @property string $first_name
 * @property string $last_name
 * @property string $nickname
 * @property integer $gender
 * @property string $birth_province
 * @property string $birth_city
 * @property string $birth_address
 * @property string $now_province
 * @property string $now_city
 * @property string $now_address
 * @property integer $is_dead
 * @property string $family_id
 * @property integer $birth_christian
 * @property integer $dead_christian
 * @property integer $birth_year
 * @property integer $birth_month
 * @property integer $birth_day
 * @property integer $dead_year
 * @property integer $dead_month
 * @property integer $dead_day
 * @property string $bloodtype
 * @property string $company
 * @property string $position
 * @property string $bio
 * @property string $motto
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'gender', 'birth_province', 'birth_city', 'now_province', 'now_city', 'is_dead', 'family_id', 'birth_christian', 'dead_christian', 'birth_year', 'birth_month', 'birth_day', 'dead_year', 'dead_month', 'dead_day'], 'integer'],
            [['gender', 'birth_province', 'birth_city', 'now_province', 'now_city', 'bloodtype', 'company', 'position', 'bio', 'motto'], 'required'],
            [['bio', 'motto'], 'string'],
            [['avatar', 'first_name', 'last_name', 'nickname'], 'string', 'max' => 50],
            [['birth_address', 'now_address', 'bloodtype', 'company', 'position'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'avatar' => 'Avatar',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'nickname' => 'Nickname',
            'gender' => 'Gender',
            'birth_province' => 'Birth Province',
            'birth_city' => 'Birth City',
            'birth_address' => 'Birth Address',
            'now_province' => 'Now Province',
            'now_city' => 'Now City',
            'now_address' => 'Now Address',
            'is_dead' => 'Is Dead',
            'family_id' => 'Family ID',
            'birth_christian' => 'Birth Christian',
            'dead_christian' => 'Dead Christian',
            'birth_year' => 'Birth Year',
            'birth_month' => 'Birth Month',
            'birth_day' => 'Birth Day',
            'dead_year' => 'Dead Year',
            'dead_month' => 'Dead Month',
            'dead_day' => 'Dead Day',
            'bloodtype' => 'Bloodtype',
            'company' => 'Company',
            'position' => 'Position',
            'bio' => 'Bio',
            'motto' => 'Motto',
        ];
    }
}
