<?php

namespace App\Http\Controllers\LessonTable;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PinYinController;
class LessonTableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['only',['LessonTable']]);
    }
    public function LessonTable()
    {
        return view('LessonTable');
    }
    public function LessonTeacher(Request $request)
    {
        $unit = $request->unit;
        $time = $request->time;
        $semester=$request->semester;


        $TeacherName = DB::table('lessons')
            ->select('lesson_teacher_name')
            ->where('lesson_year','=',$time)
            ->where('lesson_semester','=',$semester)
            ->where('lesson_teacher_unit','=',$unit)
            ->distinct()
            ->get();

        $Teacher = [];
        $Letter = [];
        for ($k=0; $k<count($TeacherName); $k++)
        {
            $PinYin = new PinYinController;
            $letter =$TeacherName[$k]->lesson_teacher_name;

            $obj = [
                'Letter' => $PinYin->getFirstOnePY($letter),
                'Name' => $TeacherName[$k]->lesson_teacher_name
            ];

            array_push($Teacher, $obj);
            array_push($Letter,  $PinYin->getFirstOnePY($letter));
        }

        usort($Teacher,array($this,"sortType"));
        sort($Letter);

        $Letter=array_unique($Letter);

        $newArray = array(
            'Index'=>$Letter,
            'Value'=>$Teacher
        );
        return $newArray;
    }
//教师姓名字母排序
    private function sortType($a, $b)
    {
        if ($a['Letter'] >= $b['Letter'])
            return 1;
        else
            return -1;
    }


    public function Lesson(Request $request)
    {
        $year = $request->year;
        $name = $request->name;
        $unit = $request->unit;
        $semester = $request->semester;
        $Lesson = DB::table('lessons')
            ->where('lesson_teacher_unit','=',$unit)
            ->where('lesson_teacher_name','=',$name)
            ->where('lesson_year','=',$year)
            ->where('lesson_semester','=',$semester)
            ->distinct()
            ->get();

        if ($Lesson==null)
        {
            $Lesson = DB::table('lessons')
                ->where('lesson_teacher_name','=',$name)
                ->where('lesson_year','=',$year)
                ->where('lesson_semester','=',$semester)
                ->distinct()
                ->get();
        }
        return $Lesson;
    }
}
