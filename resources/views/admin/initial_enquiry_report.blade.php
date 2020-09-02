@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!--Success Alert-->
        @if(session()->has('message'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('message') }}
            </div>
        @endif
        <form action="" method="get">
            <button class="btn btn-outline-primary" type="submit">Filter options</button>
        </form>
        <table id="table1" class="table">
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
                    <td>{{$student->mobile}}</td>
                    <td>{{$student->in_date}}</td>
                    <td>{{$student->rank}}</td>
                    <td>{{$student->grade}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- Data Table -->
        <table cellspacing="0" cellpadding="0" border="0">
            <tbody>
            <tr>
                <td class="gutter">
                    <div class="line number1 index0 alt2" style="display: none;">1</div>
                </td>
                <td class="code">
                    <div class="container" style="display: none;">
                        <div class="line number1 index0 alt2" style="display: none;">&nbsp;</div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <script>
        // Material Select Initialization
        $(document).ready(function() {
            $('.mdb-select').materialSelect();
        });
    </script>
@endsection
