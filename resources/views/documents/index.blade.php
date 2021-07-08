@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Documents Management</h2>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

<table class="table table-bordered" >
    <thead class="thead-dark">
        <tr>
        <th>Transaction No.</th>
        <th>Name</th>
        <th>Email</th>
        <th>Transaction Mode</th>
        <th>Document</th>
        <th>Purpose</th>
        <th>Payment Mode</th>
        <th>Status</th>
        <th width="280px">Action</th>
        </tr>
    </thead>
    @foreach ($data as $trans)
        <td>{{ $trans->id }}</td>
        <td>{{ $trans->name}}</td>
        <td>{{ $trans->email }}</td>
        <td>{{ $trans->docType }}</td>
        <td>{{ $trans->transMode }}</td>
        <td>{{ $trans->purpose }}</td>
        <td>{{ $trans->paymentMode }}</td>
        <td>{{ $trans->status }}</td>
        <td>
            <a class="btn btn-outline-danger" href="view-pdf/{{ $trans->userId }}">View</a>
            <a class="btn btn-outline-success" href="generate-pdf/{{ $trans->userId }}">Save PDF</a>
        </td>
    @endforeach
</table>



<p class="text-center text-primary"><small>By Team Bard</small></p>
@endsection