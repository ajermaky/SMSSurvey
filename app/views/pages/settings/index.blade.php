@extends('layouts.master')

@section('title')
    Extra Text Messages
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
        	<h3>Settings</h3>
			
			<div class="panel panel-default">
        		<div class="panel-heading"></div>
        		<div class="panel-body">
		        	<table class="table table-striped table-responsive">
		        		
		    			<tbody>
		    				<tr>
		    					<td>UGX</td>
		    					<td>{{{$settings->ugx}}}</td>
		    				</tr>
		    				<tr>
		    					<td>Airtel Password</td>
		    					<td>{{{$settings->airtel_password}}}</td>
		    				</tr>
		    				<tr>
		    					<td>MTN Number</td>
		    					<td>{{{$settings->mtn_phonenumber}}}</td>
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
		    					<td>{{{$questions[0]->question}}}</td>

		    				</tr>
		    				<tr>
		    					<td>Invalid Response</td>
		    					<td>{{{$questions[1]->question}}}</td>
		    				</tr>
		    				<tr>
		    					<td>Closed Survey</td>
		    					<td>{{{$questions[2]->question}}}</td>
		    				</tr>
		    				<tr>
		    					<td>End of Survey</td>
		    					<td>{{{$questions[3]->question}}}</td>
		    				</tr>
		    				<tr>
		    					<td>No Response</td>
		    					<td>{{{$questions[4]->question}}}</td>
		    				</tr>

		    				<tr>
		    					<td>Delimiter</td>
		    					<td>'{{{$delimiter}}}'</td>
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
		    					<td>Pre-Reminder (in minutes)</td>
		    					<td>{{{$settings->prereminder_time}}}</td>

		    				</tr>
		    				<tr>
		    					<td>Resend Attempts (Short)</td>
		    					<td>{{{$settings->resend_short}}}</td>
		    				</tr>
		    				<tr>
		    					<td>Resend Attempts Time (Short, in Hours)</td>
		    					<td>{{{$settings->resend_short_time}}}</td>
		    				</tr>
		    				<tr>
		    					<td>Resend Attempts (Long)</td>
		    					<td>{{{$settings->resend_long}}}</td>
		    				</tr>
		    				<tr>
		    					<td>Resend Attempts Time (Long, in Hours)</td>
		    					<td>{{{$settings->resend_long_time}}}</td>
		    				</tr>
		    			</tbody>
		    		</table>


		    	</div>
		    </div>
    		{{Form::open(['action'=>'SettingsController@edit','class'=>'form-inline'])}}
    		{{Form::Submit('Edit Settings')}}
    		{{Form::close()}}

        </div>

    </div>

@endsection