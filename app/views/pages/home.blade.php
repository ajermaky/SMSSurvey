@extends('layouts.master')

@section('title')
    Home
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
		    <table class="table table-striped table-responsive">
		    	<thead>
			    	<tr>
			    		<td>{{Form::open(['action'=>'HomeController@start','class'=>'form-inline'])}}
			    		{{Form::Submit('Start Survey')}}
			    		{{Form::close()}}</td>
			    		<td>{{Form::open(['action'=>'HomeController@stop','class'=>'form-inline'])}}
			    		{{Form::Submit('End Survey')}}
			    		{{Form::close()}}</td>
			    		<td>{{Form::open(['action'=>'HomeController@sendNoResponses','class'=>'form-inline'])}}
			    		{{Form::Submit('Send to No Responses')}}
			    		{{Form::close()}}</td>
			    	</tr>
		    	</thead>
        	</table>
   		 	<h3>Surveys</h3>
		    <table class="table table-striped table-responsive">
		    	<thead>
			    	<tr>
			    		<td>Survey</td>
			    		<td>Date</td>
			    	</tr>
		    	</thead>
		    	<tbody>

	           		@foreach($fileobjs as $file)
	           		<tr>
	            		<td>{{link_to_asset("assets/surveys/".$file->name,$file->name)}}</td>
	            		<td>{{{$file->date}}}</td>
	            	</tr>
	           		@endforeach
           		</tbody>
        	</table>
        </div>
    </div>
@endsection
