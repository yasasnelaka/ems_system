@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Application Received') }}</div>

                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ url('/counselor/application_received') }}" enctype="multipart/form-data">
                            @csrf


                            <div class="form-group row">
                                <label for="Student_id" class="col-md-4 col-form-label text-md-right">{{ __('Student_id') }}</label>

                                <div class="col-md-6">
                                    <select class="mdb-select md-form" id="student_id" name="student_id" searchable="Search here..">
                                        <option value="">Select Id</option>
                                        @foreach($student as $student)
                                            <option value="{{$student->st_id}}">{{$student->st_id}}</option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autocomplete="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required autocomplete="surname">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" required autocomplete="email">


                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile No') }}</label>

                                <div class="col-md-6">
                                    <input id="mobile" type="mobile" class="form-control" name="mobile" required autocomplete="mobile">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control" name="address" required autocomplete="address">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                                <div class="col-md-6">
                                    <input id="city" type="text" class="form-control" name="city" required autocomplete="city">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="course" class="col-md-4 col-form-label text-md-right">{{ __('Course Interested') }}</label>

                                <div class="col-md-6">
                                    <select name="course_id" class="browser-default custom-select">
                                        <option value="">Select Course</option>
                                        @foreach($course as $course)
                                            <option value="{{$course->id}}">{{$course->course_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('course_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date Applied') }}</label>

                                <div class="col-md-6">
                                    <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" required autocomplete="date">

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Default unchecked -->

                            <div class="form-group row">
                                <label for="address" id="inputGroupFileAddon01" class="col-md-4 col-form-label text-md-right">{{ __('Documents') }}</label>
                                <div class="col-md-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01"
                                               aria-describedby="inputGroupFileAddon01" name="file">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Upload') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <script>
        // Material Select Initialization
        $(document).ready(function() {
            $('.mdb-select').materialSelect();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('[name="student_id"]').change(function(){

                $.ajax({
                    type: "get",
                    url: '/counselor/document_received_check',

                    dataType: "json",
                    data: {student_id: $('#student_id').val()},
                    success: function (result) {
                        console.log(result);
                        $('#name').val(result.name);
                        $('#surname').val(result.surname);
                        $('#email').val(result.email);
                        $('#mobile').val(result.mobile_number);
                        $('#address').val(result.address);
                        $('#city').val(result.city);

                    },
                    error: function (result) {

                        alert('error');

                    }
                });
            });
        });
    </script>
@endsection
