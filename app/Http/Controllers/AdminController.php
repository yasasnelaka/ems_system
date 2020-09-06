<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;
use App\User;
use Illuminate\Support\Facades\App;
use PDF;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.admin');
    }

    public function report()
    {
        $user = User::where('role_id', 2)
            ->get();
        return view('admin.report')->with('user', $user);
    }

    public function edit(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        return view('admin.edit_form')->with('user', $user);
    }

    public function edit_register(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back();
    }

    public function initial_enquiry()
    {
        $course = Course::all();
        $student = Student::leftjoin('offers', 'offers.studentof_id','=' ,'students.st_id')
            ->leftjoin('users', 'users.id','=','students.counselor')
            ->leftjoin('courses', 'courses.id','=','students.course_interested')
            ->get();
        return view('admin.initial_enquiry_report')->with(['student' => $student, 'course' => $course]);
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
        return view('admin.initial_enquiry_report')->with(['student' => $student, 'course' => $course]);
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

    public function offer_received()
    {
        $course = Course::all();
        $student = Student::leftjoin('offers', 'offers.studentof_id', 'students.st_id')
            ->leftjoin('users', 'users.id', 'students.counselor')
            ->leftjoin('courses', 'courses.id', 'students.course_interested')
            ->get();
        return view('admin.offer_received_report')->with(['course' => $course, 'student' => $student]);
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
        return view('admin.offer_received_report')->with(['student' => $student, 'course' => $course]);
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
        return view('admin.application_report')->with(['course' => $course, 'student' => $student]);
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
        return view('admin.application_report')->with(['student' => $student, 'course' => $course]);
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
        return view('admin.summary_report')->with(['student' => $student]);
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
        return view('admin.summary_report')->with(['student' => $student, 'course' => $course]);
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
            ->get();
        return view('admin.Document_recevied_report')->with('student',$student);
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
        return view('admin.Document_recevied_report')->with(['student' => $student]);
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

}
