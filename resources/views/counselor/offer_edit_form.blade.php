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
                        <form method="POST" action="{{ url('/counselor/offer_edit') }}" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            @csrf
                            <div class="form-group row">
                                <label for="Student_id" class="col-md-4 col-form-label text-md-right">{{ __('Student_id') }}</label>

                                <div class="col-md-6">
                                    <input id="student_id" type="text" class="form-control @error('student_id') is-invalid @enderror" name="student_id" value="{{$student->st_id}}" required autocomplete="student_id" autofocus >
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
                                    <input id="name" type="text" class="form-control " name="name" value="{{ $student->name }}" required autocomplete="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control" name="surname" value="{{$student->surname}}" required autocomplete="surname">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="nic" class="col-md-4 col-form-label text-md-right">{{ __('NIC') }}</label>

                                <div class="col-md-6">
                                    <input id="nic" type="text" class="form-control @error('nic') is-invalid @enderror" name="nic" value="{{$student->nic}}" required autocomplete="nic">

                                    @error('nic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile No') }}</label>

                                <div class="col-md-6">
                                    <input id="mobile" type="mobile" value="{{$student->mobile_number}}" class="form-control" name="mobile" required autocomplete="mobile">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Offer Received Date') }}</label>

                                <div class="col-md-6">
                                    <input id="date" type="date" value="{{$student->offer_date}}" class="form-control @error('date') is-invalid @enderror" name="date"  autocomplete="date">

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="course" class="col-md-4 col-form-label text-md-right">{{ __('Course Interested') }}</label>

                                <div class="col-md-6">
                                    <select name="course_id" class="browser-default custom-select">
                                        <option value="{{$student->id}}">{{$student->course_name}}</option>
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
                                <label for="address" id="inputGroupFileAddon01" class="col-md-4 col-form-label text-md-right">{{ __('Documents') }}</label>
                                <div class="col-md-6">
                                    <div class="custom-file">
                                        <input type="file" value="{{$student->document}}" class="custom-file-input" id="inputGroupFile01"
                                               aria-describedby="inputGroupFileAddon01" name="file">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{$student->id}}" name="id">

                            <div class="form-group row">
                                <label for="semester" class="col-md-4 col-form-label text-md-right">{{ __('Semester') }}</label>

                                <div class="col-md-6">
                                    <input id="semester" value="{{$student->semester}}" type="text" class="form-control" name="semester"  autocomplete="semester">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="in_date" class="col-md-4 col-form-label text-md-right">{{ __('Intake Date') }}</label>

                                <div class="col-md-6">
                                    <input id="in_date" type="date" value="{{$student->in_date}}" class="form-control @error('in_date') is-invalid @enderror" name="in_date"  autocomplete="in_date">

                                    @error('in_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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

@endsection
