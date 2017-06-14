@extends('admin.main')

@section('title', str_replace('_', ' ', ucfirst($tableName)))

@section('content')

		<div class="col-md-12">
        <h4>Create:
        @if(substr($tableName, -3) == 'ies')
            {{substr(str_replace('_', ' ',$tableName), 0, -3).'y'}}
        @else
            {{substr(str_replace('_', ' ',$tableName), 0, -1)}}
        @endif
        </h4>

        @if(isset($error))
				<div class="alert alert-danger">
  					<strong>{{ $error['message'] }}</strong>
				</div>
			@endif

			@if(isset($message))
				@if(sizeof($message > 0))
					<div class="alert alert-warning">
						<strong>{{ $message }}</strong>
					</div>
				@endif
			@endif

			{!! Form::open(['url' => route('app.' . $tableName . '.store'), 'files' => true]) !!}

			@foreach($fields as $field)
				@if($field == 'user_id')

                @elseif(isset($enum_dropDown))
                    <div class="form-group">
                        {!! Form::label($enum_dropDown['label'], 'Choose ' . $enum_dropDown['label']) !!}
                        {{Form::select($enum_dropDown['label'], $enum_dropDown['values'], '', ['class' => 'form-control'])}}<br/>
                    </div>

                @elseif(isset($dropdown[$field]) and substr($field, -3) == '_id')
                    <div class="form-group">
                        @if(substr($field, -6) == 'ies_id')
                            {!! Form::label($field, 'Choose ' . ucfirst(substr(str_replace('_', ' ',$field), 0, -6).'y') . ':') !!}
                            {{Form::select($field, [null=>'Please select '. substr(str_replace('_', ' ',$field), 0, -6).'y'] + $dropdown[$field], '', ['class' => 'form-control'])}}<br/>
                        @else
                            {!! Form::label($field, 'Choose ' . ucfirst(substr(str_replace('_', ' ', $field), 0, -3) . ':')) !!}
                            {{Form::select($field, [null=>'Please select '. substr(str_replace('_', ' ', $field), 0, -3)] + $dropdown[$field], '', ['class' => 'form-control'])}}<br/>
                        @endif
                    </div>

                    @if($field == 'cover_image_id' and $tableName == 'pages')
                        <div class="form-group">
                            {!! Form::label($field, 'Upload ' . ucfirst(substr($field, 0, -3) . ':')) !!}
                            {!! Form::file($field)!!}
                        </div>
                    @endif
                @elseif($field == 'files' or $field == 'path')
                    <br/><div class="form-group">
                        {!! Form::label('images', 'Upload files:' ) !!}<br>
                        {!! Form::file('files[]', array('multiple'=>true)) !!}<br/>
                    </div>

                @elseif(isset($checkbox[$field]))
                        {!! Form::label($field, 'Pick ' . ucfirst($field . ':')) !!}<br/>
                @foreach($checkbox[$field] as $key => $checkboxItem)
                        {{Form::checkbox($field.'[]', $key)}}
                        {{Form::label($checkboxItem, $checkboxItem)}}<br/>
                @endforeach<br/>

                @elseif($field == 'password')
                    <div class="form-group">
                        {!! Form::label($field, 'Enter ' . ucfirst($field . ':')) !!}
                        {!! Form::password($field, ['class' => 'form-control'])!!}<br/>
                    </div>

                @elseif($field && $tableName != 'resources')
                    <div class="form-group">
                            {!! Form::label($field, 'Enter ' . ucfirst($field . ':')) !!}
                            {!! Form::text($field, '', ['class' => 'form-control'])!!}<br/>
                    </div>

                @endif
            @endforeach

{!! Form::submit('Create' , ['class' => 'btn btn-success']) !!}
<a class="btn btn-primary" href="{{ route('app.' . $tableName . '.index') }}">{{str_replace('_', ' ', ucfirst($tableName))}} list</a>

{!! Form::close() !!}
</div>

@endsection