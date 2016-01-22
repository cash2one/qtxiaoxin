<?php

class DefaultController extends Controller
{
    public function actionIndex()
    {
        // conlog(111);
        $this->render('index');
    }

    /**
     * 手机获取验证码
     */
    public function actionSetcode()
    {
        $mobile = Yii::app()->request->getParam('mobile');
        $result = array('state' => 'error', 'msg' => '验证失败');

        if( true == $mobile ){
            $user = Account::getUniqueAccount($mobile);

            if( true == $user ){
                $cachecode = Account::model()->safeGetAuth($mobile);
                if( true == $cachecode ){
                    $msgContent = '尊敬的用户，您本次获得的验证码是：'.$cachecode.'，请勿告诉他人';
                    UCQuery::sendMobileMsg($mobile, $msgContent,11);
                    $result = array('state' => 'success', 'msg' => '成功');
                }
                else if( true == Account::model()->hasErrors('Account') )
                {
                    $result['msg'] = Account::model()->getError('Account');
                }
            }
            else {
                $result['msg'] = '该用户不存在';
            }
        }
        else {
            $result['msg'] = '手机号码无效';
        }

        echo JsonHelper::JSON($result);
        Yii::app()->end();
    }

    /**
     * 对手机号码进行视图展示或ajax验证
     */
    public function actionGetpwd()
    {
        $mobile = Yii::app()->request->getParam('mobile');
        $code = Yii::app()->request->getParam('code');

        if ($mobile && $code) {
            $result = array('state' => 'error', 'msg' => '验证失败');
            $user = Account::getUniqueAccount($mobile);

            if ( true == $user ) {
                $cachecode = Account::model()->safeGetAuth($mobile, false);

                if( true == Account::model()->hasErrors('Account') ) {

                    $result['msg'] = Account::model()->getError('Account');
                }
                else if( true == $cachecode ){
                    if ( $cachecode == $code ) {
                        Yii::app()->session['offci_mobile'] = $mobile;
                        Yii::app()->session['offci_authCode'] = $cachecode;
                        $result = array('state' => 'success', 'msg' => '成功');
                    }
                    else
                    {
                        $result['msg'] = '验证码错误或已失效';

                        if( Account::model()->hasErrors('out_auhor') ){
                            $result['msg'] = Account::model()->getError('out_auhor');
                        }
                    }
                }
                else{
                    $result['msg'] = '验证码错误或已失效';
                }
            } else {
                $result['msg'] = '该用户不存在';
            }

            echo JsonHelper::JSON($result);
            Yii::app()->end();
        }

        $this->renderPartial('getpwd');
    }

    /**
     * 账号设置-修改密码
     * panrj 2014-08-09
     */
    public function actionPassword()
    {
        if ( false == Yii::app()->session['offci_mobile'] || false == Yii::app()->session['offci_authCode']) {
            Yii::app()->msg->postMsg('faild', '请手机验证后，才能修改密码');
            $this->redirect( Yii::app()->createUrl('/'.$this->module->id.'/default/getpwd') );
            Yii::app()->end();
        }

        if ( isset($_POST['newPwd']) && isset($_POST['newPwdRepeat']) ) {
            $return = Account::model()->mobileChangePwd( Yii::app()->session['offci_mobile'],
                                    Yii::app()->session['offci_authCode'], $_POST['newPwd'], $_POST['newPwdRepeat'] );
            $msg = '修改失败';

            if ( true == Account::model()->hasErrors('Account') ) {
                 $msg = Account::model()->getError('Account');

            }else if( true == $return ){
                $msg = '修改成功！';
                Yii::app()->msg->postMsg('success', $msg);
                $this->redirect( Yii::app()->createUrl('/'.$this->module->id.'/default/login') );
                Yii::app()->end();
            }

            Yii::app()->msg->postMsg('faild', $msg);
        	$this->redirect( Yii::app()->createUrl('/'.$this->module->id.'/default/getpwd') );
            Yii::app()->end();
        }

    }

    /**
    * 登陆的接收post及视图
    */
    public function actionLogin()
    {
        $model = new OfficialLoginForm;
        
        if (isset($_POST['OfficialLoginForm'])) {
            $model->attributes = $_POST['OfficialLoginForm'];
            // validate user input and redirect to the previous page if valid
            // var_dump($model->validate() && $model->login());exit;
            if ($model->validate() && $model->login()) {
                 $this->redirect( Yii::app()->createUrl('/'.$this->module->id.'/center/index') );
            }
        }

        if ( false === Yii::app()->getModule( $this->module->id )->user->isGuest ){
             $this->redirect( Yii::app()->createUrl('/'.$this->module->id.'/center/index') );
        }

        // display the login form
        $this->renderPartial('login', array('model' => $model));
    }

    /**
    * 退出登陆的接收post
    */
    public function actionLogout() {
        Yii::app()->getModule('official')->user->logout(false);
        $this->redirect(Yii::app()->getModule('official')->user->loginUrl);
    }

    /**
     * 通过后台进入前台
     * panrj 2014-11-27
     */
    public function actionRemote()
    {
        $infoid = Yii::app()->request->getParam('infoid');
        $account = OfficialInfo::getOfficialAccount($infoid);
        if($account){
            $identity = new RemoteAccountIdentity($account);
            Yii::app()->getModule('official')->user->login($identity);
            $this->redirect(Yii::app()->createUrl('/official/center/index'));
        } else {
            echo '<html><head><meta charset="UTF-8"></head>该客户不存在,请验证后再登陆</html>';
            exit;
        }
    }

     /**
     * 通过后台进入前台查看消息
     * panrj 2014-11-27
     */
    public function actionRemotemessage()
    {
        $infoid = Yii::app()->request->getParam('infoid');
        $msgid = Yii::app()->request->getParam('msgid');

        $account = OfficialInfo::getOfficialAccount($infoid);
        if($account){
            $identity = new RemoteAccountIdentity($account);
            Yii::app()->getModule('official')->user->login($identity);
            $this->redirect(Yii::app()->createUrl('/official/message/editmsgform?eid='.$msgid));
        } else {
            echo '<html><head><meta charset="UTF-8"></head>该客户不存在,请验证后再登陆</html>';
            exit;
        }
    }
}