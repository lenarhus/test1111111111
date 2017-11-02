<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

use app\commands\Rbac;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll();

        // добавляем разрешение "viewBackend"
        $viewBackend = $auth->createPermission(Rbac::PERMISSION_BACKEND);
        $viewBackend->description = 'You can read about page this site';
        $auth->add($viewBackend);
        
        // добавляем разрешение "viewContact"
        $viewContact = $auth->createPermission(Rbac::PERMISSION_CONTACT);
        $viewContact->description = 'You can send feedback';
        $auth->add($viewContact);        

        // добавляем роль "demo" и 
        // для которой разрешено только разрешение "viewBackend"
        $demo = $auth->createRole('demo');
        $auth->add($demo);
        $auth->addChild($demo, $viewBackend);
        
        // добавляем роль "admin" и даём роли разрешение "viewContact"
        // а также все разрешения роли "demo"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $viewContact);
        $auth->addChild($admin, $demo);

        // Назначение ролей пользователям из app\models\User
        // 100 и 101 это IDs возвращаемые IdentityInterface::getId()
        $auth->assign($demo, 101);
        $auth->assign($admin, 100);
    }
}