@extends('admin.main')

@section('title', str_replace('_', ' ', ucfirst($tableName)))

@section('content')

        <div class="col-md-12">

            <h4>Update: {{substr(str_replace('_', ' ',$tableName), 0, -1)}}</h4>

            @if(isset($error))
                <div class="alert alert-danger">
                    <strong>{{ $error['message'] }}</strong>
                </div>
            @endif

            @if(isset($comment))
                <div class="alert alert-success">
                    <strong>{{ $comment['message'] }}</strong>
                </div>
            @endif

            {!! Form::open(['url' => route('app.' . $tableName . '.update', $record['id']), 'files' => true]) !!}

            @foreach($fields as $field)

                @if(isset($enum_dropDown))
                    <div class="form-group">
                        {!! Form::label($enum_dropDown['label'], 'Choose ' . $enum_dropDown['label']) !!}
                        {{Form::select($field, $enum_dropDown['values'], $record[$field], ['class' => 'form-control'])}}<br/>
                    </div>

                @elseif($field == 'user_id')

                @elseif(isset($dropdown) and $field == 'parent_id')
                    <div class="form-group">
                        {!! Form::label($field, 'Choose ' . ucfirst(substr($field, 0, -3) . ':')) !!}
                        {{Form::select($field, [null=>'Please select '. substr(str_replace('_', ' ', $field), 0, -3)] + $dropdown[$field], $record[$field], ['class' => 'form-control'])}}<br/>
                    </div>

                @elseif(isset($dropdown[$field]) and substr($field, -3) == '_id')
                    <div class="form-group">
                        @if(substr($field, -6) == 'ies_id')
                            {!! Form::label($field, 'Choose ' . ucfirst(substr(str_replace('_', ' ',$field), 0, -6).'y') . ':') !!}
                            {{Form::select($field, [null=>'Please select '. substr(str_replace('_', ' ',$field), 0, -6).'y'] + $dropdown[$field], $record[$field], ['class' => 'form-control'])}}<br/>
                        @else
                            {!! Form::label($field, 'Choose ' . ucfirst(substr(str_replace('_', ' ', $field), 0, -3) . ':')) !!}
                            {{Form::select($field, [null=>'Please select '. substr(str_replace('_', ' ', $field), 0, -3)] + $dropdown[$field], $record[$field], ['class' => 'form-control'])}}<br/>
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
                    @if($field == 'files' and $record['resources_connections'] != [])
                        @if(isset($checkbox[$field]))
                        {!! Form::label($field, 'Pick ' . $field . ' witch you want to delete from page:') !!}<br/><br>

                        @foreach($record['resources_connections'] as $connection)

                                <img style="width:150px" src={{asset($connection['resource']['path'])}}>

                                {{Form::checkbox('filesToDelete[]', $connection['resource']['path'])}}<br><br>

                        @endforeach
                            <br>

                        {{--@foreach($checkbox['files'] as $key => $file)--}}

                            {{--@if (in_array($key, $pizzas_ingredients))--}}
                                {{--{{Form::checkbox($field.'[]', $key, true)}}--}}
                                {{--{{Form::label($ingridient, $ingridient)}}<br/>--}}
                            {{--@else--}}
                                {{--{{Form::checkbox($field.'[]', $key)}}--}}
                                {{--{{Form::label($ingridient, $ingridient)}}<br/>--}}
                            {{--@endif--}}

                        {{--@endforeach--}}

                        @endif

                    @endif


                @elseif($field == 'password')
                    <div class="form-group">
                        {!! Form::label($field, 'Enter ' . ucfirst($field . ':')) !!}
                        {!! Form::password($field, ['class' => 'form-control'])!!}<br/>
                    </div>

                @elseif($field)
                    <div class="form-group">
                        {!! Form::label($field, 'Enter ' . ucfirst($field . ':')) !!}
                        {!! Form::text($field, $record[$field], ['class' => 'form-control'])!!}<br/>
                    </div>
                @endif

            @endforeach


            {!! Form::submit('Update' , ['class' => 'btn btn-success']) !!}
            <a class="btn btn-primary" href="{{ route('app.' . $tableName . '.index') }}">{{str_replace('_', ' ', ucfirst($tableName))}} list</a>
            <br>
            <br>
            <br>
            {!! Form::close() !!}
        </div>

@endsection

