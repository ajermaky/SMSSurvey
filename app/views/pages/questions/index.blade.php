@extends('layouts.master')

@section('title')
    Questions
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
        	<h2>Questions</h2>
        	<div class="panel panel-default">
        		<div class="panel-heading">
        			<h4>Add a New Question</h4></div>
        		<div class="panel-body">
        			{{ Form::open(['action' => 'SurveyQuestionsController@store', 'class' => 'form-inline']) }}
        			<div class="form-group">
        				{{Form::Submit('Create New Question', ['class' => 'btn btn-default'])}}
        			</div>
        			{{Form::close()}}
        		</div>
        	</div>


        	<table class="table table-striped table-responsive">
        		<thead>
        			<tr>
        				<td>Order</td>
        				<td>Question</td>
        				<td>Elements</td>
        				<td>Min</td>
        				<td>Max</td>
        				<td>Delete</td>
        			</tr>
        		</thead>
        		
        		@foreach ($questions as $question)
        			<tr>
	        			<td>{{{$question->order}}}</td>
	        			<td>{{{$question->question}}}</td>
	        			<td>{{{$question->elements}}}</td>
	        			<td>{{{$question->min}}}</td>
	        			<td>{{{$question->max}}}</td>
	        			<td>{{Form::open(['action'=>['SurveyQuestionsController@destroy',$question->id],'class'=>'form-inline', 'method'=>'delete'])}}
	        				{{Form::Submit('Delete',['class'=> 'btn btn-default'])}}
	        				{{Form::close()}}</td>
	        		</tr>
        		@endforeach

        	</table>
        	{{Form::open(['action'=>'SurveyQuestionsController@edit','class'=>'form-inline','method'=>'get'])}}
        	{{Form::Submit('Edit Questions',['class'=>'btn btn-default'])}}
        	{{form::close()}}
        </div>
    </div>
@endsection