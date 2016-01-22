<?php
/**
* Notification messages
*
* @category       User Interface
* @package        extensions
* @author         Andre Couto <andre_couto@live.com>
* @version        1.1 2013/01/04
* @site		  http://7zio.com
*/

/*  Installation:

1 - Copy the files into your extension-folder and Import the component - Edit (../protected/config/main.php):

// application components
'components'=>array(
...
    'msg' => array(
    'class' => 'application.extensions.emessage.EMessage'
    ),
...

2 - In action - example:

if(empty($model->field)) // failure
{
    Yii::app()->msg->postMsg('error', 'Empty not allowed!');
    Yii::app()->msg->saveMsg();
    $this->render('update',array('model'=>$model)); return false;
}

if($model->save())
{
    Yii::app()->msg->postMsg('success', 'Success message!');
    Yii::app()->msg->saveMsg();
    $this->render('update',array('model'=>$model,'id'=>$model->id));
}

if($model->save())
{
    Yii::app()->msg->postMsg('note', 'Ops! message...');
    Yii::app()->msg->saveMsg();
    $this->redirect(array('index'));
}

3 - Print messages in layout or... - example:

Yii::app()->msg->getMsg();


*4 - Basic usage:

Yii::app()->msg->postMsg('success', 'Testing... 123');
Yii::app()->msg->printMsg();

*/

class EMessage{

    public $message;

    public function init(){
	// $url = Yii::app()->getAssetManager()->publish( Yii::getPathOfAlias('ext.emessage') );
	// Yii::app()->clientScript->registerCssFile($url.'/emessage.css');
    }

    public function postMsg($type, $msg, $version='web'){
        
        // $this->message[]= '<div id="message"><div id="type-'.$type.'">'.$msg.'</div><div id="icon-'.$type.'">&nbsp</div></div><script>alert(123);</script>';
        $controller = new Controller('');
        if($version=='web'){
            $html = $controller->renderPartial('//notify',array('msg'=>$msg,'type'=>$type),true);
        }else{
            $html = $controller->renderPartial('//notify_client',array('msg'=>$msg,'type'=>$type),true);
        }
        
        Yii::app()->session['message'] = $html;
    }

    public function getMsg()
    {
    	if (isset(Yii::app()->session['message']) and !empty(Yii::app()->session['message'])) {
    		echo Yii::app()->session['message'];
    	}
    }

    public function printMsg() {
    	if (isset(Yii::app()->session['message']) and !empty(Yii::app()->session['message'])) {
            echo Yii::app()->session['message'];
            unset(Yii::app()->session['message']);
    	}
    }
}
