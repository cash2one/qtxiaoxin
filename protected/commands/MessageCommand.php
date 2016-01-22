<?php
class MessageCommand extends CConsoleCommand
{
    public function run($args)
    {

        $list = NoticeQuery::queryAll("select * from tb_notice where  state=0 and sendtime<now() and sender like '%".USER_BRANCH. "' limit 100;");

        foreach ($list as $noticeinfo) {
            $uid = $noticeinfo['sender'];

            $userinfo = UCQuery::loadUser($uid);

            if(!isset($userinfo->name)){
                continue;
            }
            $receiver = json_decode($noticeinfo['receiver'], true);
            $noticeType = $noticeinfo['noticetype']; //通知类型
            $sid = $noticeinfo['sid']; //学校id
            $familyIds = array();
            $list1 = array();
            $ids = array();
            if(empty($receiver)){
                continue;
            }
            foreach ($receiver as $k => $v) {
                if ($k == 5) { //个人
                    if ($noticeType == 2 || $noticeType == 1) { //布置作业或通知家长
                        $list1 = UCQuery::queryAll("select child,GROUP_CONCAT(guardian) as family from tb_guardian where child in(" . $v . ") and deleted=0 group by child ");
                        foreach ($list1 as $val) {
                            $familyIds[$val['child']] = $val['family'];
                        }
                    }
                    if(empty($v)){
                        continue;
                    }
                    $ids = explode(",", $v);
                } else if ($k == 1) { //班级
                    $classIds = $v;
                    $temp = UCQuery::queryAll("select student from tb_class_student_relation where cid in(" . $classIds . ") and deleted=0 and state=1  "); //获取班级id下的学生
                    if ($temp) {
                        foreach ($temp as $val) {
                            $ids[] = $val['student'];
                        }
                    }
                    //找监护人
                    if ($noticeType == 1 || $noticeType == 2) {
                        if(count($ids)>0){
                            $list1 = UCQuery::queryAll("select child,GROUP_CONCAT(guardian) as family from tb_guardian where child in(" . implode(",", $ids) . ") and deleted=0 group by child ");
                            foreach ($list1 as $val) {
                                $familyIds[$val['child']] = $val['family'];
                            }
                        }
                    }
                } else if ($k == 2) { //分组
                    $temp = UCQuery::queryAll("select member from tb_group_member where gid in(" . $v . ") and deleted=0   "); //获取组id下的成员
                    if ($temp) {
                        foreach ($temp as $val) {
                            $ids[] = $val['member'];
                        }
                    }

                    if ($noticeType == 1 || $noticeType == 2) {
                        if(count($ids)>0){
                            $list1 = UCQuery::queryAll("select child,GROUP_CONCAT(guardian) as family from tb_guardian where child in(" . implode(",", $ids) . ") and deleted=0 group by child ");
                            foreach ($list1 as $val) {
                                $familyIds[$val['child']] = $val['family'];
                            }
                        }
                    }
                } else if ($k == 3) { //年级
                    $grades = explode(",", $v);
                    $cids = array();
                    foreach ($grades as $g) {
                        $gradeInfo = UCQuery::queryRow("select * from tb_grade where gid=$g and deleted=0");
                        if ($gradeInfo&&property_exists($gradeInfo,"age")) {
                            //$year = MainHelper::getClassYearByGradeAge($gradeInfo->age);
                            $y = (int)Date("Y");
                            $m = (int)Date("m");
                            // $age = $m<9?$age:$age-1;
                            $year = $y-$gradeInfo->age;
                            $year = $m<9?$year-1:$year;


                            //获取班级
                            $classIds = UCQuery::queryAll("select cid from tb_class where sid=$sid and year=$year and stid=" . ($gradeInfo->stid) . "  and deleted=0");
                            if (!empty($classIds)) {
                                foreach ($classIds as $class) {
                                    $cids[] = $class['cid'];
                                }
                            }

                        }

                    }

                    if (!empty($cids)) {
                        $temp = UCQuery::queryAll("select student from tb_class_student_relation where cid in(" . implode(",", $cids) . ") and deleted=0 and state=1  "); //获取班级id下的学生
                        if ($temp) {
                            foreach ($temp as $val) {
                                $ids[] = $val['student'];//;;
                            }
                        }

                        if ($noticeType == 1 || $noticeType == 2 || $noticeType == 4|| $noticeType == 8) {
                            if (!empty($ids)) {
                                $list1 = UCQuery::queryAll("select child,GROUP_CONCAT(guardian) as family from tb_guardian where child in(" . implode(",", $ids) . ") and deleted=0 group by child ");
                                foreach ($list1 as $val) {
                                    $familyIds[$val['child']] = $val['family'];
                                }
                            }
                        }
                    }

                } else if ($k == 4) { //全体老师
                    $temp = UCQuery::queryAll("select teacher from tb_school_teacher_relation where sid=$sid and deleted=0"); // 获取学校所有老师id
                    if ($temp) {
                        foreach ($temp as $val) {
                            $ids[] = $val['teacher'];
                        }
                    }
                }
            }
            try {
                NoticeQuery::execute("start  TRANSACTION;");

                foreach ($ids as $vv) {
                    NoticeQuery::inserttb_notice_Message($noticeinfo, $vv, $familyIds, $userinfo->name);
                }
                $sql2 = " update tb_notice set state=1 where noticeid=" . $noticeinfo['noticeid'];
                $command2 = NoticeQuery::execute($sql2);
                NoticeQuery::execute("commit;");
            } catch (Exception $e) {
                echo $e->getMessage();
                NoticeQuery::execute("ROLLBACK;");
            }
        }
    }
}

?>