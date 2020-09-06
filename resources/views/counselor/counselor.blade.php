@extends('layouts.app')

@section('content')
<center>
    <a href="/counselor/register" class="btn btn-primary" style="width: 20%">Register</a>
    <a href="/counselor/document_received_form" class="btn btn-primary" style="width: 20%">Document Upload</a><br>
    <a href="/counselor/application_received_form" class="btn btn-primary" style="width: 20%">Application Upload</a>
    <a href="/counselor/offer_received_form" class="btn btn-primary" style="width: 20%">Offers</a><br>

    <a href="/counselor/initial_enquiry" class="btn btn-primary" style="width: 20%">Reports</a>
    <a href="/counselor/offer_received" class="btn btn-primary" style="width: 20%">Offer Received</a><br>
    <a href="/counselor/application_report" class="btn btn-primary" style="width: 20%">Application Report</a>
    <a href="/counselor/summary_report" class="btn btn-primary" style="width: 20%">Summary Report</a><br>
    <a href="/counselor/document" class="btn btn-primary" style="width: 20%">Document Report</a>
</center>
    @endsection
