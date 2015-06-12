<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class CreateUser extends Model {
    public $user_email;
    public $user_password;
    public $user_first_name;
    public $user_last_name;
    public $user_phone;
    public $confirmPassword;

    public function rules() {
        return [
            [['user_email', 'user_password', 'user_first_name', 'user_last_name', 'user_phone'], 'required'],
            ['user_email', 'email'],
            ['user_email', 'unique', 'targetClass' => '\app\models\User'],
            ['user_password', 'string', 'max' => 128],
            [['confirmPassword'], 'compare', 'compareAttribute'=>'user_password', 'operator'=>'==']
        ];
    }

    public function register(){
        if ($this->validate()) {
            try {
                $user = new User();
                $user->user_email = $this->user_email;
                $user->user_first_name = $this->user_first_name;
                $user->user_last_name = $this->user_last_name;
                $user->user_phone = $this->user_phone;
                $user->user_password = Yii::$app->security->generatePasswordHash($this->user_password);
                $user->record_status = 4;
                $user->save();
                $user->generateAuthKey();
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }
}
