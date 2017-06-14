@extends('admin.main')

@section('title', str_replace('_', ' ', ucfirst($tableName)))

@section('content')

        <h4>
            @if(isset($record['name']))
                @if($record['name']!= null)
                    @if(isset($record['name']))
                        {{ucfirst($record['name'])}}
                    @endif
                @endif
            @else
                @if($tableName == 'pages_categories')
                    {{ucfirst(substr($tableName, 0, -3)) . 'y'}}
                @else{{ucfirst(substr($tableName, 0, -1))}}
                @endif
            @endif
        </h4>

        <br>

        <table class="table">
            <thead class="thead-default">
            <tr>
                <th>key</th>
                <th>value</th>
            </tr>
            </thead>
            <tbody>

            @foreach($record as $key => $value)
                <tr id="{{$record['id']}}">

                    @if($key == 'path')
                        <td>cover image</td>
                        <td><img src="{{asset($value)}}"></td>
                </tr>
                <tr>
                    <td>{{$key}}</td>
                    <td>{{$value}}</td>
                </tr>
                @elseif($key == 'category')

                @elseif($key == 'pages_categories_id')
                    <td>pages category</td>
                    <td>{{$record['category']['name']}}</td>

                @elseif($key == 'parent_id')
                    <td>parent id</td>
                    @if($value != null )
                        <td>{{$parent_id[$record['parent_id']]}}</td>
                    @endif

                @elseif($key == 'count')
                @elseif($key == 'cover_image_id')
                    <td>cover image</td>
                    @if($value)
                        <td><img style="width:70px" src={{asset($value['path'])}}></td>
                    @else <td><img style="width:70px" src="{{asset('upload\2017\06\12\1497265977_no-image-box.png') }}"></td>
                    @endif

                @elseif($key == 'resources_connections')
                    <td>files</td>
                    <td>
                        @foreach($record['resources_connections'] as $connection)
                            <img style="width:70px" src={{asset($connection['resource']['path'])}}><br><br>
                        @endforeach
                    </td>

                @else
                    <td>{{$key}}</td>
                    <td>{{$value}}</td>

                @endif

            @endforeach

            </tbody>

        </table>

        @if(isset($translationExist))
            <br>
            <br>
            <h4>
                @if($translations != null)
                    @if(isset($record['name']))
                        {{ucfirst($record['name'] . ' translations')}}
                    @else
                        @if($tableName == 'pages_categories')
                            {{ucfirst(substr($tableName, 0, -3)) . 'y translations'}}
                        @else{{ucfirst(substr($tableName, 0, -1)) . ' translations'}}
                        @endif
                    @endif
                @endif
            </h4><br>
            <table class="table">
                @foreach($translations as $translation)
                    <thead class="thead-default">
                    <tr>
                        <th></th>
                        <th>{{$languages_names[$translation['languages_id']]}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($translation as $key_translation => $value_translation)
                        <tr>
                            @foreach($fields_translations as $key_field => $value_field)
                                @if($value_field == $key_translation)
                                    <td>{{$key_translation}}</td>
                                    <td>{{$value_translation}}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        @endif
        @if($tableName != 'resources')
            <td><a class="btn btn-success btn-sm" href="{{route('app.' . $tableName . '.edit', $record['id'])}}"><i class="fa fa-pencil fa-sm" aria-hidden="true"></i> Edit</a></td>
        @endif
        <a class="btn btn-sm btn-primary" href="{{route('app.' . $tableName . '.index')}}">{{str_replace('_', ' ', ucfirst($tableName))}} list</a>
    <br><br>

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
                success: function () {
                    alert('DELETED')

                },
                error: function () {
                    alert('Error');
                }
            });
        }
    </script>
@endsection