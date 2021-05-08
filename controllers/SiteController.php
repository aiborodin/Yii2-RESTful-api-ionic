<?php

namespace app\controllers;

use app\models\Role;
use app\models\User;
use app\models\Status;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class SiteController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['POST', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ]
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'login' => ['POST', 'OPTIONS'],
                'signup' => ['POST', 'OPTIONS']
            ],
        ];

        return $behaviors;
    }

    public function actionSignup()
    {
        $user = new User();
        $postParams = Yii::$app->request->post();
        if(!isset($postParams['username'], $postParams['email'], $postParams['password'])) {
            Yii::$app->response->statusCode = Status::BAD_REQUEST;
            return [
                'message' => "To complete registration, please provide your username, password, and email.",
            ];
        }
        $user->username = $postParams['username'];
        $user->email = $postParams['email'];
        $user->setPassword($postParams['password']);
        $user->role_id = Role::findOne(['name' => $postParams['role']])->id;
        $user->createAccessToken();

        if ($user->save()) {
            Yii::$app->response->statusCode = Status::CREATED;
            return [
                'message' => 'You are successfully signed up.',
                'user' => $user,
            ];
        } else {
            Yii::$app->response->statusCode = Status::BAD_REQUEST;
            return [
                'message' => 'Error occurred while saving data!',
                'errors' => $user->getErrors()
            ];
        }
    }

    public function actionLogin()
    {
        $postParams = Yii::$app->request->post();
        if(!isset($postParams['username'], $postParams['password'])) {
            Yii::$app->response->statusCode = Status::BAD_REQUEST;
            return [
                'message' => "To login, please provide your correct username and password.",
            ];
        }
        $username = $postParams['username'];
        $user = User::findOne(['username' => $username]);
        if (!$user) {
            Yii::$app->response->statusCode = Status::NOT_FOUND;
            return [
                'message' => "User '$username' wasn't found!"
            ];
        }
        if ($user->validatePassword($postParams['password'])) {
            Yii::$app->response->statusCode = Status::OK;
            return $user;
        } else {
            Yii::$app->response->statusCode = Status::UNAUTHORIZED;
            return [
                'message' => 'Incorrect password was provided! Please, try again.'
            ];
        }
    }
}
