<?php

namespace app\models\helpers;

use Yii;
use yii\base\NotSupportedException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;

class BehaviorsHelper
 {
    public static function getBehaviors($behaviors){
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => ['X-Pagination-Total-Count', 'X-Pagination-Page-Count', 'Link'],
            ]
        ];

        $behaviors['authenticator'] = $auth;
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => self::getAuthMethods(),
        ];
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        if(Yii::$app->params['useRateLimiter']){
            $behaviors['rateLimiter']['enableRateLimitHeaders'] = false;
        }
        return $behaviors;
    }

     private static function getAuthMethods(): array
     {
         $authMethodsArray = null;
         if (Yii::$app->params['useHttpBasicAuth']) $authMethodsArray[] = HttpBasicAuth::class;
         if (Yii::$app->params['useHttpBearerAuth']) $authMethodsArray[] = HttpBearerAuth::class;
         if (Yii::$app->params['useQueryParamAuth']) $authMethodsArray[] = QueryParamAuth::class;
         if ($authMethodsArray == null)
             throw new NotSupportedException('You must choose at least one auth method, configure your app\config\params.php for more options.');
         return $authMethodsArray;
     }
 }
