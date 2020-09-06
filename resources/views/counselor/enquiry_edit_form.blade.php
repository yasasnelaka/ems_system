@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <form action="{{ url('/counselor/enquiry_edit') }}"  method="POST">
                            {{ method_field('PUT') }}
                            @csrf

                            <div class="form-group row">
                                <label for="Student_id" class="col-md-4 col-form-label text-md-right">{{ __('Student_id') }}</label>

                                <div class="col-md-6">
                                    <input id="student_id" type="text" class="form-control" name="student_id" value="{{$student->st_id}}" required autocomplete="student_id" autofocus >
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
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $student->name }}" required autocomplete="name">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ $student->surname }}" required autocomplete="surname">

                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" value="{{$student->email}}" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile No') }}</label>

                                <div class="col-md-6">
                                    <input id="mobile" type="mobile" value="{{$student->mobile_number}}" class="form-control @error('mobile') is-invalid @enderror" name="mobile" required autocomplete="mobile">

                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Counselor') }}</label>

                                <div class="col-md-6">
                                    <input id="counselor_old" type="text" class="form-control " name="counselor_old" value="{{ $student->full_name }}" required >

                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$student->id}}">
                            <input type="hidden" name="counselor" value="{{Auth::user()->id}}">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Material Select Initialization
        $(document).ready(function() {
            $('.mdb-select').materialSelect();
        });
    </script>

@endsection
