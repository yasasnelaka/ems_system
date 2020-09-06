@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!--Success Alert-->
        @if(session()->has('message'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('message') }}
            </div>
        @endif

            <form action="/admin/summary_find" method="get">
                <div class="row">
                    <div class="col-md-4">
                        <div class="md-form">
                            <input type="text" name="student_id" id="surname" class="form-control" >
                            <label for="name">Student ID</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="md-form">
                            <input type="text" name="name" id="name" class="form-control" >
                            <label for="name">name</label>
                        </div>
                    </div>
                    <div class="col-md-4"> <input type="submit" value="Search" class="btn btn-primary"></div>
                </div>

            </form>
        <a href="/admin/summary_pdf" class="btn btn-primary">PDF</a>
        <a href="/admin/excel" class="btn btn-primary">Excel</a>
        <table  class="table">
            <thead class="grey lighten-2">
            <tr>
                <th scope="col">Student ID</th>
                <th scope="col">Student Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Nic</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile</th>
                <th scope="col">Document received</th>
                <th scope="col">Application</th>
                <th scope="col">Offer received</th>
                <th scope="col">Initial Inquiry</th>
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
                    <td>@if(!empty($student->document))
                            completed
                        @else
                            pending
                        @endif
                    </td>
                    <td>@if(!empty($student->aupload))
                            completed
                        @else
                            pending
                        @endif</td>
                    <td>@if(!empty($student->oupload))
                        completed
                         @else
                        pending
                        @endif
                    </td>
                    <td>@if(!empty($student->aupload) && !empty($student->oupload) && (!empty($student->document)))
                        completed
                        @else
                        pending
                        @endif
                    </td>
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
