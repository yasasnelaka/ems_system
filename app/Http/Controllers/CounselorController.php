<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;
use App\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use function Sodium\increment;

class CounselorController extends Controller
{
    public function counselor(){
        return view('counselor.counselor');
    }
    public function student_register_form(){
        $course=Course::all();
        $student=Student::max('id');
       $id=$student+1;
        //$id = IdGenerator::generate(['table' => 'students', 'length' =>5, 'prefix' =>$student]);


        return view('counselor.student_register')->with(['course'=>$course,'id'=>$id]);
    }

    public function Student_register(Request $request){
        $student=new Student;
        $student->st_id = $request->student_id;
        $student->course_interested=$request->course_id;
        $student->name= $request->name;
        $student->surname = $request->surname;
        $student->nic= $request->nic;
        $student->email = $request->email;
        $student->tel = $request->tel;
        $student->mobile_number = $request->mobile;
        $student->address = $request->address;
        $student->city = $request->city;
        $student->dob = $request->dob;
        $student->gender = $request->gender;
        $student->save();

        return redirect()->back()->with('message','successfully registered student');
    }
}
