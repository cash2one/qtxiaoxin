<?php

class CenterController extends Controller
{

    /**
     * 修改资料视图和接收资料修改post
     */
    public function actionIndex()
    {
        $model = OfficialInfo::model()->findByPk(Yii::app()->getModule('official')->user->infoid);
        if (true == Yii::app()->request->getParam('inputFileName')) {
            $result = $model->saveInfo(
                Yii::app()->request->getParam('inputFileName'),
                Yii::app()->request->getParam('openName'),
                Yii::app()->request->getParam('summary')
            );

            if (true == $result && false == $model->hasErrors()) {
                Yii::app()->msg->postMsg('success', '保存成功!');
                $this->redirect('index', array('model'=> $model));
            }
        }

        $this->render('index', array(
            'model' => $model
        ));
    }

    /**
     * 修改密码视图
     */
    public function actionPwdform()
    {
        $this->render('pwdform', array(
            'model' => Account::model()
        ));
    }

    /**
     * 接收ajax请求返回，是否正确json消息
     */
    public function actionOldpassword()
    {
        $model = Account::model()->findByPk(Yii::app()->getModule('official')->user->id);

        $model->inputOldPassword = Yii::app()->request->getParam('inputOldPassword');

        header('Content-type: application/json');

        echo json_encode(array(
            'status' => $model->validate(),
            'msg' => $model->getError('inputOldPassword')
        ));

        Yii::app()->end();

        /*if ($model->pwd === MainHelper::encryPassword(Yii::app()->request->getParam('inputOldPassword'))) {
            $arr = array('status' => 0 , 'msg' => '正确');
        } else {
            $arr = array('status' => 1 , 'msg' => '错误');
        }
        exit(json_encode($arr));*/
    }

    /**
     * 接收密码修改post
     */
    public function actionChangepwd()
    {
        $model = Account::model()->findByPk(Yii::app()->getModule('official')->user->id);

        $result = $model->changePwd(
            Yii::app()->request->getParam('inputOldPassword'),
            Yii::app()->request->getParam('newPassword'),
            Yii::app()->request->getParam('passwordConfirmation')
        );
        if (true == $result && false == $model->hasErrors()) {
            Yii::app()->msg->postMsg('success', '保存成功!');
        }
        $this->render('pwdform', array(
            'model' => $model
        ));
    }
}