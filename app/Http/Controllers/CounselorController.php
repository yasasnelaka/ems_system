<?php

namespace App\Http\Controllers;

use App\Application;
use App\Course;
use App\Document;
use App\Offer;
use App\Student;
use PDF;
use Excel;
use App\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        $ldate = date('Y-m-d');
        $student=new Document;
        $student->date=$ldate;
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


    public function initial_enquiry()
    {
        $course = Course::all();
        $student = Student::leftjoin('offers', 'offers.studentof_id','=' ,'students.st_id')
            ->leftjoin('users', 'users.id','=','students.counselor')
            ->leftjoin('courses', 'courses.id','=','students.course_interested')
            ->select('courses.course_name','students.*','users.full_name')
            ->get();
        return view('counselor.initial_enquiry_report')->with(['student' => $student, 'course' => $course]);
    }

    public function find(Request $request)
    {
        $course = Course::all();
        $student = Student::leftjoin('offers', 'offers.studentof_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->where(function ($query) use ($request) {
                if (!empty($request->student_id)) {
                    $query->Where('st_id', $request->student_id);
                }
                if (!empty($request->name)) {
                    $query->where('name', $request->name);
                }
                if (!empty($request->surname)) {
                    $query->where('surname', $request->surname);
                }
                if (!empty($request->course_id)) {
                    $query->where('course_interested', $request->course_id);
                }
                if (!empty($request->mobile)) {
                    $query->where('mobile_number', $request->mobile);
                }
                if (!empty($request->from_in_date)) {
                    $query->where('in_date', '>=', $request->from_in_date);
                }
                if (!empty($request->to_in_date)) {
                    $query->where('in_date', '<=', $request->to_in_date);
                }
            })
            ->get();
        return view('counselor.initial_enquiry_report')->with(['student' => $student, 'course' => $course]);
    }


    public function pdf(Request $request)
    {

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_customer_data_to_html($request));
        return $pdf->stream();
    }

    public function convert_customer_data_to_html(Request $request)
    {

        $student = Student::leftjoin('offers', 'offers.studentof_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->get();

        $output = '<table  class="table" style="font-size: small">
         
            <tr>
                <th scope="col">Student ID</th>
                <th scope="col">Student Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Nic</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile</th>
                <th scope="col">Enquiry Date</th>
                <th scope="col">Counselor Name</th>
                <th scope="col">Interested Course</th>
            </tr>';
        foreach ($student as $student) {
            $output .= '<tr>
                    <td>' . $student->st_id . '</td>
                    <td>' . $student->name . '</td>
                    <td>' . $student->surname . '</td>
                    <td>' . $student->nic . '</td>
                    <td>' . $student->email . '</td>
                    <td>' . $student->mobile_number . '</td>
                    <td>' . $student->updated_at . '</td>
                    <td>' . $student->full_name . '</td>
                    <td>' . $student->course_name . '</td>
                </tr>
        ';
        }
        $output .= '</table>';

        return $output;

    }

    public function offer_received_all()
    {
        $course = Course::all();
        $student = Student::leftjoin('offers', 'offers.studentof_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->get();
        return view('counselor.offer_received_report')->with(['course' => $course, 'student' => $student]);
    }

    public function offer_find(Request $request)
    {
        $course = Course::all();
        $student = Student::leftjoin('offers', 'offers.studentof_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->where(function ($query) use ($request) {
                if (!empty($request->student_id)) {
                    $query->Where('st_id', $request->student_id);
                }
                if (!empty($request->name)) {
                    $query->where('name', $request->name);
                }
                if (!empty($request->course_id)) {
                    $query->where('course_interested', $request->course_id);
                }
                if (!empty($request->mobile)) {
                    $query->where('mobile_number', $request->mobile);
                }
                if (!empty($request->from_in_date)) {
                    $query->where('offer_date', '>=', $request->from_in_date);
                }
                if (!empty($request->to_in_date)) {
                    $query->where('offer_date', '<=', $request->to_in_date);
                }
            })
            ->get();
        return view('counselor.offer_received_report')->with(['student' => $student, 'course' => $course]);
    }

    public function pdf_offer(Request $request)
    {

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->Offer_data_to_html($request));
        return $pdf->stream();
    }

    public function offer_data_to_html(Request $request)
    {

        $student = Student::leftjoin('offers', 'offers.studentof_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->get();

        $output = '<table  class="table">
         
            <tr>
                 <th scope="col">Student ID</th>
                <th scope="col">Student Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Nic</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile</th>
                <th scope="col">Offer received Date</th>
                <th scope="col">Course Name</th>
                <th scope="col">Inteke semester</th>
                <th scope="col">Inteke Date</th>
                <th scope="col">Uploaded Document</th>
                <th scope="col">Counselor name</th>
            </tr>';
        foreach ($student as $student) {
            $output .= '<tr>
                    <td>'.$student->st_id.'</td>
                    <td>'.$student->name.'</td>
                    <td>'.$student->surname.'</td>
                    <td>'.$student->nic.'</td>
                    <td>'.$student->email.'</td>
                    <td>'.$student->mobile_number.'</td>
                    <td>'.$student->offer_date.'</td>
                    <td>'.$student->course_name.'</td>
                    <td>'.$student->in_date.'</td>
                    <td><a href="../../'.$student->upload.'">Document</a></td>
                    <td>{{$student->full_name}}</td>
                </tr>
        ';
        }
        $output .= '</table>';

        return $output;

    }
    public function application_report(){
        $course = Course::all();
        $student = Student::leftjoin('applications', 'applications.studentap_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->get();
        return view('counselor.application_report')->with(['course' => $course, 'student' => $student]);
    }
    public function application_find(Request $request){
        $course = Course::all();
        $student = Student::leftjoin('applications', 'applications.studentap_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->where(function ($query) use ($request) {
                if (!empty($request->student_id)) {
                    $query->Where('st_id', $request->student_id);
                }
                if (!empty($request->name)) {
                    $query->where('name', $request->name);
                }

                if (!empty($request->course_id)) {
                    $query->where('course_interested', $request->course_id);
                }
                if (!empty($request->mobile)) {
                    $query->where('mobile_number', $request->mobile);
                }
                if (!empty($request->from_in_date)) {
                    $query->where('date_applied', '>=', $request->from_in_date);
                }
                if (!empty($request->to_in_date)) {
                    $query->where('date_applied', '<=', $request->to_in_date);
                }
            })
            ->get();
        return view('counselor.application_report')->with(['student' => $student, 'course' => $course]);
    }
    public function pdf_application(Request $request){


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->application_data_to_html($request));
        return $pdf->stream();
    }

    public function application_data_to_html(Request $request)
    {

        $student = Student::leftjoin('applications', 'applications.studentap_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->get();

        $output = '<table  class="table">
         
            <tr>
                <th scope="col">Student ID</th>
                <th scope="col">Student Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Nic</th>
                <th scope="col">Mobile</th>
                <th scope="col">Date applied</th>
                <th scope="col">Course Name</th>
                <th scope="col">Uploaded Document</th>
                <th scope="col">Counselor name</th>
            </tr>';
        foreach ($student as $student) {
            $output .= '<tr>
                    <td>'.$student->st_id.'</td>
                    <td>'.$student->name.'</td>
                    <td>'.$student->surname.'</td>
                    <td>'.$student->nic.'</td>
                    <td>'.$student->mobile_number.'</td>
                    <td>'.$student->date_applied.'</td>
                    <td>'.$student->course_name.'</td>
                    <td><a href="../../'.$student->upload.'">Document</a></td>
                    <td>'.$student->full_name.'</td>
                </tr>
        ';
        }
        $output .= '</table>';

        return $output;
    }
    public function summary_report(){
        $student = Student::leftjoin('documents', 'documents.student_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('applications', 'applications.studentap_id', 'students.st_id')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->leftjoin('offers', 'offers.studentof_id', 'students.st_id')
            ->select('applications.upload as aupload','offers.upload as oupload','students.*','documents.document')
            ->get();
        return view('counselor.summary_report')->with(['student' => $student]);
    }
    public function summary_find(Request $request){
        $course = Course::all();
        $student = Student::leftjoin('documents', 'documents.student_id','=','students.st_id')
            ->leftjoin('users', 'users.id', '=','students.counselor')
            ->leftjoin('applications', 'applications.studentap_id','=', 'students.st_id')
            ->leftjoin('courses', 'courses.id', '=','students.course_interested')
            ->leftjoin('offers', 'offers.studentof_id','=', 'students.st_id')
            ->select('applications.upload as aupload','offers.upload as oupload','students.*','documents.document')
            ->where(function ($query) use ($request) {
                if (!empty($request->student_id)) {
                    $query->Where('st_id', $request->student_id);
                }
                if (!empty($request->name)) {
                    $query->where('name', $request->name);
                }
            })
            ->get();
        return view('counselor.summary_report')->with(['student' => $student, 'course' => $course]);
    }
    public function summary_pdf(Request $request){

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->summary_data_to_html($request));
        return $pdf->stream();
    }
    public function summary_data_to_html(Request $request)
    {

        $student = Student::leftjoin('documents', 'documents.student_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('applications', 'applications.studentap_id', 'students.st_id')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->leftjoin('offers', 'offers.studentof_id', 'students.st_id')
            ->select('applications.upload as aupload','offers.upload as oupload','students.*','documents.document')
            ->get();

        $output = '<table  style="font-size: small;">
  
         
            <tr>
                 <th>ID</th>
                <th >Name</th>
                <th>Surname</th>
                <th >Nic</th>
                <th >Email</th>
                <th >Mobile</th>
                <th >Document</th>
                <th >Application</th>
                <th>Offer received</th>
                <th>Initial Inquiry</th>
            </tr>';
        foreach ($student as $student) {
            $output .= '<tr>
                    <td>' . $student->st_id . '</td>
                    <td>' . $student->name . '</td>
                    <td>' . $student->surname . '</td>
                    <td>' . $student->nic . '</td>
                    <td>' . $student->email . '</td>
                    <td>' . $student->mobile_number . '</td>
                             
                
        ';

            if (!empty($student->document)) {
                $output .= '<td>complete</td>';
            } else {
                $output .= '<td>pending</td>';
            }
            if (!empty($student->aupload)) {
                $output .= '<td>complete</td>';
            } else {
                $output .= '<td>pending</td>';
            }
            if (!empty($student->oupload)) {
                $output .= '<td>complete</td>';
            } else {
                $output .= '<td>pending</td>';
            }
            if (!empty($student->oupload) && !empty($student->aupload) && !empty($student->document)) {
                $output .= '<td>complete</td>';
            } else {
                $output .= '<td>pending</td>';
            }
            $output .= '</tr>';
        }
        $output .= '</table>';

        return $output;
    }

    public function excel(){

        $student = Student::leftjoin('documents', 'documents.student_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('applications', 'applications.studentap_id', 'students.st_id')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->leftjoin('offers', 'offers.studentof_id', 'students.st_id')
            ->select('applications.upload as aupload','offers.upload as oupload','students.*','documents.document')
            ->get();
        $student_array[]=array('Student ID','Student Name','Surname','Nic','Email','Mobile','Document received','Application','Offer received','Initial inquiry');
        foreach($student as $student)
        {
            $student_array[]=array(
                'Student ID'=>$student->st_id,
                'Student Name'=>$student->name,
                'Surname'=>$student->surname,
                'Nic'=>$student->nic,
                'Email'=>$student->email,
                'Mobile'=>$student->mobile_number,
                'Document receive'=> !empty($student->document) ? "complete" : "pending",
                'Application'=>!empty($student->aupload) ? "complete" : "pending",
                'Offer received'=>!empty($student->oupload) ? "complete" : "pending",
                'Initial inquiry'=>!empty($student->oupload) && !empty($student->aupload) && !empty($student->document) ? "complete" : "pending",


            );
        }
        Excel::create('Student Data')->sheet('Student Data', function($sheet) use ($student_array) {
            $sheet->fromArray($student_array, null, 'A1', false, false);
        })->download('xlsx');

    }

    public function document(){
        $student = Student::leftjoin('documents', 'documents.student_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->select('documents.*','users.full_name','students.*')
            ->get();
        return view('counselor.Document_recevied_report')->with('student',$student);
    }
    public function document_find(Request $request){
        $student = Student::leftjoin('documents', 'documents.student_id','=','students.st_id')
            ->leftjoin('users', 'users.id', '=','students.counselor')
            ->where(function ($query) use ($request) {
                if (!empty($request->student_id)) {
                    $query->Where('st_id', $request->student_id);
                }
                if (!empty($request->name)) {
                    $query->where('name', $request->name);
                }
                if (!empty($request->mobile)) {
                    $query->where('mobile_number', $request->name);
                }
                if (!empty($request->date)) {
                    $query->where('date', $request->date);
                }
            })
            ->get();
        return view('counselor.Document_recevied_report')->with(['student' => $student]);
    }
    public function pdf_document(Request $request){

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->document_data_to_html($request));
        return $pdf->stream();
    }

    public function document_data_to_html(Request $request)
    {

        $student = Student::leftjoin('documents', 'documents.student_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->get();

        $output = '<table  class="table" style="font-size: small">
         
            <tr>
               <th scope="col">Student ID</th>
                <th scope="col">Student Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Nic</th>
                <th scope="col">Mobile</th>
                <th scope="col">O/L certificate</th>
                <th scope="col">A/L certificate</th>
                <th scope="col">IELTS</th>
                <th scope="col">Service Letter</th>
                <th scope="col">Counselor</th>
                <th scope="col">Document</th>
            </tr>';
        foreach ($student as $student) {
            $output .= '<tr>
                    <td>'.$student->st_id.'</td>
                    <td>'.$student->name.'</td>
                    <td>'.$student->surname.'</td>
                    <td>'.$student->nic.'</td>
                    <td>'.$student->mobile_number.'</td>
                    <td>'.$student->ol.'</td>
                    <td>'.$student->al.'</td>
                    <td>'.$student->ielts.'</td>
                    <td>'.$student->service.'</td>
                      <td>'.$student->full_name.'</td>
                    <td><a href="../../'.$student->upload.'">Document</a></td>
                  
                </tr>
        ';
        }
        $output .= '</table>';

        return $output;
    }
    public function document_excel()
    {

        $student = Student::leftjoin('documents', 'documents.student_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->get();
        $student_array[] = array('Student ID', 'Student Name', 'Surname', 'Nic', 'Mobile', 'O/L', 'A/L', 'IELTS', 'Service letter', 'Upload Document', 'Counselor');
        foreach ($student as $student) {
            $student_array[] = array(
                'Student ID' => $student->st_id,
                'Student Name' => $student->name,
                'Surname' => $student->surname,
                'Nic' => $student->nic,
                'Mobile' => $student->mobile_number,
                'O/L' => !empty($student->ol) ? "yes" : "no",
                'A/L' => !empty($student->al) ? "yes" : "no",
                'IELTS' => !empty($student->ielts) ? "yes" : "no",
                'Service letter' => !empty($student->service) ? "yes" : "no",
                'Upload Document' => $student->document,
                'Counselor' => $student->full_name

            );
        }
        Excel::create('Student Data')->sheet('Student Data', function ($sheet) use ($student_array) {
            $sheet->fromArray($student_array, null, 'A1', false, false);
        })->download('xlsx');

    }
    public function application_excel(){
        $student = Student::leftjoin('applications', 'applications.studentap_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->get();
        $student_array[]=array('Student ID','Student Name','Surname','Nic','Mobile','Date Applied','Course name','Uploaded Document','Counselor');
        foreach($student as $student)
        {
            $student_array[]=array(
                'Student ID'=>$student->st_id,
                'Student Name'=>$student->name,
                'Surname'=>$student->surname,
                'Nic'=>$student->nic,
                'Mobile'=>$student->mobile_number,
                'Date Applied'=> $student->date_applied,
                'Course name'=>$student->course_name ,
                'Upload Document'=>!empty($student->upload) ? "yes" : "no",

                'Counselor'=>$student->full_name,

            );
        }
        Excel::create('Student Data')->sheet('Student Data', function($sheet) use ($student_array) {
            $sheet->fromArray($student_array, null, 'A1', false, false);
        })->download('xlsx');
    }

    public function offer_excel(){
        $student = Student::leftjoin('offers', 'offers.studentof_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->get();
        $student_array[]=array('Student ID','Student Name','Surname','Nic','Mobile','Email','Offer date','Course name','Intake Semester','Intake date','Upload Document','Counselor');
        foreach($student as $student)
        {
            $student_array[]=array(
                'Student ID'=>$student->st_id,
                'Student Name'=>$student->name,
                'Surname'=>$student->surname,
                'Nic'=>$student->nic,
                'Mobile'=>$student->mobile_number,
                'Email'=>$student->email,
                'Offer date'=>$student->offer_date,
                'Course name'=>$student->course_name ,
                'Intake Semester'=>$student->semester,
                'Intake date'=>$student->in_date,
                'Upload Document'=>!empty($student->upload) ? "yes" : "no",
                'Counselor'=>$student->full_name,

            );
        }
        Excel::create('Student Data')->sheet('Student Data', function($sheet) use ($student_array) {
            $sheet->fromArray($student_array, null, 'A1', false, false);
        })->download('xlsx');
    }

    public function initial_excel(){
        $student = Student::leftjoin('offers', 'offers.studentof_id','=' ,'students.st_id')
            ->leftjoin('users', 'users.id','=','students.counselor')
            ->leftjoin('courses', 'courses.id','=','students.course_interested')
            ->get();
        $student_array[]=array('Student ID','Student Name','Surname','Nic','Mobile','Email','Enquiry date','Course name','Counselor');
        foreach($student as $student)
        {
            $student_array[]=array(
                'Student ID'=>$student->st_id,
                'Student Name'=>$student->name,
                'Surname'=>$student->surname,
                'Nic'=>$student->nic,
                'Mobile'=>$student->mobile_number,
                'Email'=>$student->email,
                'Enquiry date'=>$student->updated_at,
                'Course name'=>$student->course_name ,
                'Counselor'=>$student->full_name,

            );
        }
        Excel::create('Student Data')->sheet('Student Data', function($sheet) use ($student_array) {
            $sheet->fromArray($student_array, null, 'A1', false, false);
        })->download('xlsx');
    }

    public function enquiry_edit_form(Request $request){
        $course =Course::all();
        $student=Student::leftjoin('offers', 'offers.studentof_id','=' ,'students.st_id')
            ->leftjoin('users', 'users.id','=','students.counselor')
            ->leftjoin('courses', 'courses.id','=','students.course_interested')
            ->where('students.st_id',$request->student_id)
            ->first();
        return view('counselor.enquiry_edit_form')->with(['student'=>$student,'course'=>$course]);
    }
    public function enquiry_edit(Request $request){
        $student=Student::where('students.st_id',$request->student_id)
            ->first();
        $student->st_id= $request->student_id;
        $student->name=$request->name;
        $student->surname=$request->surname;
        $student->nic=$request->nic;
        $student->email=$request->email;
        $student->mobile_number=$request->mobile;
        $student->counselor=Auth::user()->id;
        $student->course_interested= $request->course_id;

        $student->save();

        return redirect()->back()->with(['message'=>'successfully updated','student'=>$student]);
    }
    public function document_edit_form(Request $request){
        $course =Course::all();
        $student=Student::leftjoin('documents', 'documents.student_id', 'students.st_id')
            ->where('st_id',$request->student_id)
            ->first();
        return view('counselor.document_edit_form')->with(['student'=>$student,'course'=>$course]);
    }
    public function document_edit(Request $request){
        $request->validate([
            'student_id'=>'required|exists:documents,student_id',['message'=>'cannot update'],

        ]);
        $student=Student::where('students.st_id',$request->student_id)->first();
        $student->st_id= $request->student_id;
        $student->name=$request->name;
        $student->surname=$request->surname;
        $student->nic=$request->nic;
        $student->mobile_number=$request->mobile;
        $student->counselor=Auth::user()->id;
        $student->save();

        $student1=Document::Where('student_id',$request->student_id)->first();
        $student1->ol=$request->ol;
        $student1->al=$request->al;
        $student1->ielts=$request->ielts;
        $student1->service = $request->service;

        if (request()->has('file')) {
            $profileImage = request()->file('file');
            $profileSaveAsName = time() . Auth::id() . "-file." .
                $profileImage->getClientOriginalExtension();

            $public_path = 'document/';
            $profile_image_url = $public_path . $profileSaveAsName;
            $profileImage->move($public_path, $profileSaveAsName);
            $student1->document = $profile_image_url;
            $student1->save();
            return redirect()->back()->with('message','Document received');
        }else{
            $student1->save();
            return redirect()->back()->with('message','Document received');
        }

        return redirect()->back()->with(['message'=>'successfully updated','student'=>$student]);
    }

    public function application_edit_form(Request $request){
        $course = Course::all();
        $student = Student::leftjoin('applications', 'applications.studentap_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->where('students.st_id',$request->student_id)
            ->first();
        return view('counselor.application_edit_form')->with(['student'=>$student,'course'=>$course]);
    }
    public function application_edit(Request $request){
        $request->validate([
            'student_id'=>'required|exists:applications,studentap_id',

        ]);
        $student=Student::where('students.st_id',$request->student_id)->first();
        $student->st_id= $request->student_id;
        $student->name=$request->name;
        $student->surname=$request->surname;
        $student->nic=$request->nic;
        $student->mobile_number=$request->mobile;
        $student->counselor=Auth::user()->id;
        $student->course_interested=$request->course_id;
        $student->save();

        $student1=Application::where('studentap_id',$request->student_id)->first();
        $student1->date_applied = $request->date;
        if (request()->has('file')) {
            $profileImage = request()->file('file');
            $profileSaveAsName = time() . Auth::id() . "-file." .
                $profileImage->getClientOriginalExtension();

            $public_path = 'document/';
            $profile_image_url = $public_path . $profileSaveAsName;
            $profileImage->move($public_path, $profileSaveAsName);
            $student1->upload = $profile_image_url;
            $student1->save();
            return redirect()->back()->with('message','Document received');
        }else{
            $student1->save();
            return redirect()->back()->with('message','Document received');
        }

        return redirect()->back()->with(['message'=>'successfully updated','student'=>$student]);
    }
    public function offer_edit_form(Request $request){
        $course = Course::all();
        $student = Student::leftjoin('offers', 'offers.studentof_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->where('st_id',$request->student_id)
            ->first();
        return view('counselor.offer_edit_form')->with(['course' => $course, 'student' => $student]);
    }
    public function offer_edit(Request $request){
        $request->validate([
            'student_id'=>'required|exists:offers,studentof_id',

        ]);
        $student=Student::where('students.st_id',$request->student_id)->first();
        $student->st_id= $request->student_id;
        $student->name=$request->name;
        $student->surname=$request->surname;
        $student->nic=$request->nic;
        $student->mobile_number=$request->mobile;
        $student->counselor=Auth::user()->id;
        $student->course_interested=$request->course_id;
        $student->save();

        $student1=Offer::where('studentof_id',$request->student_id)->first();
        $student1->offer_date = $request->date;
        $student1->in_date = $request->in_date;
        $student1->semester = $request->semester;
        if (request()->has('file')) {
            $profileImage = request()->file('file');
            $profileSaveAsName = time() . Auth::id() . "-file." .
                $profileImage->getClientOriginalExtension();

            $public_path = 'document/';
            $profile_image_url = $public_path . $profileSaveAsName;
            $profileImage->move($public_path, $profileSaveAsName);
            $student1->upload = $profile_image_url;
            $student1->save();
            return redirect()->back()->with('message','Document received');
        }else{
            $student1->save();
            return redirect()->back()->with('message','Document received');
        }

        return redirect()->back()->with(['message'=>'successfully updated','student'=>$student]);
    }



}









