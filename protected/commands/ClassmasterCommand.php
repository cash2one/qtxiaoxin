<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-10
 * Time: 下午3:41
 */

class ClassmasterCommand extends CConsoleCommand
{
    public function run($args)
    {
        // $schoolList = UCQuery::queryAll("select sid,name from tb_school where deleted=0  and (length(pingyin)<1 or pingyin is null)  order by sid limit 5000");
        // $classList = UCQuery::queryAll("select cid,name from tb_class where deleted=0  and (length(pingyin)<1 or pingyin is null)  order by cid limit 5000 ");
//        $userList = UCQuery::queryAll("select userid,name from tb_user where deleted=0 and  (length(pingyin)<1 or pingyin is null) and identity in(1,2,5)    limit 1000");
//        $py = new py_class();
//        foreach ($userList as $val) {
//            $pingyin = $py->str2py(trim($val['name']));
//            UCQuery::execute("update tb_user set pingyin='" . substr($pingyin, 0, 10) . "' where userid=" . $val['userid']);
//        }

        //处理未删除班级
        $classlist=UCQuery::queryAll("select * from tb_class where deleted=0");
        foreach($classlist as $class){
            $master=$class['master'];
            //找出这个班是否有删除过班主任的记录
            $classRelation_deleted=ClassTeacherRelation::model()->findAllByAttributes(array('type'=>1,"deleted"=>1,"cid"=>$class['cid']));
            //找出这个班现在在关系表的班主任记录
            $classRelation=ClassTeacherRelation::model()->findAllByAttributes(array('type'=>1,"deleted"=>0,"cid"=>$class['cid']));
            if($classRelation_deleted&&!$classRelation){ //如果关系表存在已删除的班主任，但关系表现在没有班主任信息，但tb_class表有班主任，
                //则表示现在没有班主任           //将tb_class表master清空
                if($master){
                    print("update tb_class set master=null where cid=" .$class['cid']);
                    UCQuery::execute("update tb_class set master=null where cid=" .$class['cid']);
                    Yii::log("update tb_class set master=null where cid=" .$class['cid'],CLogger::LEVEL_ERROR);
                }
            }
            if(!$classRelation_deleted &&!$classRelation ){//关系表没有删除过班主任信息,现在也没有班主任信息,则添加
                if($master){
                    print("add relation:master:$master,:cid:".$class['cid']);
                    $rr=new ClassTeacherRelation();
                    $rr->teacher=$master;
                    $rr->cid=$class['cid'];
                    $rr->type=1;
                    $rr->state=1;
                    $rr->subject='';
                    $rr->sid=null;
                    $rr->deleted=0;
                    $rr->creater=null;
                    $rr->save();
                    Yii::log("create relation:cid:".$class['cid'].";teacher:=".$master,CLogger::LEVEL_ERROR);
                }
            }
            //如果关系表有班主任信息，对比一下tb_class的master是否相同
            if($classRelation){
                $newclassRelation=$classRelation[0];
                if($newclassRelation && $newclassRelation->teacher!=$master){
                    print("update tb_class set master=".$newclassRelation->teacher." where cid=" .$class['cid']);
                    //Yii::log("update tb_class set master=".$newclassRelation->teacher." where cid=" .$class['cid'],CLogger::LEVEL_ERROR);

                    UCQuery::execute("update tb_class set master=".$newclassRelation->teacher." where cid=" .$class['cid']);
                }

            }
        }
        //找出已删除的班主数据
        $deleteclasslist=UCQuery::queryAll("select * from tb_class where deleted=1 ");
        foreach($deleteclasslist as $v){

            //删除的班级数据，对应关系表也要删除
            $num= ClassTeacherRelation::model()->countByAttributes(array('cid'=>$v['cid'],'deleted'=>0));
            print("begin deleted:cid:".$v['cid']."\n".",deleted=0,num:=".$num);
            if($num>0){
               ClassTeacherRelation::model()->updateAll(array("deleted"=>1),"cid=:cid",array(":cid"=>$v['cid']));
                print("true deleted:cid:".$v['cid']."\n");
                Yii::log("deleted:cid:".$v['cid'],CLogger::LEVEL_ERROR);
            }
        }
        echo "\n end;";
    }
}