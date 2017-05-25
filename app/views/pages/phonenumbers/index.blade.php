@extends('layouts.master')

@section('title')
    Phone Numbers
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
        	<h2>PhoneNumbers</h2>
        	<div class="panel panel-default">
        		<div class="panel-heading">
        			<h4>Add a New Phone Number</h4></div>
        		<div class="panel-body">
        			{{ Form::open(['action' => 'PhoneNumbersController@store', 'class' => 'form-inline']) }}
                    <div class="form-group">
                        {{Form::textarea('phonenumbers')}}
                    </div>
                    </br>
        			<div class="form-group">
        				{{Form::Submit('Create New Phone Number', ['class' => 'btn btn-default'])}}
        			</div>
        			{{Form::close()}}
        		</div>
        	</div>
               
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