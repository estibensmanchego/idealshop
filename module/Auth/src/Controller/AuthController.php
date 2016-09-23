<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Auth\Controller;

use User\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Auth\Form\AuthForm;
use User\Model\User;

class AuthController extends AbstractActionController
{

    public function loginAction()
    {      
        $this->layout('layout/auth');
    }

    public function logoutAction()
    {
        $this->layout('layout/auth');
    }

    public function registerAction()
    {
        $this->layout('layout/auth');  
    }

    public function recoveryAction()
    {
        $this->layout('layout/auth');      
    }
}
