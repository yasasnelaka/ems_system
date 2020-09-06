@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Document Received') }}</div>

                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ url('/counselor/document_edit') }}" enctype="multipart/form-data">
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



                            <!-- Default unchecked -->
                            <div class="form-group row">
                                <label for="o/l" class="col-md-4 col-form-label text-md-right"></label>
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="ol" value="yes" class="custom-control-input" @if(!empty($student->ol)) checked @endif id="defaultCheck1">
                                        <label class="custom-control-label"  for="defaultCheck1">O/L Certificate</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="a/l" class="col-md-4 col-form-label text-md-right"></label>
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"  name="al" value="yes" @if(!empty($student->al)) checked @endif class="custom-control-input" id="defaultCheck2">
                                        <label class="custom-control-label"  for="defaultCheck2">A/L Certificate</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ielts" class="col-md-4 col-form-label text-md-right"></label>
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="yes" @if(!empty($student->ielts)) checked @endif name="ielts" id="defaultCheck3">
                                        <label class="custom-control-label"  for="defaultCheck3">IELTS</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="service_letter" class="col-md-4 col-form-label text-md-right"></label>
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="yes"  @if(!empty($student->service)) checked @endif name="service" id="defaultCheck4">
                                        <label class="custom-control-label"  for="defaultCheck4">Service letter</label>
                                    </div>
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

{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('[name="student_id"]').change(function(){--}}

{{--                $.ajax({--}}
{{--                    type: "get",--}}
{{--                    url: '/counselor/document_received_check',--}}

{{--                    dataType: "json",--}}
{{--                    data: {student_id: $('#student_id').val()},--}}
{{--                    success: function (result) {--}}
{{--                        console.log(result);--}}
{{--                        $('#name').val(result.name);--}}
{{--                        $('#surname').val(result.surname);--}}
{{--                        $('#email').val(result.email);--}}
{{--                        $('#mobile').val(result.mobile_number);--}}
{{--                        $('#address').val(result.address);--}}
{{--                        $('#city').val(result.city);--}}

{{--                    },--}}
{{--                    error: function (result) {--}}

{{--                        alert('error');--}}

{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endsection
