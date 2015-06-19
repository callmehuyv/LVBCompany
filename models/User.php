<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $account
 * @property string $password
 * @property string $token_expire
 * @property integer $record_status
 *
 * @property Companies[] $companies
 * @property UserInfo[] $userInfos
 * @property UserRole[] $userRoles
 * @property Roles[] $roles
 * @property Vehicles[] $vehicles
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName(
)    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['user_email', 'user_password', 'user_first_name', 'user_last_name', 'user_phone'], 'required'],
            [['record_status', 'user_phone'], 'integer'],
            [['user_email', 'user_phone'], 'unique', 'targetClass' => '\app\models\User'],
            [['user_email', 'user_password', 'user_auth_key'], 'string', 'max' => 255],
            [['user_first_name', 'user_last_name'], 'string', 'max' => 32],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id'            => 'ID',
            'user_email'         => 'Account',
            'user_password'      => 'Password',
            'user_auth_key'      => 'Auth Key',
            'user_first_name'    => 'First Name',
            'user_last_name'     => 'Last Name',
            'user_phone'         => 'Phone',
            'record_status'      => 'Record Status',
        ];
    }

    public static function findIdentity($user_id)
    {
        return static::findOne(['user_id' => $user_id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['user_access_token' => $token]);
    }

    public static function findByEmail($user_email)
    {
        return static::findOne(['user_email' => $user_email]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->user_auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->user_password);
    }

    public function setPassword($password)
    {
        $this->user_password = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->user_auth_key = Yii::$app->security->generateRandomString();
    }

}
