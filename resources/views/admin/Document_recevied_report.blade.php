@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!--Success Alert-->
        @if(session()->has('message'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('message') }}
            </div>
        @endif

            <form action="/admin/document_find" method="get">
                <div class="row">
                    <div class="col-md-4">
                        <div class="md-form">
                            <input type="text" name="student_id" id="surname" class="form-control" >
                            <label for="name">Student ID</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="md-form">
                            <input type="date" name="date" id="date" class="form-control" >
                            <label for="date">Document Received Date</label>
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
                        <div class="md-form">
                            <input type="text" name="mobile" id="mobile" class="form-control" >
                            <label for="mobile">Mobile</label>
                        </div>
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
                        <input type="submit" value="Search" class="btn btn-primary">
                    </div>
                </div>



            </form>


        <a href="/admin/pdf_document" class="btn btn-primary">PDF</a>
        <a href="/admin/document_excel" class="btn btn-primary">Excel</a>
        <table  class="table">
            <thead class="grey lighten-2">
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

            </tr>
            </thead>
            <tbody>
            @foreach($student as $student)
                <tr>
                    <td>{{$student->st_id}}</td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->surname}}</td>
                    <td>{{$student->nic}}</td>
                    <td>{{$student->mobile_number}}</td>
                    <td>{{$student->ol}}</td>
                    <td>{{$student->al}}</td>
                    <td>{{$student->ielts}}</td>
                    <td>{{$student->service}}</td>
                    <td>{{$student->full_name}}</td>
                    <td><a href="../../{{$student->document}}">Document</a></td>
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
