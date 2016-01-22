<?php
class ExamService
{
    /*
     * 成绩显示时，获取班级下的学生数据,
     * $cid 班级id
     * $sids 考试科目
     * $evaluation==1 是否需要显示评语
     */
    public static function getClsssStudent($cid, $sids, $evaluation = 1)
    {
        $classMan = array();
        $clsssStudent = ClassStudentRelation::getClassStudents($cid); //获取该班级下的所有学生
        foreach ($clsssStudent as $student) {
            $data = array("userid" => $student->student, 'name' => $student->student0->name);
            foreach ($sids as $sid) {
                $data[$sid] = '';
            }
            if ($evaluation) {
                $data['evaluation'] = '';
            }
            $classMan[] = $data;
        }
        return $classMan;
    }

    /*
     * 获取考评的某个关联考试数据
     * $eid 考试id
     * $gcinfo  考试相关的年级班级数据
     * $subjectList  考试科目数组
     */
    public static function getRelationExam($eid, $gcinfo, $subjectList)
    {
        $relationArr = array();
        $eaidinfoList = ExamAlone::getExamAloneList($eid);
        $eaids = array();
        foreach ($eaidinfoList as $eeid) {
            $eaids[] = $eeid['eaid'];
        }
        if (count($eaids)) {
            $md5Arr = ExamAlone::getExamAndAloneInfo1(implode(",", $eaids));
        } else {
            $md5Arr = array();
        }
        $examType = Exam::getExamType();
        if (is_array($md5Arr)) foreach ($md5Arr as $examAlone) {
            if ($examAlone['eid'] != $eid) {
                $alone['eid'] = $examAlone['eid'];
                $examtmp = Exam::model()->findByPk($examAlone['eid']);
                if ($examtmp && $examtmp['deleted'] == 0) {
                    $mclass = MClass::model()->findByPk($examAlone['cid']);
                    $alone['cid'] = $mclass['cid'];
                    $alone['cid_name'] = $mclass['name'] ? $mclass['name'] : '';
                    $alone['grade_name'] = MClass::getGradeNameByCid($gcinfo, $mclass['cid']);
                    $alone['sid'] = $examAlone['sid'];
                    $alone['eaid'] = $examAlone['eaid'];
                    $alone['exam_name'] = $examtmp['name'];
                    $alone['exam_type'] = $examType[$examtmp['type']];
                    if ($examAlone['sid']) {
                        $alone['sid_name'] = isset($subjectList[$examAlone['sid']]) ? $subjectList[$examAlone['sid']] : "";
                    } else {
                        $alone['sid_name'] = "";
                    }
                    $relationArr[] = $alone;
                }
            }
        }
        return $relationArr;
    }

    /*
             * 显示发送页面,获取等级
             */
    public static function getLevelNameByScoreShow($score, $config)
    {
        if (is_array($config)) {
            $i=0;
            foreach ($config as $key => $val) {
                if ($i == 0) {
                    if ($score >= $val['low'] and  $score <= $val['height']) {
                        return $key;
                    }
                } else {
                    if ($score >= $val['low'] and  $score < $val['height']) {
                        return $key;
                    }
                }
                $i++;
            }
        }
        return "";

    }

    /*
     * 发送时，获取等级
     */
    public static function getLevelNameByScore($score, $config)
    {
        if ($score == '') {
            return '缺考';
        }
        if (is_array($config)) {
            $i = 0;
            foreach ($config as $key => $val) {
                if ($i == 0) {
                    if ($score >= $val['low'] and  $score <= $val['height']) {
                        return $key;
                    }
                } else {
                    if ($score >= $val['low'] and  $score < $val['height']) {
                        return $key;
                    }
                }
                $i++;
            }
        }
        return "";

    }

    //计算班级平均分
    public static function average($data)
    {
        $num = 0;
        $i = 0;
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $val) {
                if ($val !== '') {
                    $i++;
                    $num = $num + $val;
                }
            }
            $result = $num / $i;
            if (is_int($result)) {
                return number_format($result, 0);
            } else {
                return number_format($result, 1);
            }
        }
        return $num;
    }

    /*
     *
        * 根据字母获取数字
        */
    public static function getalphnum($char)
    {
        $sum = '';
        $array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $len = strlen($char);
        for ($i = 0; $i < $len; $i++) {
            $index = array_search($char[$i], $array);
            $sum += ($index + 1) * pow(26, $len - $i - 1);
        }
        return $sum;
    }
    /*
     * 根据考试信息中的配置信息，生成考试配置信息,类似 于100>=A>=90
     */
    public static function generateExamConfig($config){
        $arr=array();
        if(is_array($config)) foreach($config as $key=>$con){
            $i=0;
            if(is_array($con)) foreach($con as $k=>$v){

                if($i==0){
                    $arr[$key][$k]=$v['height'].">=".$k.'>='.$v['low'];
                }else{
                    $arr[$key][$k]=$v['height'].">".$k.'>='.$v['low'];
                }
                $i++;


            }

        }
        $return=array();
        foreach($arr as $key=>$val){
            $return[$key]=implode(",",$val);
        }
        return $return;
    }

}