@extends('layouts.master')

@section('title')
    Extra Text Messages
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
        	<h3>Settings</h3>
          	{{Form::open(['action'=>'SettingsController@update','class'=>'form-inline','method'=>'put','accept-charset'=>'UTF-8'])}}
        	

			<div class="panel panel-default">
        		<div class="panel-heading"></div>
        		<div class="panel-body">
		        	<table class="table table-striped table-responsive">
		        		
		    			<tbody>
		    				<tr>
		    					<td>UGX</td>
		    					<td>{{Form::number('ugx',$settings->ugx)}}</td>

		    				</tr>
		    				<tr>
		    					<td>Airtel Password</td>
		    					<td>{{Form::number('airtel_password',$settings->airtel_password)}}</td>

		    				</tr>
		    				<tr>
		    					<td>MTN Number</td>
		    					<td>{{Form::number('mtn_phonenumber',$settings->mtn_phonenumber)}}</td>
		    				</tr>
		    				
		    			</tbody>
		    		</table>


		    	</div>
		    </div>

        	<div class="panel panel-default">
        		<div class="panel-heading"><h4>Messages</h4></div>
        		<div class="panel-body">
		        	<table class="table table-striped table-responsive">
		        		<thead>
		        			<tr>
		    					<td>Label</td>
		    					<td>Message</td>
		    				</tr>
		    			</thead>
		    			<tbody>
		    				<tr>
		    					<td>Pre-Reminder</td>
		    					<td>{{Form::textarea('pre_reminder',$questions[0]->question)}}</td>

		    				</tr>
		    				<tr>
		    					<td>Invalid Response</td>
		    					<td>{{Form::textarea('invalid',$questions[1]->question)}}</td>
		    				</tr>
		    				<tr>
		    					<td>Closed Survey</td>
		    					<td>{{Form::textarea('closed',$questions[2]->question)}}</td>
		    				</tr>
		    				<tr>	
		    					<td>End of Survey</td>
		    					<td>{{Form::textarea('end',$questions[3]->question)}}</td>
		    				</tr>
		    				<tr>	
		    					<td>No Response</td>
		    					<td>{{Form::textarea('noresponse',$questions[4]->question)}}</td>
		    				</tr>
		    				<tr>
		    					<td>Delimiter</td>
		    					<td>{{Form::text('delimiter',$delimiter,['class'=>'form-control','maxlength'=>'1'])}}</td>
		    				</tr>
		    			</tbody>
		    		</table>
		    	</div>
		    </div>
		    <div class="panel panel-default">
        		<div class="panel-heading"><h4>Time</h4></div>
        		<div class="panel-body">
		        	<table class="table table-striped table-responsive">
		        		<thead>
		        			<tr>
		    					<td>Label</td>
		    					<td>Time</td>
		    				</tr>
		    			</thead>
		    			<tbody>
		    				<tr>
		    					<td>Pre-Reminder Time(in minutes)</td>
		    					<td>{{Form::number('pre_reminder_time',$settings->prereminder_time)}}</td>

		    				</tr>
		    				<tr>
		    					<td>Resend Attempts (Short)</td>
		    					<td>{{Form::number('resend_short',$settings->resend_short)}}</td>
		    				</tr>
		    				<tr>
		    					<td>Resend Attempts Time (Short, in Hours)</td>
		    					<td>{{Form::number('resend_short_time',$settings->resend_short_time)}}</td>
		    				</tr>
		    				<tr>
		    					<td>Resend Attempts (Long)</td>
		    					<td>{{Form::number('resend_long',$settings->resend_long)}}</td>
		    				</tr>
		    				<tr>
		    					<td>Resend Attempts Time (Long, in Hours)</td>
		    					<td>{{Form::number('resend_long_time',$settings->resend_long_time)}}</td>
		    				</tr>
		    			</tbody>
		    		</table>


		    	</div>
		    </div>
			{{Form::Submit('Save Changes')}}
		    {{Form::close()}}
        </div>

    </div>

@endsection