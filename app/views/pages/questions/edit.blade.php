@extends('layouts.master')

@section('title')
    Questions
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
        	<h2>Edit Questions</h2>
        	
            {{Form::open(['action'=>'SurveyQuestionsController@update','class' => 'form-inline','method'=>'put'])}}

        	<table class="table table-striped table-responsive">
        		<thead>
        			<tr>
        				<td>Order</td>
        				<td>Question</td>
        				<td>Elements</td>
        				<td>Min</td>
        				<td>Max</td>
        			</tr>
        		</thead>
        		@foreach ($questions as $question)
        			<tr>
                        {{Form::hidden('id[]', $question->id)}}
	        			<td>{{Form::number('order[]',$question->order)}}</td>
	        			<td>{{Form::textarea('question[]',$question->question)}}</td>
	        			<td>{{Form::number('elements[]',$question->elements)}}</td>
	        			<td>{{Form::number('min[]',$question->min)}}</td>
	        			<td>{{Form::number('max[]',$question->max)}}</td>
	        			
	        		</tr>

        		@endforeach

        	</table>
            {{Form::Submit('Save Changes',['class'=>'btn btn-default'])}}
            {{Form::close()}}
        </div>
    </div>
@endsection