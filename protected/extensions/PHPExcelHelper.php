<?php
/**
 * PHPExcelHelper
 *
 * @category   PHPExcelHelper
 * @package    PHPExcelHelper
 */
class PHPExcelHelper
{
    public static function exportExcel( $excel_content, $excel_file, $excel_props=array('creator'=>'GGBOUND', 'title'=>'EXPORT EXCEL', 'subject'=>'EXPORT EXCEL', 'desc'=>'EXPORT EXCEL', 'keywords'=>'EXPORT EXCEL', 'category'=>'EXPORT EXCEL')){
        if (!is_array($excel_content)){
            return FALSE;
        }
        // //PHPEXCEL包路径
        // $phpExcelPath=Yii::app() -> request -> baseUrl.'/protected/extensions/';
        spl_autoload_unregister(array('YiiBase','autoload'));//取消YII自动加载
        include('PHPExcel.php');//引入PHPEXCEL类
        //设置文档基本属性
        $objPHPExcel = new PHPExcel();
        $objProps = $objPHPExcel -> getProperties();
        $objProps->setCreator($excel_props['creator']);
        $objProps->setLastModifiedBy($excel_props['creator']);
        $objProps->setTitle($excel_props['title']);
        $objProps->setSubject($excel_props['subject']);
        $objProps->setDescription($excel_props['desc']);
        $objProps->setKeywords($excel_props['keywords']);
        $objProps->setCategory($excel_props['category']);
        //开始执行EXCEL数据导出
        for ($i=0;$i<count($excel_content);$i++){
            $each_sheet_content = $excel_content[$i];
            if ($i==0){
                //默认会创建一个sheet页，故不需在创建
                $objPHPExcel -> setActiveSheetIndex(intval(0));
                $current_sheet = $objPHPExcel -> getActiveSheet();
            }else{
                //创建sheet
                $objPHPExcel -> createSheet();
                $current_sheet = $objPHPExcel -> getSheet($i);
            }
            //设置sheet title
            $current_sheet -> setTitle( $each_sheet_content['sheet_name'] );
            //设置sheet当前页的标题
            if (array_key_exists('sheet_title', $each_sheet_content) && !empty($each_sheet_content['sheet_title'])){
                for($j=0; $j<count($each_sheet_content['sheet_title']); $j++){
                    $current_sheet->setCellValueByColumnAndRow($j, 1, $each_sheet_content['sheet_title'][$j]);
                }
            }
            //写入sheet页面内容
            if(array_key_exists('ceils', $each_sheet_content) && !empty($each_sheet_content['ceils'])){
                for($k=0; $k<count($each_sheet_content['ceils']); $k++){
                    for($l=0; $l<count($each_sheet_content['ceils'][$k]); $l++){
                        $current_sheet->setCellValueByColumnAndRow($l, $k+2, $each_sheet_content['ceils'][$k][$l]);
                    }
                }
            }
            if(isset($each_sheet_content['sheet_head']) && $each_sheet_content['sheet_head']){

            }

            //设置隐藏列
            if(isset($each_sheet_content['hide_column']) && count($each_sheet_content['hide_column'])){
                foreach($each_sheet_content['hide_column'] as $column)
                $current_sheet->getColumnDimension($column)->setVisible(false);
            }
            // $current_sheet->insertNewRowBefore(1, 1);
            // $current_sheet->setCellValueByColumnAndRow(0,1,$each_sheet_content['sheet_head']);
        }
        //生成EXCEL并下载
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
            // header('Content-Disposition: attachment;filename="'.$excel_file.'-'.date('Y-m-d-H-i-s').'.xls"');
        header('Content-Disposition: attachment;filename="'.iconv('utf-8', 'gb2312', $excel_file).'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');//自动下载
        Yii::app()->end();
        //恢复Yii自动加载功能
        spl_autoload_register(array('YiiBase','autoload'));
    }

    /** 
    * @todo 针对YII 查询输出带有数据库表字段名键名进行优化EXCEL表格输出 
    * @todo 替换键名为0、1、2... 
    * @param array $data 
    * @return array('excel_title'=array(),'excel_ceils'=array()); 
    */  
    public function excelDataFormat($data){  
        for ($i=0;$i<count($data);$i++){  
            $each_arr=$data[$i];  
            $new_arr[]=array_values($each_arr); //返回所有键值  
        }  
        $new_key[]=array_keys($data[0]); //返回所有索引值  

        return array('excel_title'=>$new_key[0],'excel_ceils'=>$new_arr);  
    }  
}
