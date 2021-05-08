<?php


namespace app\modules\v1\controllers;

use app\models\Employee;
use app\models\helpers\BehaviorsHelper;
use yii\rest\ActiveController;

class EmployeeController extends ActiveController
{
    public $modelClass = 'app\models\Employee';

    public function behaviors()
    {
        return BehaviorsHelper::getBehaviors(parent::behaviors());
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['dataFilter'] = [
            'class' => 'yii\data\ActiveDataFilter',
            'searchModel' => $this->modelClass
        ];
        return $actions;
    }

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['count'] = ['GET', 'OPTIONS'];
        return $verbs;
    }

    public function actionCount($dep_id)
    {
        return Employee::find()->where(['department_id' => $dep_id])->count();
    }
}
