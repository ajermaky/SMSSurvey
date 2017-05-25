@extends('layouts.master')

@section('title')
    Questions
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h3>Modems</h3>
            <p>Ensure that the modem names match those defined in your smsd.conf file</p>
            

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Add a New Modem</h4></div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'ModemController@store', 'class' => 'form-inline']) }}
                    <div class="form-group">
                        {{Form::text('modem_name')}}
                        {{Form::Submit('Create New Modem', ['class' => 'btn btn-default'])}}
                    </div>
                    {{Form::close()}}
                </div>
            </div>

                <table class="table table-striped table-responsive">
                        <thead>
                                <tr>
                                        <td>Modem</td>
                                        <td>Messages</td>
                                        <td>Airtime Sent</td>
                                        <td>Reset Messages</td>
                                        <td>Reset Airtime</td> 
                                        <td>Delete</td>
                                </tr>
                        </thead>
                            @foreach($modems as $modem)
                                <tr>
                                        <td>{{{$modem->modem_name}}}</td>
                                        <td>{{{$modem->messages_sent}}}</td>
                                        <td>{{{$modem->airtime_sent}}}
                                        <td></td> 
                                        <td></td>
                                        <td>{{Form::open(['action'=>['ModemController@destroy',$modem->id],'class'=>'form-inline', 'method'=>'delete'])}}
                                                {{Form::Submit('Destroy',['class'=> 'btn btn-default'])}}
                                                {{Form::close()}}</td>
                                </tr>
                            @endforeach
                </table>      
        </div>
    </div>
@endsection