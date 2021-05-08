<?php


namespace app\modules\v1\controllers;


use app\models\helpers\BehaviorsHelper;
use Yii;
use yii\web\ForbiddenHttpException;

class UserController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        return BehaviorsHelper::getBehaviors(parent::behaviors());
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['update']['class'] = 'app\actions\user\UpdateAction';
        return $actions;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if (Yii::$app->user->identity->role->name !== 'Admin') {
            throw new ForbiddenHttpException();
        }
    }
}

