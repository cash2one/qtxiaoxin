<?php

class MclientController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionActiveverify()
    {
        if(isset($_POST['Activity'])){
            $code=trim($_POST['Activity']['code']);
            $password=trim($_POST['Activity']['password']);
            $type=(int)$_POST['Activity']['role'];
            if(!empty($code)&&!empty($password)){
                  
            $codeinfo = UCQuery::deidInviteCode($code);

            if($codeinfo==''){
                Yii::app()->msg->postMsg('error', '您输入的邀请码有误，请确认后再输入','app');
                $this->redirect(Yii::app()->createUrl("xiaoxin/mclient/activeverify/"));
            }

            if($type!=$codeinfo['type']){
                Yii::app()->msg->postMsg('error', '您输入的邀请码与当前身份不对应，请确认后再输入','app');
                $this->redirect(Yii::app()->createUrl("xiaoxin/mclient/activeverify/"));
            }
               


                // $sql="call php_xiaoxin_activeverify('$code','$password',$type)";
                // $codeinfo=UCQuery::queryRow($sql);
                $codeinfo = Cdkey::activeVerify($code,$password,$type);
                if($codeinfo){
                    if($codeinfo->type==0&&!empty($codeinfo->userid)){
                        Yii::app()->msg->postMsg('error', '该邀请码已被绑定','app');
                        $this->redirect(Yii::app()->createUrl("xiaoxin/mclient/activeverify/"));
                    }else{
                        Yii::app()->msg->postMsg('success', '校验成功','app');
                        $this->redirect(Yii::app()->createUrl("xiaoxin/mclient/activeuser/".$codeinfo->id));
                    }
                }else{
                    Yii::app()->msg->postMsg('error', '您输入的邀请码或邀请码密码有误，请确认后再输入','app');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/mclient/activeverify/"));
                }

            }
        }
    	$this->renderPartial('activeverify');
    }

    public function actionActiveuser($id)
    {
        $codeinfo=UCQuery::loadTableRecord('tb_cdkey',$id);
        if($codeinfo->type==1 && $codeinfo->userid){
            $userinfo = UCQuery::loadUser($codeinfo->userid);
        }else{
            $userinfo = '';
        }
        if(isset($_POST['Activeuser'])){
            $type=$_POST['Activeuser']['type'];
            $name=$_POST['Activeuser']['name'];
            $mobilephone=$_POST['Activeuser']['mobilephone'];
            $password=$_POST['Activeuser']['password'];
            $password2=$_POST['Activeuser']['password2'];
            $password=MainHelper::encryPassword($password);
            $userVersion = (int)USER_BRANCH;
            
            if($type==0){  //老师
                UCQuery::execute("LOCK TABLE `tb_user_maxid` WRITE;");
                // $success = UCQuery::queryScalar($sql);
                $success = Cdkey::activeTeacher($codeinfo->cid,$name,$password,$mobilephone,$codeinfo->id);
                UCQuery::execute("UNLOCK TABLES;");

                if($success==0){
                    Yii::app()->msg->postMsg('success', '激活老师用户成功,手机端登陆需1小时后生效','app');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/mclient/activeverify/"));
                }else if($success==2){
                    Yii::app()->msg->postMsg('error', '激活用户失败,老师手机已绑定','app');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/mclient/activeuser/$id"));
                }else{
                    Yii::app()->msg->postMsg('error', '激活用户失败了','app');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/mclient/activeuser/$id"));
                }
            }else{ //家长
				$studentid = isset($_POST['Activeuser']['studentid'])?$_POST['Activeuser']['studentid']:'';

                UCQuery::execute("LOCK TABLE `tb_user_maxid` WRITE;");
                 $success = Cdkey::activeStudent($codeinfo->cid,$name,$password,$mobilephone,$codeinfo->id,$studentid);
                UCQuery::execute("UNLOCK TABLES;");
                
                if($success==0){
                    Yii::app()->msg->postMsg('success', '激活家长用户成功,手机端登陆需1小时后生效','app');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/mclient/activeverify/"));
                }else{
                    Yii::app()->msg->postMsg('error', '激活用户失败','app');
                }
            }
        }
    	$this->renderPartial('activeuser',array('codeinfo'=>$codeinfo,'student'=>$userinfo));
    }
    /*
     * 申请试用
     */
    public function actionApply(){
//           $_POST['ApplyTry']['schoolname']="申请测试学校";
//            $_POST['ApplyTry']['personname']="申请人";
//            $_POST['ApplyTry']['mobile']="18580507445";
//            $_POST['ApplyTry']['job']="校长";
//            $_POST['ApplyTry']['address']="深圳";

        if(isset($_POST['ApplyTry'])){
           $applytry = new ApplyTry;
           $applytry->attributes = $_POST['ApplyTry'];
           if($applytry->save()){
               $this->redirect(Yii::app()->createUrl("xiaoxin/mclient/applysuccess").'?success=1');
           }else{
               $this->redirect(Yii::app()->createUrl("xiaoxin/mclient/applysuccess").'?success=0');
           }

        }
        $this->renderPartial('apply',array());
    }
    /*
     * 申请试用
     */
    public function actionApplysuccess(){
        $success=Yii::app()->request->getParam("success",0);
        $this->renderPartial('applysuccess',array("success"=>$success));
    }
}