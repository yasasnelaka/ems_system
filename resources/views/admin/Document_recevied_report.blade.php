@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!--Success Alert-->
        @if(session()->has('message'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('message') }}
            </div>
        @endif
        <center>
            <form action="/admin/find" method="get">
                <div class="row">
                    <div class="col-md-4">
                        <div class="md-form">
                            <input type="text" name="student_id" id="surname" class="form-control" >
                            <label for="name">Student ID</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="Date_Of_Birth">Enquiry Date</label>
                    </div>
                    <div class="col-md-2">
                        <div class="md-form">
                            <input type="date" name="from_in_date" id="from_in_date" class="form-control">
                            <label for="from_in_date">From</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="md-form">
                            <input type="date" name="to_in_date" id="to_in_date" class="form-control" >
                            <label for="to_in_date">To</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="md-form">
                            <input type="text" name="name" id="name" class="form-control" >
                            <label for="name">name</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="course_id"   class="mdb-select md-form" searchable="Search here..">
                            <option value="">Select Course</option>
                            @foreach($course as $course)
                                <option value="{{$course->id}}">{{$course->course_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="md-form">
                            <input type="text" name="surname" id="surname" class="form-control" >
                            <label for="name">Surname</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="md-form">
                            <input type="text" name="mobile" id="mobile" class="form-control" >
                            <label for="mobile">Mobile</label>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Search" class="btn btn-primary">
            </form>
            <a href="/admin/pdf" class="btn btn-primary">PDF</a>
        </center>
        <table  class="table">
            <thead class="grey lighten-2">
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
            </tr>
            </thead>
            <tbody>
            @foreach($student as $student)
                <tr>
                    <td>{{$student->st_id}}</td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->surname}}</td>
                    <td>{{$student->nic}}</td>
                    <td>{{$student->email}}</td>
                    <td>{{$student->mobile_number}}</td>
                    <td>{{$student->in_date}}</td>
                    <td>{{$student->full_name}}</td>
                    <td>{{$student->course_name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- Data Table -->
        {{--        <table cellspacing="0" cellpadding="0" border="0">--}}
        {{--            <tbody>--}}
        {{--            <tr>--}}
        {{--                <td class="gutter">--}}
        {{--                    <div class="line number1 index0 alt2" style="display: none;">1</div>--}}
        {{--                </td>--}}
        {{--                <td class="code">--}}
        {{--                    <div class="container" style="display: none;">--}}
        {{--                        <div class="line number1 index0 alt2" style="display: none;">&nbsp;</div>--}}
        {{--                    </div>--}}
        {{--                </td>--}}
        {{--            </tr>--}}
        {{--            </tbody>--}}
        {{--        </table>--}}
    </div>

    <script>
        // Material Select Initialization
        $(document).ready(function() {
            $('.mdb-select').materialSelect();
        });
    </script>
@endsection
