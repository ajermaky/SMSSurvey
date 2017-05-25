@extends('layouts.master')

@section('title')
    Failed Numbers
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
        	<h2>Failed Messages</h2>
               
            {{Form::open(['action'=>'PhoneNumbersController@delete', 'method'=>'delete'])}}
        	<table class="table table-striped table-responsive">
        		<thead>
        			<tr>
                        <td>Delete</td>
        				<td>Phone Number</td>
                        <td>Attempts</td>
        			</tr>
        		</thead>
        		@foreach ($phonenumbers as $phone)
        			<tr>
                        <td>{{Form::checkbox('phone[]',$phone->id)}}</td>
	        			<td>{{{$phone->phone}}}</td>
	        			<td>{{{$phone->attempts}}}</td>
	        		</tr>
        		@endforeach
        	</table>
        	{{Form::submit('Delete Phone Numbers',['class'=>'btn btn-default'])}}
            {{Form::close()}}

        </div>
    </div>
@endsection