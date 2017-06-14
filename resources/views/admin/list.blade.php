@extends('admin.main')

@section('title', str_replace('_', ' ', ucfirst($tableName)))

@section('content')

    <br>
    @if(isset($error))
            <div class="alert alert-danger">
                <strong>{{ $error['message'] }}</strong>
            </div>
                @if($tableName == 'resources')
                    {!! Form::open(['url' => route('app.' . $tableName . '.store'), 'files' => true]) !!}

                    <label class="btn btn-primary btn-sm btn-file">
                        Create new resource <input type="file" multiple onchange="this.form.submit()" name="files[]" hidden>
                    </label>

                    {!! Form::close() !!}
                @else
            <a style="margin-bottom: 50px" class="btn btn-primary btn-sm" href="{{ route('app.' . $tableName . '.create') }}">Create new
                @if(substr($tableName, -3) == 'ies')
                    {{substr(str_replace('_', ' ',$tableName), 0, -3).'y'}}
                @else
                    {{substr(str_replace('_', ' ',$tableName), 0, -1)}}
                @endif            </a>
                @endif
            <br>
        @endif
    @if(!isset($error))
        @if(isset($comment))
            <div class="alert alert-success">
                <strong>{{ $comment['message'] }}</strong>
            </div>
        @endif
        @if(isset($message))
            <div class="alert alert-warning">
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if($tableName == 'resources')
            {!! Form::open(['url' => route('app.' . $tableName . '.store'), 'files' => true]) !!}

            <label class="btn btn-primary btn-sm btn-file">
                Create new resource <input type="file" multiple onchange="this.form.submit()" name="files[]" hidden>
            </label>

            {!! Form::close() !!}
        @else
            <a style="margin-bottom: 50px" class="btn btn-primary btn-sm" href="{{ route('app.' . $tableName . '.create') }}">Create new
                @if(substr($tableName, -3) == 'ies')
                    {{substr(str_replace('_', ' ',$tableName), 0, -3).'y'}}
                @else
                    {{substr(str_replace('_', ' ',$tableName), 0, -1)}}
                @endif            </a>
        @endif
        <br>
            <table class="table table-hover">
                <thead>
                <tr>
                    @foreach($fields as $key => $value)
                        @if($value == 'mime_type')
                            <th>mime type</th>
                        @elseif($value == 'path' and $tableName == 'resources')
                            <th>file</th>
                            <th>{{$value}}</th>
                        @elseif($value == 'cover_image_id' and $tableName == 'pages')
                            <th>cover image</th>
                        @elseif($value == 'pages_categories_id' and $tableName == 'pages')
                            <th>pages category</th>
                        @elseif($value == 'parent_id' and $tableName == 'menus')
                            <th>parent</th>
                        @else
                            <th>{{$value}}</th>
                        @endif
                    @endforeach
                        @if(isset($translationExist))
                            <th>Translate</th>
                        @endif
                    <th>View</th>
                        @if($tableName != 'resources')
                    <th>Edit</th>
                        @endif
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>

                @foreach($list_data as $key => $record)
                    <tr id="{{$record['id']}}">

                        @foreach($record as $key_data => $value_data)

                            @foreach($fields as $key => $value)

                                @if($key_data == $value and $key_data == 'mime_type')
                                    <td>{{$record[$key_data]}}</td>
                                @elseif($key_data == $value and $key_data == 'path')
                                    @if($value_data)
                                        <td><img style="width:70px" src={{asset($record[$key_data])}}></td>
                                    @else <td><img style="width:70px" src="{{asset('upload\2017\06\12\1497265977_no-image-box.png') }}"></td>
                                    @endif
                                    <td>{{$value_data}}</td>
                                @elseif($key_data == $value and $key_data == 'cover_image_id')
                                    @if($value_data)
                                        <td><img style="width:70px" src={{asset($coverImages[$value_data])}}></td>
                                    @else <td><img style="width:70px" src="{{asset('upload\2017\06\12\1497265977_no-image-box.png') }}"></td>
                                    @endif
                                @elseif($key_data == $value and $key_data == 'pages_categories_id')
                                    <td>{{$categories[$record['pages_categories_id']]}}</td>
                                @elseif($key_data == $value and $key_data == 'parent_id')
                                    @if($record['parent_id'] != null)
                                    <td>{{$categories[$record['parent_id']]}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @elseif($key_data == $value)
                                       <td>{{$value_data}}</td>
                                @endif
                            @endforeach
                        @endforeach
                            @if(isset($translationExist))
                            <td><a class="btn btn-info btn-sm" href="{{route('app.' . $tableName . '_translations.create', $record['id'])}}"><i class="fa fa-flag fm-sm" aria-hidden="true"></i> Translate</a></td>
                            @endif
                            <td><a class="btn btn-primary btn-sm" href="{{route('app.' . $tableName . '.show', $record['id'])}}"><i class="fa fa-eye fa-sm" aria-hidden="true"></i> View</a></td>
                            @if($tableName != 'resources')
                            <td><a class="btn btn-success btn-sm" href="{{route('app.' . $tableName . '.edit', $record['id'])}}"><i class="fa fa-pencil fa-sm" aria-hidden="true"></i> Edit</a></td>
                            @endif
                            <td><a id="del" onclick="deleteItem('{{route('app.' . $tableName . '.delete', $record['id'])}}')" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-sm"></i> Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

@endsection

@section('script')
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function deleteItem(route) {

            $.ajax({

                url: route,
                type: 'DELETE',
                data: {},
                dataType: 'json',
                success: function (r) {

                   $("#" + r.id).remove();

                },
                error: function () {
                    alert('error');
                }

            });

        }

    </script>
@endsection