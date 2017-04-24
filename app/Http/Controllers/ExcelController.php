<?php

namespace App\Http\Controllers;

use App\Model\front_content;
use App\Model\lesson;
use App\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Classes\PHPExcel;
use Monolog\Handler\ElasticSearchHandlerTest;
use PHPExcel_IOFactory;
use App\Http\Requests;
use PHPExcel_Cell;
use App\Http\Controllers\Help\HelpController;


class Obj_Info
{
    public $teacher_name = null;
    public $lesson_info = null;
    public $lesson_weekday = null;
    public $lesson_time = null;

    function setTeacher_name($teacher_name){
        $this->teacher_name = $teacher_name;
    }


    function setLesson_info($par){
        $this->lesson_info = $par;
    }


    function setLesson_weekday($par){
        $this->lesson_weekday = $par;
    }


    function setLesson_time($par){
        $this->lesson_time = $par;
    }


}
class ExcelController extends Controller
{
    //导入教师课表
    public function ImportLesson(Request $request)
    {
        $Index = $request->get('Index');
        $year1 = $request->get('year1');
        $year2 = $request->get('year2');
        $terminal = $request->get('terminal');
        $year=$year1.'-'.$year2;
        //上传文件，checking file is valid
        $file = Input::file('importLesson');
        if ($file->isValid())
        {
            $destinationPath = 'upFile';
            $fileName = $request->get('filename');
//            move_uploaded_file($_FILES["importLesson"]["tmp_name"],"upFile/" . iconv("UTF-8","gbk",$fileName));
            $file->move($destinationPath,iconv("UTF-8","gbk",$fileName));
        }
        else{
            // sending back with error message.
            return Redirect::action('SupervisorController@LessonTable')->withCookie('mess','导入数据失败');
        }
//        $tmp_name = $_FILES ['importLesson']['tmp_name'];
//        $filePath = 'upFile/'.$fileName;
//        $result = move_uploaded_file($tmp_name,$filePath);

        $file = $_SERVER['DOCUMENT_ROOT'].'/upFile/'.iconv("UTF-8","gbk",$fileName);

//$result=true;
//        if($result)
//        {
        $objReader = PHPExcel_IOFactory::createReader ( 'Excel2007' );
        $objReader->setReadDataOnly ( true );
//            $objPHPExcel = $objReader->load ($filePath);
        $objPHPExcel = PHPExcel_IOFactory::load ($file);

        $objWorksheet = $objPHPExcel->getActiveSheet (0);
        $objWorksheet = $objPHPExcel->getSheet (0);
//取得excel的总行数
        $highestRow = $objWorksheet->getHighestRow ();
//取得excel的总列数
        $highestColumn = $objWorksheet->getHighestColumn ();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString ( $highestColumn );

//            echo $highestRow ."<br/>";
//            echo $highestColumn ."<br/>";
//            echo $highestColumnIndex ."<br/>";


//LessonInfo
//$LessonInfoData = array ();
        $LessonInfoData = $this->Get_LessonInfo($highestRow,$highestColumnIndex,$objWorksheet);

        $this->DBImportLesson($Index,$LessonInfoData,$year,$terminal);
//echo $LessonInfoData[0][0][0]->lesson_info;
//            $result = preg_split('/[;\r\n]+/s',$LessonInfoData[0][0][0]->lesson_info);
//            echo $result[0]."<br/>";
//            echo $result[1]."<br/>";
//            echo $result[2]."<br/>";
        return Redirect::action('SupervisorController@LessonTable')->withCookie('mess','导入课程表成功');

//            echo $result[1]."<br/>";
//列从0开始，行从1开始

//        }
//        else
//            return Redirect::action('SupervisorController@LessonTable')->withCookie('mess','导入课程表失败');

    }
    function Get_LessonInfo($highestRow,$highestColumnIndex,$objWorksheet)
    {

        $LessonInfoData=array();
        for($row = 3; $row <= $highestRow; $row++)
        {
            $i=0;
            $EverLessonInfoData=array();
            for($col = 1; $col < $highestColumnIndex; $col++)
            {
                if ($objWorksheet->getCellByColumnAndRow ( $col, $row )->getValue ())
                {
                    $t=new Obj_Info();
                    $t->setTeacher_name($objWorksheet->getCellByColumnAndRow ( 0, $row )->getValue ()) ;
                    $t->setLesson_weekday( floor(($col-1)/5 +1)  );
                    $t->setLesson_time( ($col-1)%5 +1 );
                    $t->setLesson_info($objWorksheet->getCellByColumnAndRow ( $col, $row )->getValue ());
                    $EverLessonInfoData[$i]=$t;
                    $i++;
                }
            }
            $LessonInfoData[0][]=$EverLessonInfoData;
        }
        return $LessonInfoData;
    }
    //将教师课表信息存入数据库
    public function DBImportLesson($Index,$LessonInfoData,$year,$terminal)
    {
        for ($i=0;$i<count($LessonInfoData[0]);$i++)
        {
            if ($LessonInfoData[0][$i]!=null)
            {
                $result = preg_split('/[;\r\n]+/s',$LessonInfoData[0][$i][0]->lesson_info);
                DB::table('lessons')->insert(
                    [
                        'lesson_state'=>'未完成',
                        'lesson_level'=>'自主听课',
                        'lesson_name' =>$result[0],
                        'lesson_teacher_name' =>$LessonInfoData[0][$i][0]->teacher_name,
                        'lesson_teacher_unit' =>$Index,
                        'lesson_year' =>$year,
                        'lesson_semester' =>$terminal,
                        'lesson_week' =>$result[2],
                        'lesson_time'=>$LessonInfoData[0][$i][0]->lesson_time,
                        'lesson_weekday'=>$LessonInfoData[0][$i][0]->lesson_weekday,
                        'lesson_room'=>$result[3],
                        'lesson_class'=>$result[1]
                    ]);
            }

        }
    }

    public function NecessaryTaskExport(Request $request)
    {
        $year = $request->get('year');
        $semester = $request->get('semester');
        $Export_Data = DB::table('lessons')
            ->where('lesson_level','=','关注课程')
            ->where('lesson_year','=',$year)
            ->where('lesson_semester','=',$semester)
            ->get();
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("BJFU-DFI")->setTitle("Office 2007 XLSX Test Document");
        //set width
        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('B')->setAutoSize(true);
        //合并
//        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1:C1');
        //表头
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '课程名称');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '所属学院');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '授课教师');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '任务等级');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '完成状态');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '授课学年');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '授课学期');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '授课周次');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '星期');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '课程时间');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '上课班级');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '上课地点');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '关注原因');




        for ($i = 0; $i < count($Export_Data); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . ($i + 3), $Export_Data[$i]->lesson_name)
                ->setCellValue('B' . ($i + 3), $Export_Data[$i]->lesson_teacher_unit)
                ->setCellValue('C' . ($i + 3), $Export_Data[$i]->lesson_teacher_name)
                ->setCellValue('D' . ($i + 3), $Export_Data[$i]->lesson_level)
                ->setCellValue('E' . ($i + 3), $Export_Data[$i]->lesson_state)
                ->setCellValue('F' . ($i + 3), $Export_Data[$i]->lesson_year)
                ->setCellValue('G' . ($i + 3), $Export_Data[$i]->lesson_semester)
                ->setCellValue('H' . ($i + 3), $Export_Data[$i]->lesson_week)
                ->setCellValue('I' . ($i + 3), $Export_Data[$i]->lesson_weekday)
                ->setCellValue('J' . ($i + 3), $Export_Data[$i]->lesson_time)
                ->setCellValue('K' . ($i + 3), $Export_Data[$i]->lesson_class)
                ->setCellValue('L' . ($i + 3), $Export_Data[$i]->lesson_room)
                ->setCellValue('M' . ($i + 3), $Export_Data[$i]->lesson_attention_reason);

        }
        $objPHPExcel->getActiveSheet()->setTitle("1");
        $objPHPExcel->setActiveSheetIndex(0);
        // 输出
        $filename = $year . '学年' . $semester. '任务安排.xls';
        $ua = $_SERVER["HTTP_USER_AGENT"];//探测主机所用内核
        header('Content-Type: application/octet-stream');

        if (preg_match("/Chrome/", $ua)) {//谷歌内核
            iconv("utf-8", "gb2312", $filename);
            header('Content-Disposition: attachment; filename="' . $filename . '"');

        } else if (preg_match("/Firefox/", $ua)) {//火狐内核
            iconv("utf-8", "gb2312", $filename);
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        } else {
            $encoded_filename = urlencode($filename);//ie内核
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function NecessaryTaskImport(Request $request)
    {
        $file = Input::file('NecessaryTaskImport');
        if ($file->isValid())
        {
            $destinationPath = 'upFile';
            $fileName = $request->get('filename');
            $file->move($destinationPath,iconv("UTF-8","gbk",$fileName));
        }
        else{
            return Redirect::action('EvalutionController@NecessaryTask')->withCookie('mess','导入数据失败');
        }
        $file = $_SERVER['DOCUMENT_ROOT'].'/upFile/'.iconv("UTF-8","gbk",$fileName);
        $objReader = PHPExcel_IOFactory::createReader ( 'Excel2007' );
        $objReader->setReadDataOnly ( true );
        $objPHPExcel = PHPExcel_IOFactory::load ($file);

        $objWorksheet = $objPHPExcel->getActiveSheet (0);
        $objWorksheet = $objPHPExcel->getSheet (0);
//取得excel的总行数
        $highestRow = $objWorksheet->getHighestRow ();
//取得excel的总列数
        $highestColumn = $objWorksheet->getHighestColumn ();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString ( $highestColumn ) -1;

//        echo $highestRow ."<br/>";
//        echo $highestColumn ."<br/>";
//        echo $highestColumnIndex ."<br/>";

        $excelData = array ();
        for($row = 2; $row <= $highestRow; $row++) {
            for($col = 0; $col < $highestColumnIndex; $col++) {
                $excelData[$row-2][] = $objWorksheet->getCellByColumnAndRow ( $col, $row )->getValue ();
            }
        }

//        echo "<pre>";
//        print_r($excelData);
//        echo "</pre>";
        for ($i=0;$i<count($excelData);$i++)
        {
            $flag = DB::table('lessons')
                ->where('lesson_name','=',$excelData[$i][1])
                ->where('lesson_year','=',$excelData[$i][4])
                ->where('lesson_semester','=',$excelData[$i][5])
                ->where('lesson_teacher_name','=',$excelData[$i][6])
                ->where('lesson_teacher_unit','=',$excelData[$i][7])
                ->update([
                    'lesson_type'=>$excelData[$i][2],
                    'lesson_level'=>'关注课程',
                    'assign_group'=>$excelData[$i][8],
                    'lesson_attention_reason'=>$excelData[$i][9],
                    'lesson_grade'=>$excelData[$i][3]
                ]);
            if ($flag == 0)
            {
//                如果有一门课导入失败，则将之前成功的课程置为自主听课，并返回错误信息。

                for ($k=0;$k<$i;$k++)
                {
                    $data = DB::table('lessons')
                        ->where("lesson_name",'=',$excelData[$k][1])
                        ->where("lesson_teacher_name",'=',$excelData[$k][6])
                        ->where("lesson_teacher_unit",'=',$excelData[$k][7])
                        ->where("lesson_year",'=',$excelData[$k][4])
                        ->where("lesson_semester",'=',$excelData[$k][5])
                        ->update([
                            'lesson_type'=>null,
                            'assign_group'=>'',
                            'lesson_level'=>'自主听课',
                            'lesson_attention_reason'=>'',
                            'lesson_grade'=>null
                        ]);
                }

                return Redirect::action('EvalutionController@NecessaryTask')
                    ->withCookie('mess','导入第'.$excelData[$i][0].'项'.$excelData[$i][1].
                        '失败!  请勿重复导入课程或检查课程信息、格式');
            }
        }
        return Redirect::action('EvalutionController@NecessaryTask')->withCookie('mess','导入关注课程成功');


    }

    public function NecessaryTaskImportByName(Request $request)
    {
        $file = Input::file('NecessaryTaskImport');
        if ($file->isValid())
        {
            $destinationPath = 'upFile';
            $fileName = $request->get('filename');
            $file->move($destinationPath,iconv("UTF-8","gbk",$fileName));
        }
        else{
            return Redirect::action('EvalutionController@NecessaryTask')->withCookie('mess','导入数据失败');
        }
        $file = $_SERVER['DOCUMENT_ROOT'].'/upFile/'.iconv("UTF-8","gbk",$fileName);
        $objReader = PHPExcel_IOFactory::createReader ( 'Excel2007' );
        $objReader->setReadDataOnly ( true );
        $objPHPExcel = PHPExcel_IOFactory::load ($file);

        $objWorksheet = $objPHPExcel->getActiveSheet (0);
        $objWorksheet = $objPHPExcel->getSheet (0);
//取得excel的总行数
        $highestRow = $objWorksheet->getHighestRow ();
//取得excel的总列数
        $highestColumn = $objWorksheet->getHighestColumn ();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString ( $highestColumn ) -1;
        $excelData = array ();
        for($row = 2; $row <= $highestRow; $row++) {
            for($col = 0; $col < $highestColumnIndex; $col++) {
                $excelData[$row-2][] = $objWorksheet->getCellByColumnAndRow ( $col, $row )->getValue ();
            }
        }
//        echo "<pre>";
//        print_r($excelData);
//        echo "</pre>";
        for ($i=0;$i<count($excelData);$i++)
        {
            $flag = DB::table('lessons')
                ->where('lesson_year','=',$excelData[$i][1])
                ->where('lesson_semester','=',$excelData[$i][2])
                ->where('lesson_teacher_name','=',$excelData[$i][3])
                ->where('lesson_teacher_unit','=',$excelData[$i][4])
                ->update([
                    'lesson_level'=>'关注课程',
                    'assign_group'=>$excelData[$i][5],
                    'lesson_attention_reason'=>$excelData[$i][6]
                ]);
//            Log::write('info',$flag);
//            if ($flag == 0)
//            {
////                如果有一门课导入失败，则将之前成功的课程置为自主听课，并返回错误信息。
//                Log::write('info','caacac');
//
//                for ($k=0;$k<$i;$k++)
//                {
//                    $data = DB::table('lessons')
//                        ->where('lesson_year','=',$excelData[$k][1])
//                        ->where('lesson_semester','=',$excelData[$k][2])
//                        ->where('lesson_teacher_name','=',$excelData[$k][3])
//                        ->where('lesson_teacher_unit','=',$excelData[$k][4])
//                        ->update([
//                            'lesson_type'=>null,
//                            'assign_group'=>'',
//                            'lesson_level'=>'自主听课',
//                            'lesson_attention_reason'=>'',
//                            'lesson_grade'=>null
//                        ]);
//                }
//
//                return Redirect::action('EvalutionController@NecessaryTask')
//                    ->withCookie('mess','导入第'.$excelData[$i][0].'项'.$excelData[$i][4].$excelData[$i][3].
//                        '失败!  请勿重复导入课程或检查课程信息、格式');
//            }
        }
        return Redirect::action('EvalutionController@NecessaryTask')->withCookie('mess','导入关注课程成功');

    }

    public function EvaluatedExport(Request $request)
    {
        $help = new HelpController;
        $year = $request->year;
        $semester = $request->get('semester');

        $TableFlag = $year.'-'.$semester[0];
        //获取版本号
        $postfix = $help->GetCurrentTableName($TableFlag);

        //获取时间范围
        $timeRange = $help->GetTimeByYearSemester($TableFlag);

        $table1 = "front_theory_evaluation".$postfix;
        $table2 = "front_practice_evaluation".$postfix;
        $table3 = "front_physical_evaluation".$postfix;
        $content = "front_contents".$postfix;

        $DataArr1 = DB::table($table1)
            ->where('听课时间','<',$timeRange['time2'])
            ->where('听课时间','>',$timeRange['time1'])
            ->where(function($query){
                $query->orwhere('评价状态','=','已完成')->orwhere('评价状态','=','待提交');
            })
            ->get();
        $DataArr2 = DB::table($table2)
            ->where('听课时间','<',$timeRange['time2'])
            ->where('听课时间','>',$timeRange['time1'])
            ->where(function($query){
                $query->orwhere('评价状态','=','已完成')->orwhere('评价状态','=','待提交');
            })
            ->get();

        $DataArr3 = DB::table($table3)
            ->where('听课时间','<',$timeRange['time2'])
            ->where('听课时间','>',$timeRange['time1'])
            ->where(function($query){
                $query->orwhere('评价状态','=','已完成')->orwhere('评价状态','=','待提交');
            })
            ->get();

        $Head =  DB::table('table_heads')->get();
        $Front = DB::table($content)->where('fid','=','0')->get();

        $DataTable []=Array();
        $DataFirst []=Array();
        $DataSecond []=Array();
        $DataThird []=Array();
        for ($iType=0;$iType<count($Front);$iType++)
        {
            $DataTable[$iType]=$Front[$iType]->text;
            //获取一级菜单
            $IndexFirst = DB::table($content)->where('fid','=',$Front[$iType]->id)->get();
            for ($iF=0;$iF<count($IndexFirst);$iF++)
            {
                $DataFirst[$iType][$iF]=$IndexFirst[$iF]->text;
                $IndexSecond = DB::table($content)->where('fid','=',$IndexFirst[$iF]->id)->get();
                for($iS=0;$iS<count($IndexSecond);$iS++)
                {
                    $DataSecond[$iType][$iF][$iS]=$IndexSecond[$iS]->text;
                    $IndexThird = DB::table($content)->where('fid','=',$IndexSecond[$iS]->id)->get();
                    for($iT=0;$iT<count($IndexThird);$iT++)
                    {
                        $DataThird[$iType][$iF][$iS][$iT]=$IndexThird[$iT]->text;
                    }
                }
            }
        }
        $data = Array(
            '1'=>$DataTable,
            '2'=>$DataFirst,
            '3'=>$DataSecond,
            '4'=>$DataThird,
        );

        // Create new PHPExcel object


        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("BJFU-TETS")->setTitle("Office 2007 XLSX Test Document");
        //set width
//        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('A')->setWidth(20);
//        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('B')->setAutoSize(true);
        //合并
//        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1:C1');
        //表头
        //设置第一个张sheet
//理论教学评价表
        $objPHPExcel->setActiveSheetIndex(0);

//        将头部写入到Excel中，并合并第1,2行
        for ($i=0;$i<count($Head)+1;$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';
            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            if ($i==0)
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart,"id" );
            }
            else{
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart, $Head[$i-1]->head_content);
            }
        }
//        Log::write('info',$data);
        /*
         * data[2][0]:教师授课情况、学生听课情况、其他
         * data[3][0]:授课态度、授课内容、授课方法、课件与板书等等
         * data[4][0]:精神饱满等等
         * */
        $flag2 = count($Head);
        $flag3 = count($Head);
        for($k=0;$k<count($data[2][0]);$k++)
        {
            for($m=0;$m<count($data[3][0][$k]);$m++)
            {
//                计算头部的数量，之后对二级菜单对应的单元格进行合并，注意flag只是第一次开始的位置
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2+1).'1';//+1 ： 从后面那个单元格开始合并
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';

                $flag2=$flag2+count($data[4][0][$k][$m]) ;

                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 - 26).'1';

//                $flag2=$flag2+1;

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart2, $data[3][0][$k][$m]);

//                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][0][$k][$m]);$n++)
                {
                    $flag3 = $flag3 + 1;//+1:从后面那个单元格开始写入内容，+n：n从0开始
                    if($flag3<=25)
                    {
                        $mergeStart3=chr(ord('A')+$flag3 ).'2';
                    }
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-26 ).'2';
//                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart3,$data[4][0][$k][$m][$n]);
                }
            }
        }
//将评价表内容写入Excel中
        for($j=0;$j<count($DataArr1);$j++)
        {
            $i=0;

            foreach ( $DataArr1[$j] as $key => $value)
            {
                if($i>count($Head)-1)//写入具体评价项
                {
//                    Log::write('info',$key);
//                    Log::write('info',$value);
//                    Log::write('info',empty($value));
//                    Log::write('info','*******************');

                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-26).($j+3);

                        if (empty($value) == 1 )
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,'-');
                        else
                        {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$value);

                        }
                        $i++;
                    }
                }else{//写入头部内容
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$j+1);
                    else
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$value);
                    $i++;
                }
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("理论教学评价表");

//实践教学评价表
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);

        for ($i=0;$i<count($Head)+1;$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';
            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            if ($i==0)
            {
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart,"id" );
            }
            else{
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart, $Head[$i-1]->head_content);
            }
        }

        $flag2 = count($Head);
        $flag3 = count($Head);
        for($k=0;$k<count($data[2][1]);$k++)
        {
            for($m=0;$m<count($data[3][1][$k]);$m++)
            {
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2+1).'1';
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';

                $flag2=$flag2+count($data[4][1][$k][$m]) ;
                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 -26).'1';

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart2, $data[3][1][$k][$m]);

//                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][1][$k][$m]);$n++)
                {
                    $flag3=$flag3+1;
                    if($flag3<=25)
                        $mergeStart3=chr(ord('A')+$flag3).'2';
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-26).'2';
//                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart3,$data[4][1][$k][$m][$n]);
                }
            }
        }

        for($j=0;$j<count($DataArr2);$j++)
        {
            $i=0;
            foreach ( $DataArr2[$j] as $key => $value)
            {
                if($i>count($Head)-1)
                {
                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-26).($j+3);
                        if (empty($value) == 1 )
                            $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,'-');
                        else
                        {
                            $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,$value);
                        }
                        $i++;
                    }
                }else{
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,$j+1);
                    else
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,$value);
                    $i++;
                }
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("实践教学评价表");

//体育教学评价表
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);

        for ($i=0;$i<count($Head)+1;$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';
            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            if ($i==0)
            {
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart,"id" );
            }
            else{
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart, $Head[$i-1]->head_content);
            }
        }
        $flag2 = count($Head);
        $flag3 = count($Head);
        for($k=0;$k<count($data[2][2]);$k++)
        {
            for($m=0;$m<count($data[3][2][$k]);$m++)
            {
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2+1).'1';
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';


                $flag2=$flag2+count($data[4][2][$k][$m]) ;
                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 -26).'1';
//                $flag2=$flag2+1;

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart2, $data[3][2][$k][$m]);

//                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][2][$k][$m]);$n++)
                {
                    $flag3=$flag3+1;
                    if($flag3<=25)
                        $mergeStart3=chr(ord('A')+$flag3).'2';
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-26).'2';
//                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart3,$data[4][2][$k][$m][$n]);
                }
            }
        }

        for($j=0;$j<count($DataArr3);$j++)
        {
            $i=0;
            foreach ( $DataArr3[$j] as $key => $value)
            {
                if($i>count($Head)-1)
                {
                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-26).($j+3);
                        if (empty($value) == 1 )
                            $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,'-');
                        else
                        {
                            $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$value);
                        }
                        $i++;
                    }
                }else{
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$j+1);
                    else
                        $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$value);
                    $i++;
                }

            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("体育教学评价表");
        $filename = $year . '学年第' . $semester. '学期督导评课情况汇总表.xls';

        $ua = $_SERVER["HTTP_USER_AGENT"];//探测主机所用内核
        header('Content-Type: application/octet-stream');

        if (preg_match("/Chrome/", $ua)) {//谷歌内核
            iconv("utf-8", "gb2312", $filename);
            header('Content-Disposition: attachment; filename="' . $filename . '"');

        } else if (preg_match("/Firefox/", $ua)) {//火狐内核
            iconv("utf-8", "gb2312", $filename);
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        } else {
            $encoded_filename = urlencode($filename);//ie内核
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function EvaluatedGroupExport(Request $request)
    {
        $help = new HelpController;
        $year = $request->year;
        $semester = $request->get('semester');
        $group = $request->group;

        $TableFlag = $year.'-'.$semester[0];
//        $TableFlag = '2016-2017-1';
//        $group='第四组';
        //获取版本号
        $postfix = $help->GetCurrentTableName($TableFlag);

        //获取时间范围
        $timeRange = $help->GetTimeByYearSemester($TableFlag);


        $table1 = "front_theory_evaluation".$postfix;
        $table2 = "front_practice_evaluation".$postfix;
        $table3 = "front_physical_evaluation".$postfix;
        $content = "front_contents".$postfix;

        $DataArr1 = DB::select('select * from '.$table1.'
where 听课时间<="'.$timeRange['time2'].'" and 听课时间>="'.$timeRange['time1'].'"
and (`评价状态`="已完成" or `评价状态`="待提交")
and (督导id = ANY (
	SELECT DISTINCT user_id from users where users.`group`="'.$group.'"))');

        $DataArr2 = DB::select('select * from '.$table2.'
where 听课时间<="'.$timeRange['time2'].'" and 听课时间>="'.$timeRange['time1'].'"
and (`评价状态`="已完成" or `评价状态`="待提交")
and (督导id = ANY (
	SELECT DISTINCT user_id from users where users.`group`="'.$group.'"))');
        $DataArr3 = DB::select('select * from '.$table3.'
where 听课时间<="'.$timeRange['time2'].'" and 听课时间>="'.$timeRange['time1'].'"
and (`评价状态`="已完成" or `评价状态`="待提交")
and (督导id = ANY (
	SELECT DISTINCT user_id from users where users.`group`="'.$group.'"))');


        $Head =  DB::table('table_heads')->get();
        $Front = DB::table($content)->where('fid','=','0')->get();

        $DataTable []=Array();
        $DataFirst []=Array();
        $DataSecond []=Array();
        $DataThird []=Array();
        for ($iType=0;$iType<count($Front);$iType++)
        {
            $DataTable[$iType]=$Front[$iType]->text;
            //获取一级菜单
            $IndexFirst = DB::table($content)->where('fid','=',$Front[$iType]->id)->get();
            for ($iF=0;$iF<count($IndexFirst);$iF++)
            {
                $DataFirst[$iType][$iF]=$IndexFirst[$iF]->text;
                $IndexSecond = DB::table($content)->where('fid','=',$IndexFirst[$iF]->id)->get();
                for($iS=0;$iS<count($IndexSecond);$iS++)
                {
                    $DataSecond[$iType][$iF][$iS]=$IndexSecond[$iS]->text;
                    $IndexThird = DB::table($content)->where('fid','=',$IndexSecond[$iS]->id)->get();
                    for($iT=0;$iT<count($IndexThird);$iT++)
                    {
                        $DataThird[$iType][$iF][$iS][$iT]=$IndexThird[$iT]->text;
                    }
                }
            }
        }
        $data = Array(
            '1'=>$DataTable,
            '2'=>$DataFirst,
            '3'=>$DataSecond,
            '4'=>$DataThird,
        );

        // Create new PHPExcel object


        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("BJFU-TETS")->setTitle("Office 2007 XLSX Test Document");
        //set width
//        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('A')->setWidth(20);
//        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('B')->setAutoSize(true);
        //合并
//        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1:C1');
        //表头
        //设置第一个张sheet
//理论教学评价表
        $objPHPExcel->setActiveSheetIndex(0);

        for ($i=0;$i<count($Head)+1;$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';
            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            if ($i==0)
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart,"id" );
            }
            else{
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart, $Head[$i-1]->head_content);
            }
        }
        $flag2 = count($Head);
        $flag3 = count($Head);
        for($k=0;$k<count($data[2][0]);$k++)
        {
            for($m=0;$m<count($data[3][0][$k]);$m++)
            {
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2+1).'1';//+1 ： 从后面那个单元格开始合并
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';

                $flag2=$flag2+count($data[4][0][$k][$m]) ;

                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 - 26).'1';

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart2, $data[3][0][$k][$m]);

//                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][0][$k][$m]);$n++)
                {
                    $flag3=$flag3+1;
                    if($flag3<=25)
                        $mergeStart3=chr(ord('A')+$flag3).'2';
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-26).'2';
//                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart3,$data[4][0][$k][$m][$n]);
                }
            }
        }

        for($j=0;$j<count($DataArr1);$j++)
        {
            $i=0;
            foreach ( $DataArr1[$j] as $key => $value)
            {
                if($i>count($Head)-1)
                {
                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-26).($j+3);

                        if (empty($value) == 1 )
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,'-');
                        else
                        {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$value);

                        }
                        $i++;
                    }
                }else{
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$j+1);
                    else
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$value);
                    $i++;
                }
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("理论教学评价表");

//实践教学评价表
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);

        for ($i=0;$i<count($Head);$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';

            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart, $Head[$i]->head_content);
        }
        $flag2 = count($Head);
        $flag3 = count($Head)-1;
        for($k=0;$k<count($data[2][1]);$k++)
        {
            for($m=0;$m<count($data[3][1][$k]);$m++)
            {
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2).'1';
                else if ($flag2==26)
                    $mergeStart2='A'.chr(ord('A')+$flag2-26).'1';
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';

                $flag2=$flag2+count($data[4][1][$k][$m])-1 ;
                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 -25).'1';
                $flag2=$flag2+1;

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart2, $data[3][1][$k][$m]);

//                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][1][$k][$m]);$n++)
                {
                    $flag3=$flag3+1;
                    if($flag3<25)
                        $mergeStart3=chr(ord('A')+$flag3).'2';
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-25).'2';
//                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart3,$data[4][1][$k][$m][$n]);
                }
            }
        }

        for($j=0;$j<count($DataArr2);$j++)
        {
            $i=0;
            foreach ( $DataArr2[$j] as $key => $value)
            {
                if($i>count($Head)-1)
                {
                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else if ($i==26)
                            $cell='A'.chr(ord('A')+$i-26).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-25).($j+3);
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,$value);
                        $i++;
                    }
                }else{
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,$j+1);
                    else
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,$value);
                    $i++;
                }
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("实践教学评价表");

//体育教学评价表
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);

        for ($i=0;$i<count($Head)+1;$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';
            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            if ($i==0)
            {
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart,"id" );
            }
            else{
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart, $Head[$i-1]->head_content);
            }
        }
        $flag2 = count($Head);
        $flag3 = count($Head);
        for($k=0;$k<count($data[2][2]);$k++)
        {
            for($m=0;$m<count($data[3][2][$k]);$m++)
            {
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2+1).'1';
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';


                $flag2=$flag2+count($data[4][2][$k][$m]) ;
                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 -26).'1';

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart2, $data[3][2][$k][$m]);

//                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][2][$k][$m]);$n++)
                {
                    $flag3=$flag3+1;
                    if($flag3<=25)
                        $mergeStart3=chr(ord('A')+$flag3).'2';
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-26).'2';
//                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart3,$data[4][2][$k][$m][$n]);
                }
            }
        }

        for($j=0;$j<count($DataArr3);$j++)
        {
            $i=0;
            foreach ( $DataArr3[$j] as $key => $value)
            {
                if($i>count($Head)-1)
                {
                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-26).($j+3);
                        if (empty($value) == 1 )
                            $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,'-');
                        else
                        {
                            $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$value);
                        }
                        $i++;
                    }
                }else{
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$j+1);
                    else
                        $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$value);
                    $i++;
                }

            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("体育教学评价表");

        // 输出
        $filename = $year . '学年第' . $semester. '学期'.$group.'评课情况汇总表.xls';

        $ua = $_SERVER["HTTP_USER_AGENT"];//探测主机所用内核
        header('Content-Type: application/octet-stream');

        if (preg_match("/Chrome/", $ua)) {//谷歌内核
            iconv("utf-8", "gb2312", $filename);
            header('Content-Disposition: attachment; filename="' . $filename . '"');

        } else if (preg_match("/Firefox/", $ua)) {//火狐内核
            iconv("utf-8", "gb2312", $filename);
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        } else {
            $encoded_filename = urlencode($filename);//ie内核
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function EvaluatedUnitExport(Request $request)
    {
        $help = new HelpController;
        $year = $request->year;
        $semester = $request->get('semester');
        $unit = $request->unit;
        $TableFlag = $year.'-'.$semester[0];
        //获取版本号
        $postfix = $help->GetCurrentTableName($TableFlag);

        //获取时间范围
        $timeRange = $help->GetTimeByYearSemester($TableFlag);

        $table1 = "front_theory_evaluation".$postfix;
        $table2 = "front_practice_evaluation".$postfix;
        $table3 = "front_physical_evaluation".$postfix;
        $content = "front_contents".$postfix;

        $DataArr1 = DB::select('select * from '.$table1.' where 听课时间<"'.$timeRange['time2'].'"
        and 听课时间>"'.$timeRange['time1'].'"
        and (`评价状态`="已完成" or `评价状态`="待提交")
and (课程名称 = ANY (
	SELECT lessons.lesson_name from lessons where lessons.lesson_unit="'.$unit.'"))');

        $DataArr2 = DB::select('select * from '.$table2.'
where 听课时间<"'.$timeRange['time2'].'" and 听课时间>"'.$timeRange['time1'].'"
and (`评价状态`="已完成" or `评价状态`="待提交")
and (课程名称 = ANY (
	SELECT lessons.lesson_name from lessons where lessons.lesson_unit="'.$unit.'"))');

        $DataArr3 = DB::select('select * from '.$table3.'
where 听课时间<"'.$timeRange['time2'].'" and 听课时间>"'.$timeRange['time1'].'"
and (`评价状态`="已完成" or `评价状态`="待提交")
and (课程名称 = ANY (
	SELECT lessons.lesson_name from lessons where lessons.lesson_unit="'.$unit.'"))');

        $Head =  DB::table('table_heads')->get();
        $Front = DB::table($content)->where('fid','=','0')->get();

        $DataTable []=Array();
        $DataFirst []=Array();
        $DataSecond []=Array();
        $DataThird []=Array();
        for ($iType=0;$iType<count($Front);$iType++)
        {
            $DataTable[$iType]=$Front[$iType]->text;
            //获取一级菜单
            $IndexFirst = DB::table($content)->where('fid','=',$Front[$iType]->id)->get();
            for ($iF=0;$iF<count($IndexFirst);$iF++)
            {
                $DataFirst[$iType][$iF]=$IndexFirst[$iF]->text;
                $IndexSecond = DB::table($content)->where('fid','=',$IndexFirst[$iF]->id)->get();
                for($iS=0;$iS<count($IndexSecond);$iS++)
                {
                    $DataSecond[$iType][$iF][$iS]=$IndexSecond[$iS]->text;
                    $IndexThird = DB::table($content)->where('fid','=',$IndexSecond[$iS]->id)->get();
                    for($iT=0;$iT<count($IndexThird);$iT++)
                    {
                        $DataThird[$iType][$iF][$iS][$iT]=$IndexThird[$iT]->text;
                    }
                }
            }
        }
        $data = Array(
            '1'=>$DataTable,
            '2'=>$DataFirst,
            '3'=>$DataSecond,
            '4'=>$DataThird,
        );

        // Create new PHPExcel object


        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("BJFU-TETS")->setTitle("Office 2007 XLSX Test Document");
        //set width
//        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('A')->setWidth(20);
//        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('B')->setAutoSize(true);
        //合并
//        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1:C1');
        //表头
        //设置第一个张sheet
//理论教学评价表
        $objPHPExcel->setActiveSheetIndex(0);

        for ($i=0;$i<count($Head)+1;$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';
            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            if ($i==0)
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart,"id" );
            }
            else{
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart, $Head[$i-1]->head_content);
            }
        }
        $flag2 = count($Head);
        $flag3 = count($Head);
        for($k=0;$k<count($data[2][0]);$k++)
        {
            for($m=0;$m<count($data[3][0][$k]);$m++)
            {
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2+1).'1';//+1 ： 从后面那个单元格开始合并
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';

                $flag2=$flag2+count($data[4][0][$k][$m]) ;

                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 - 26).'1';

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart2, $data[3][0][$k][$m]);

//                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][0][$k][$m]);$n++)
                {
                    $flag3=$flag3+1;
                    if($flag3<=25)
                        $mergeStart3=chr(ord('A')+$flag3).'2';
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-26).'2';
//                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart3,$data[4][0][$k][$m][$n]);
                }
            }
        }

        for($j=0;$j<count($DataArr1);$j++)
        {
            $i=0;
            foreach ( $DataArr1[$j] as $key => $value)
            {
                if($i>count($Head)-1)
                {
                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-26).($j+3);

                        if (empty($value) == 1 )
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,'-');
                        else
                        {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$value);

                        }
                        $i++;
                    }
                }else{//写入头部内容
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$j+1);
                    else
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$value);
                    $i++;
                }
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("理论教学评价表");

//实践教学评价表
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);

        for ($i=0;$i<=count($Head);$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';
            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            if ($i==0)
            {
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart,"id" );
            }
            else{
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart, $Head[$i-1]->head_content);
            }
        }
        $flag2 = count($Head);
        $flag3 = count($Head)-1;
        for($k=0;$k<count($data[2][1]);$k++)
        {
            for($m=0;$m<count($data[3][1][$k]);$m++)
            {
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2).'1';
                else if ($flag2==26)
                    $mergeStart2='A'.chr(ord('A')+$flag2-26).'1';
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';

                $flag2=$flag2+count($data[4][1][$k][$m])-1 ;
                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 -25).'1';
                $flag2=$flag2+1;

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart2, $data[3][1][$k][$m]);

//                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][1][$k][$m]);$n++)
                {
                    $flag3=$flag3+1;
                    if($flag3<25)
                        $mergeStart3=chr(ord('A')+$flag3).'2';
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-25).'2';
//                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart3,$data[4][1][$k][$m][$n]);
                }
            }
        }

        for($j=0;$j<count($DataArr2);$j++)
        {
            $i=0;
            foreach ( $DataArr2[$j] as $key => $value)
            {
                if($i>count($Head)-1)
                {
                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else if ($i==26)
                            $cell='A'.chr(ord('A')+$i-26).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-25).($j+3);
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,$value);
                        $i++;
                    }
                }else{
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,$j+1);
                    else
                        if ($i==9)//院级导出隐藏督导姓名
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,'***');
                        else{
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$value);
                        }
                    $i++;
                }
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("实践教学评价表");

//体育教学评价表
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);

        for ($i=0;$i<count($Head)+1;$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';
            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            if ($i==0)
            {
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart,"id" );
            }
            else{
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart, $Head[$i-1]->head_content);
            }
        }
        $flag2 = count($Head);
        $flag3 = count($Head);
        for($k=0;$k<count($data[2][2]);$k++)
        {
            for($m=0;$m<count($data[3][2][$k]);$m++)
            {
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2+1).'1';
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';


                $flag2=$flag2+count($data[4][2][$k][$m]) ;
                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 -26).'1';

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart2, $data[3][2][$k][$m]);

//                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][2][$k][$m]);$n++)
                {
                    $flag3=$flag3+1;
                    if($flag3<=25)
                        $mergeStart3=chr(ord('A')+$flag3).'2';
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-26).'2';
//                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart3,$data[4][2][$k][$m][$n]);
                }
            }
        }

        for($j=0;$j<count($DataArr3);$j++)
        {
            $i=0;
            foreach ( $DataArr3[$j] as $key => $value)
            {
                if($i>count($Head)-1)
                {
                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-26).($j+3);
                        if (empty($value) == 1 )
                            $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,'-');
                        else
                        {
                            $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$value);
                        }
                        $i++;
                    }
                }else{
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$j+1);
                    else
                        $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$value);
                    $i++;
                }

            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("体育教学评价表");

        $filename = $year .'学年第' .$semester. '学期'.$unit.'评课情况汇总表.xls';
        iconv("utf-8", "gb2312", $filename);
        // 输出
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function EvaluatedPersonExport(Request $request)
    {
        $help = new HelpController;
        $year = $request->year;
        $semester = $request->get('semester');
        $superid = $request->get('superid');
        $supername= $request->get('supername');


        $TableFlag = $year.'-'.$semester[0];
        //获取版本号
        $postfix = $help->GetCurrentTableName($TableFlag);

        //获取时间范围
        $timeRange = $help->GetTimeByYearSemester($TableFlag);

        $table1 = "front_theory_evaluation".$postfix;
        $table2 = "front_practice_evaluation".$postfix;
        $table3 = "front_physical_evaluation".$postfix;
        $content = "front_contents".$postfix;

        $DataArr1 = DB::table($table1)
            ->where('听课时间','<',$timeRange['time2'])
            ->where('听课时间','>',$timeRange['time1'])
            ->where('督导id','=',$superid)
            ->where(function($query){
                $query->orwhere('评价状态','=','已完成')->orwhere('评价状态','=','待提交');
            })
            ->get();
        $DataArr2 = DB::table($table2)
            ->where('听课时间','<',$timeRange['time2'])
            ->where('听课时间','>',$timeRange['time1'])
            ->where('督导id','=',$superid)
            ->where(function($query){
                $query->orwhere('评价状态','=','已完成')->orwhere('评价状态','=','待提交');
            })

            ->get();
        $DataArr3 = DB::table($table3)
            ->where('听课时间','<',$timeRange['time2'])
            ->where('听课时间','>',$timeRange['time1'])
            ->where('督导id','=',$superid)
            ->where(function($query){
                $query->orwhere('评价状态','=','已完成')->orwhere('评价状态','=','待提交');
            })
            ->get();
        $Head =  DB::table('table_heads')->get();
        $Front = DB::table($content)->where('fid','=','0')->get();

        $DataTable []=Array();
        $DataFirst []=Array();
        $DataSecond []=Array();
        $DataThird []=Array();
        for ($iType=0;$iType<count($Front);$iType++)
        {
            $DataTable[$iType]=$Front[$iType]->text;
            //获取一级菜单
            $IndexFirst = DB::table($content)->where('fid','=',$Front[$iType]->id)->get();
            for ($iF=0;$iF<count($IndexFirst);$iF++)
            {
                $DataFirst[$iType][$iF]=$IndexFirst[$iF]->text;
                $IndexSecond = DB::table($content)->where('fid','=',$IndexFirst[$iF]->id)->get();
                for($iS=0;$iS<count($IndexSecond);$iS++)
                {
                    $DataSecond[$iType][$iF][$iS]=$IndexSecond[$iS]->text;
                    $IndexThird = DB::table($content)->where('fid','=',$IndexSecond[$iS]->id)->get();
                    for($iT=0;$iT<count($IndexThird);$iT++)
                    {
                        $DataThird[$iType][$iF][$iS][$iT]=$IndexThird[$iT]->text;
                    }
                }
            }
        }
        $data = Array(
            '1'=>$DataTable,
            '2'=>$DataFirst,
            '3'=>$DataSecond,
            '4'=>$DataThird,
        );

        // Create new PHPExcel object


        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("BJFU-TETS")->setTitle("Office 2007 XLSX Test Document");
        //set width
//        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('A')->setWidth(20);
//        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('B')->setAutoSize(true);
        //合并
//        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1:C1');
        //表头
        //设置第一个张sheet
//理论教学评价表
        $objPHPExcel->setActiveSheetIndex(0);


        for ($i=0;$i<=count($Head);$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';
            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            if ($i==0)
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart,"id" );
            }
            else{
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart, $Head[$i-1]->head_content);
            }
        }

        $flag2 = count($Head);
        $flag3 = count($Head);
        for($k=0;$k<count($data[2][0]);$k++)
        {
            for($m=0;$m<count($data[3][0][$k]);$m++)
            {
                //                计算头部的数量，之后对二级菜单对应的单元格进行合并，注意flag只是第一次开始的位置
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2+1).'1';//+1 ： 从后面那个单元格开始合并
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';

                $flag2=$flag2+count($data[4][0][$k][$m]) ;

                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 -26).'1';
//                        $flag2=$flag2+1;

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart2, $data[3][0][$k][$m]);

                //                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][0][$k][$m]);$n++)
                {
                    $flag3=$flag3+1;
                    if($flag3<=25)
                        $mergeStart3=chr(ord('A')+$flag3).'2';
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-26).'2';
                    //                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($mergeStart3,$data[4][0][$k][$m][$n]);
                }
            }
        }
//        j代表行数， i代表第几列
        for($j=0;$j<count($DataArr1);$j++)
        {
            $i=0;
            foreach ( $DataArr1[$j] as $key => $value)
            {
                if($i>count($Head)-1)
                {
                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-26).($j+3);

                        if (empty($value) == 1 )
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,'-');
                        else
                        {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$value);

                        }
                        $i++;
                    }
                }else{
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$j+1);
                    else
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell,$value);
                    $i++;
                }
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("理论教学评价表");

        //实践教学评价表
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);


        for ($i=0;$i<=count($Head);$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';
            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            if ($i==0)
            {
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart,"id" );
            }
            else{
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart, $Head[$i-1]->head_content);
            }
        }

        $flag2 = count($Head);
        $flag3 = count($Head)-1;
        for($k=0;$k<count($data[2][1]);$k++)
        {
            for($m=0;$m<count($data[3][1][$k]);$m++)
            {
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2).'1';
                else if ($flag2==26)
                    $mergeStart2='A'.chr(ord('A')+$flag2-26).'1';
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';

                $flag2=$flag2+count($data[4][1][$k][$m])-1 ;
                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 -25).'1';
                $flag2=$flag2+1;

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart2, $data[3][1][$k][$m]);

                //                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][1][$k][$m]);$n++)
                {
                    $flag3=$flag3+1;
                    if($flag3<25)
                        $mergeStart3=chr(ord('A')+$flag3).'2';
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-25).'2';
                    //                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue($mergeStart3,$data[4][1][$k][$m][$n]);
                }
            }
        }

        for($j=0;$j<count($DataArr2);$j++)
        {
            $i=0;
            foreach ( $DataArr2[$j] as $key => $value)
            {
                if($i>count($Head)-1)
                {
                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else if ($i==26)
                            $cell='A'.chr(ord('A')+$i-26).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-25).($j+3);
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,$value);
                        $i++;
                    }
                }else{
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,$j+1);
                    else
                        $objPHPExcel->setActiveSheetIndex(1)->setCellValue($cell,$value);
                    $i++;
                }
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("实践教学评价表");

        //体育教学评价表
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);

        for ($i=0;$i<count($Head)+1;$i++)
        {
            $mergeStart=chr(ord('A')+$i).'1';
            $mergeEnd=chr(ord('A')+$i).'2';
            $objPHPExcel->getActiveSheet()->mergeCells($mergeStart.':'.$mergeEnd);
            if ($i==0)
            {
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart,"id" );
            }
            else{
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart, $Head[$i-1]->head_content);
            }
        }
        $flag2 = count($Head);
        $flag3 = count($Head);
        for($k=0;$k<count($data[2][2]);$k++)
        {
            for($m=0;$m<count($data[3][2][$k]);$m++)
            {
                if($flag2<=25)
                    $mergeStart2=chr(ord('A')+$flag2+1).'1';
                else
                    $mergeStart2='A'.chr(ord('A')+$flag2-25).'1';


                $flag2=$flag2+count($data[4][2][$k][$m]) ;
                if($flag2<=25)
                    $mergeEnd2=chr( ord('A')+ $flag2 ).'1';
                else
                    $mergeEnd2='A'.chr( ord('A')+ $flag2 -26).'1';

                $objPHPExcel->getActiveSheet()->mergeCells($mergeStart2.':'.$mergeEnd2);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart2, $data[3][2][$k][$m]);

                //                echo $flag2.':'.$m.':'.$mergeStart2.'到'.$mergeEnd2.'：'.$data[3][0][$k][$m].'</br>';

                for ($n=0;$n<count($data[4][2][$k][$m]);$n++)
                {
                    $flag3=$flag3+1;
                    if($flag3<=25)
                        $mergeStart3=chr(ord('A')+$flag3).'2';
                    else
                        $mergeStart3='A'.chr(ord('A')+$flag3-26).'2';
                    //                    echo $flag3.':'.$n.':'.$mergeStart.':'.$data[4][0][$k][$m][$n].'</br>';
                    $objPHPExcel->setActiveSheetIndex(2)->setCellValue($mergeStart3,$data[4][2][$k][$m][$n]);
                }
            }
        }

        for($j=0;$j<count($DataArr3);$j++)
        {
            $i=0;
            foreach ( $DataArr3[$j] as $key => $value)
            {
                if($i>count($Head)-1)
                {
                    if ($value != null)
                    {
                        if($i<=25)
                            $cell=chr(ord('A')+$i).($j+3);
                        else
                            $cell='A'.chr(ord('A')+$i-26).($j+3);
                        if (empty($value) == 1 )
                            $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,'-');
                        else
                        {
                            $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$value);
                        }
                        $i++;
                    }
                }else{
                    $cell=chr(ord('A')+$i).($j+3);
                    if($i==0)//如果是第一列，将value ID替换成id
                        $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$j+1);
                    else
                        $objPHPExcel->setActiveSheetIndex(2)->setCellValue($cell,$value);
                    $i++;
                }

            }
        }

        $objPHPExcel->getActiveSheet()->setTitle("体育教学评价表");

        // 输出
        $filename = $year .'学年第'.$semester.'学期'.$supername.'督导评课情况汇总表.xls';


        $ua = $_SERVER["HTTP_USER_AGENT"];//探测主机所用内核
        header('Content-Type: application/octet-stream');

        if (preg_match("/Chrome/", $ua)) {//谷歌内核
            iconv("utf-8", "gb2312", $filename);
            header('Content-Disposition: attachment; filename="' . $filename . '"');

        } else if (preg_match("/Firefox/", $ua)) {//火狐内核
            iconv("utf-8", "gb2312", $filename);
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        } else {
            $encoded_filename = urlencode($filename);//ie内核
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function StaticExport(Request $request)
    {
        $help = new HelpController;
        $year = $request->year;
        $semester = $request->get('semester');

        //确定三个评价表版本号
        $TableFlag = $year."-".$semester[0];
//        $TableFlag='2016-2017-1';
        $VersionNum = $help->GetCurrentTableName($TableFlag);

        $timeInterval = $help->GetTimeByYearSemester($TableFlag);
        $table1 = 'front_theory_evaluation'.$VersionNum;
        $table2 = 'front_practice_evaluation'.$VersionNum;
        $table3 = 'front_physical_evaluation'.$VersionNum;


        //获取小组组长以及组员名单
        $ids = array('"第一组"', '"第二组"', '"第三组"', '"第四组"');
        $ids_ordered = implode(',', $ids);

        $GroupData = Role::find(4)//在roles表中，4号对应的小组长
        ->users()->select('users.user_id','users.name','users.group')
            ->where( 'supervise_time' ,'=' ,$TableFlag )
            ->orderByRaw(DB::raw("FIELD(users.group, $ids_ordered)"))
            ->get();
        $GroupAdmin =[];
        foreach($GroupData as $user)
            array_push($GroupAdmin, $user['attributes']);

        $GroupNum = [];
        for ($i=0;$i<count($GroupAdmin);$i++)
        {
            $GroupNum[$i] = Role::find(5)//在roles表中，4号对应的小组长
            ->users()->select('users.user_id','users.name','users.group','users.workstate')
                ->where( 'supervise_time' ,'=' ,$TableFlag )
                ->where( 'users.group' ,'=' ,$GroupAdmin[$i]['group'] )
                ->where('status','=','活跃')
                ->get();
        }
        //遍历三张表，获取各督导保存的课程评价数目
        for ($i=0;$i<count($GroupAdmin);$i++)
        {
            for ($j=0;$j<count($GroupNum[$i]);$j++)
            {
                //待提交次数
                $a = DB::table($table1)
                    ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                    ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                    ->where('评价状态','like','待提交%')->count();
                $a = $a+DB::table($table2)
                        ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                        ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                        ->where('评价状态','like','待提交%')->count();
                $a = $a+DB::table($table3)
                        ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                        ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                        ->where('评价状态','like','待提交%')->count();

                $GroupNum[$i][$j]->save=$a;

                //已完成次数
                $b = DB::table($table1)
                    ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                    ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                    ->where('评价状态','=','已完成')->count();
                $b = $b+DB::table($table2)
                        ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                        ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                        ->where('评价状态','=','已完成')->count();
                $b = $b+DB::table($table3)
                        ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                        ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                        ->where('评价状态','=','已完成')->count();

                $GroupNum[$i][$j]->finish=$b;
                //已完成的（多节课程）课程节数

                $timesA1=$help->Evalued_LessonTimes($table1,$GroupNum[$i][$j]->user_id,'已完成',$timeInterval);//挺多节课的情况;
                $timesA2=$help->Evalued_LessonTimes($table2,$GroupNum[$i][$j]->user_id,'已完成', $timeInterval);//挺多节课的情况
                $timesA3=$help->Evalued_LessonTimes($table3,$GroupNum[$i][$j]->user_id,'已完成', $timeInterval);//挺多节课的情况

                $GroupNum[$i][$j]->listened=$timesA1['num']+$timesA2['num']+$timesA3['num']+$b;//多节课计算总数
                $GroupNum[$i][$j]->listened_two=$timesA1['two']+$timesA2['two']+$timesA3['two'];//连听两节课的数量
                $GroupNum[$i][$j]->listened_three=$timesA1['three']+$timesA2['three']+$timesA3['three'];//连听三节课的数量
                $GroupNum[$i][$j]->listened_four=$timesA1['four']+$timesA2['four']+$timesA3['four'];//连听四节课的数量
                $GroupNum[$i][$j]->listened_one=$b
                    -$GroupNum[$i][$j]->listened_two
                    -$GroupNum[$i][$j]->listened_three
                    -$GroupNum[$i][$j]->listened_four;//只听一节课的数量

            }
        }


        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("BJFU-DFI")->setTitle("Office 2007 XLSX Test Document");
        //set width
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);

        //居中
        //表头
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '督导ID')
            ->setCellValue('B1', '督导姓名')
            ->setCellValue('C1', '督导所在组')
            ->setCellValue('D1', '督导属性')
            ->setCellValue('E1', '听课次数')
            ->setCellValue('F1', '完成总课时')
            ->setCellValue('G1', '只听1节课')
            ->setCellValue('H1', '连听2节课')
            ->setCellValue('I1', '连听3节课')
            ->setCellValue('J1', '连听4节课');

        $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray(
            array(
                'font' => array (
                    'bold' => true
                ),
                'alignment' => array (
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER ,
                ),
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A:J')->applyFromArray(
            array(
                'alignment' => array (
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER ,
                ),
            )
        );


        $flag = 2;
        for ($i = 0; $i < count($GroupAdmin); $i++)
        {
            for ($j=0;$j<count($GroupNum[$i]);$j++)
            {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $flag, $GroupNum[$i][$j]->user_id)
                    ->setCellValue('B' . $flag, $GroupNum[$i][$j]->name)
                    ->setCellValue('C' . $flag, $GroupNum[$i][$j]->group)
                    ->setCellValue('D' . $flag, $GroupNum[$i][$j]->workstate)
                    ->setCellValue('E' . $flag, $GroupNum[$i][$j]->finish)
                    ->setCellValue('F' . $flag, $GroupNum[$i][$j]->listened)
                    ->setCellValue('G' . $flag, $GroupNum[$i][$j]->listened_one)
                    ->setCellValue('H' . $flag, $GroupNum[$i][$j]->listened_two)
                    ->setCellValue('I' . $flag, $GroupNum[$i][$j]->listened_three)
                    ->setCellValue('J' . $flag, $GroupNum[$i][$j]->listened_four);
                $flag++;
            }
            //统计每组听课次数总数
            $groupSumFinished = 0;
            $groupSumlistened = 0;
            for ($m=0;$m<count($GroupNum[$i]);$m++)
            {
                $groupSumFinished = $groupSumFinished + $GroupNum[$i][$m]->finish;
                $groupSumlistened = $groupSumlistened + $GroupNum[$i][$m]->listened;

            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $flag, '合计');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $flag, $groupSumFinished);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $flag, $groupSumlistened);
            $flag=$flag+2;

        }


        $objPHPExcel->getActiveSheet()->setTitle("1");
        $objPHPExcel->setActiveSheetIndex(0);
        // 输出
        $filename = $year . '学年第' . $semester. '学期督导听课统计.xls';
        $ua = $_SERVER["HTTP_USER_AGENT"];//探测主机所用内核
        header('Content-Type: application/octet-stream');

        if (preg_match("/Chrome/", $ua)) {//谷歌内核
            iconv("utf-8", "gb2312", $filename);
            header('Content-Disposition: attachment; filename="' . $filename . '"');

        } else if (preg_match("/Firefox/", $ua)) {//火狐内核
            iconv("utf-8", "gb2312", $filename);
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        } else {
            $encoded_filename = urlencode($filename);//ie内核
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
