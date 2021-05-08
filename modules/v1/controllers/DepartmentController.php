<?php

namespace app\modules\v1\controllers;

use app\models\helpers\BehaviorsHelper;
use yii\rest\ActiveController;

class DepartmentController extends ActiveController
{
    public $modelClass = 'app\models\Department';

    public function behaviors()
    {
        return BehaviorsHelper::getBehaviors(parent::behaviors());
    }
}
