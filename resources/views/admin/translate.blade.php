@extends('admin.main')

@section('title', str_replace('_', ' ', ucfirst($tableName)))

@section('content')
        <div class="col-md-12"><br>
            @if(isset($record['name']))
                @if($record['name']!= null)
                    @if(isset($record['name']))
                         <h4>{{ucfirst($record['name']) . ' translations'}}</h4>
                    @endif
                @endif
            @else
                @if($tableName == 'pages_categories')
                    {{ucfirst(substr($tableName, 0, -3)) . 'y translations'}}
                @else{{ucfirst(substr($tableName, 0, -1)) . ' translations'}}
                @endif
            @endif
                <table class="table">
                <thead class="thead-default">
                <tr>
                    <th>Key</th>
                    @foreach($languages_names as $key => $value)
                        <th>
                            {!! Form::open(['url' => route('app.' . $tableName . '_translations.create', $record['id'])]) !!}

                            {{$value}} value
                            <br>
                            {{Form::checkbox('create' . $key, $key)}}
                            {{Form::label($key, 'Create / Update')}}<br/>
                            {{Form::checkbox('delete' . $key, $key)}}
                            {{Form::label($key, 'Delete')}}<br/>
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($fields_translations as $key => $field_value)
                    <tr>
                        <td>{{$field_value}}</td>

                        @foreach($languages as $key => $language)

                            @if(count($translations) == 0)
                                @if(($field_value == 'title' or $field_value == 'name') and $language == 'lt')
                                    <td>
                                        <div class="form-group">
                                            {!! Form::textarea($field_value . '_' . $language, $record['name'], ['class' => 'form-control', 'rows'=>"3"])!!}<br/>
                                        </div>
                                    </td>
                                @elseif($field_value)
                                    <td>
                                        <div class="form-group">
                                            {!! Form::textarea($field_value . '_' . $language, 'translation value', ['class' => 'form-control', 'rows'=>"3"])!!}<br/>
                                        </div>
                                    </td>
                                @endif
                            @endif

                            @foreach($translations as $translation)

                                @if($translation['languages_id'] == $language)

                                    @foreach($translation as $key_translation => $value_translation)

                                        @if($field_value == $key_translation)

                                            @if($field_value)
                                                <td>
                                                    <div class="form-group">
                                                        {!! Form::textarea($field_value . '_' . $translation['languages_id'], $value_translation, ['class' => 'form-control', 'rows'=>"3"])!!}<br/>
                                                    </div>
                                                </td>
                                            @endif

                                        @endif

                                    @endforeach

                                    @break

                                @else

                                    @if(end($translations) == $translation)

                                    @if($field_value)
                                        <td>
                                            <div class="form-group">
                                                {!! Form::textarea($field_value . '_' . $language, 'translation value', ['class' => 'form-control', 'rows'=>"3"])!!}<br/>
                                            </div>
                                        </td>
                                    @endif

                                    @endif

                                @endif

                            @endforeach

                        @endforeach

                    </tr>
                @endforeach
                </tbody>
            </table>

        {!! Form::submit('Create / Update' , ['class' => 'btn btn-success']) !!}
        {!! Form::submit('Delete' , ['class' => 'btn btn-danger']) !!}
        <a class="btn btn-primary" href="{{ route('app.' . $tableName . '.index') }}">{{str_replace('_', ' ', ucfirst($tableName))}} list</a>

        {!! Form::close() !!}
        </div>

@endsection
