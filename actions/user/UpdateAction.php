<?php


namespace app\actions\user;


use app\models\Role;
use yii\base\InvalidValueException;
use yii\web\ServerErrorHttpException;

class UpdateAction extends \yii\rest\UpdateAction
{
    public function run($id)
    {
        $user = parent::run($id);
        $params = \Yii::$app->request->getBodyParams();

        if (isset($params['role'])) {
            $role = Role::findOne(['name' => $params['role']]);
            if (!$role) {
                throw new InvalidValueException('Incorrect user role ' . $params['role']);
            }
            $user->role_id = $role->id;
            $user->save(false);
        }

        return $user;
    }
}
