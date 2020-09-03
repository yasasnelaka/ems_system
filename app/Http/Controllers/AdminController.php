<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;
use App\User;
use Illuminate\Support\Facades\App;
use PDF;
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
        $student = Student::join('offers', 'offers.studentof_id', 'students.st_id')
            ->join('users', 'users.id', 'students.counselor')
            ->join('courses', 'courses.id', 'students.course_interested')
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

        $student = Student::join('offers', 'offers.studentof_id', 'students.st_id')
            ->join('users', 'users.id', 'students.counselor')
            ->join('courses', 'courses.id', 'students.course_interested')
            ->get();

        $output = '<table  class="table">
         
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
                    <td>' . $student->in_date . '</td>
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
        $student = Student::join('offers', 'offers.studentof_id', 'students.st_id')
            ->join('users', 'users.id', 'students.counselor')
            ->join('courses', 'courses.id', 'students.course_interested')
            ->get();
        return view('admin.offer_received_report')->with(['course' => $course, 'student' => $student]);
    }

    public function offer_find(Request $request)
    {
        $course = Course::all();
        $student = Student::join('offers', 'offers.studentof_id', 'students.st_id')
            ->join('users', 'users.id', 'students.counselor')
            ->join('courses', 'courses.id', 'students.course_interested')
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

        $student = Student::join('offers', 'offers.studentof_id', 'students.st_id')
            ->join('users', 'users.id', 'students.counselor')
            ->join('courses', 'courses.id', 'students.course_interested')
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
        $student = Student::join('applications', 'applications.studentap_id', 'students.st_id')
            ->join('users', 'users.id', 'students.counselor')
            ->join('courses', 'courses.id', 'students.course_interested')
            ->get();
        return view('admin.application_report')->with(['course' => $course, 'student' => $student]);
    }
    public function application_find(Request $request){
        $course = Course::all();
        $student = Student::join('applications', 'applications.studentap_id', 'students.st_id')
            ->join('users', 'users.id', 'students.counselor')
            ->join('courses', 'courses.id', 'students.course_interested')
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

            $student = Student::join('applications', 'applications.studentap_id', 'students.st_id')
                ->join('users', 'users.id', 'students.counselor')
                ->join('courses', 'courses.id', 'students.course_interested')
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
}
