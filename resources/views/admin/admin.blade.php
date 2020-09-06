@extends('layouts.app')

@section('content')
<center>
<a href="/register" class="btn btn-primary" style="width: 20%">Register</a>
<a href="../../admin/report" class="btn btn-primary" style="width: 20%">Users</a><br>
<a href="/admin/initial_enquiry" class="btn btn-primary" style="width: 20%">Reports</a>
<a href="/admin/offer_received" class="btn btn-primary" style="width: 20%">Offer Received</a><br>
<a href="/admin/application_report" class="btn btn-primary" style="width: 20%">Application Report</a>
<a href="/admin/summary_report" class="btn btn-primary" style="width: 20%">Summary Report</a><br>
<a href="/admin/document" class="btn btn-primary" style="width: 20%">Document Report</a>
</center>
@endsection
