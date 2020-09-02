<?php

namespace App\Http\Controllers;

use App\Application;
use App\Course;
use App\Document;
use App\Offer;
use App\Student;
use App\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $student->counselor=$request->counselor;
        $student->save();

        return redirect()->back()->with('message','successfully registered student');
    }
    public function document_received_form(){
        $student=Student::select('st_id')->get();
        return view('counselor.document_recived')->with('student',$student);
    }
    public function document_received_check(Request $request){

        $result=Student::Where('st_id',$request->student_id)->first();

        return response()->json($result);
    }
    public function document_received(Request $request){

        $student=new Document;
        $student->student_id=$request->student_id;
        $student->ol=$request->ol;
        $student->al=$request->al;
        $student->ielts=$request->ielts;
        $student->service = $request->service;
        $student->remark=$request->remark;

        if (request()->has('file')) {
            $profileImage = request()->file('file');
            $profileSaveAsName = time() . Auth::id() . "-file." .
                $profileImage->getClientOriginalExtension();

            $public_path = 'document/';
            $profile_image_url = $public_path . $profileSaveAsName;
            $profileImage->move($public_path, $profileSaveAsName);
            $student->document = $profile_image_url;
            $student->save();
            return redirect()->back()->with('message','Document received');
        }else{
            $student->save();
            return redirect()->back()->with('message','Document received');
        }
    }
    public function application_received_form(){
        $course=Course::all();
        $student=Student::select('st_id')->get();
        return view('counselor.application_received')->with(['course'=>$course,'student'=>$student]);
    }

    public function application_received(Request $request){
        $student = new Application;
        $student->studentap_id=$request->student_id;
        $student->course_interested	= $request->course_id;
        $student->date_applied =$request->date;

        if (request()->has('file')) {
            $profileImage = request()->file('file');
            $profileSaveAsName = time() . Auth::id() . "-file." .
                $profileImage->getClientOriginalExtension();

            $public_path = 'document/';
            $profile_image_url = $public_path . $profileSaveAsName;
            $profileImage->move($public_path, $profileSaveAsName);
            $student->upload = $profile_image_url;
            $student->save();
            return redirect()->back()->with('message','Application received');
        }else{
            $student->save();
            return redirect()->back()->with('message','Application received');
        }
    }
    public function offer_received_form(){
        $course=Course::all();
        $student=Student::select('st_id')->get();
        return view('counselor.offer_received')->with(['course'=>$course,'student'=>$student]);
    }
    public function offer_received(Request $request){
        $student=new Offer;
        $student->studentof_id=$request->student_id;
        $student->offer_date=$request->date;
        $student->semester=$request->semester;
        $student->in_date=$request->in_date;
        $student->course_id=$request->course_id;
        if (request()->has('file')) {
            $profileImage = request()->file('file');
            $profileSaveAsName = time() . Auth::id() . "-file." .
                $profileImage->getClientOriginalExtension();

            $public_path = 'document/';
            $profile_image_url = $public_path . $profileSaveAsName;
            $profileImage->move($public_path, $profileSaveAsName);
            $student->upload = $profile_image_url;
            $student->save();
            return redirect()->back()->with('message','Offers received');
        }else{
            $student->save();
            return redirect()->back()->with('message','Offers received');
        }
    }

}









