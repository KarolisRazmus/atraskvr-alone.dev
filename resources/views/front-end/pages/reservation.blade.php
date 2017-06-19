<div class="container">
    <!-- Trigger the modal with a button -->
    <div id="mainTitleDescription">
        <button id="cta" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">{{trans('app.header_description')}}</button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{trans('app.cta_reservation')}}</h4>
                </div>
                <div class="modal-body">





                        {{--<nav aria-label="...">--}}
                            {{--<ul class="pagination pagination-lg justify-content-center">--}}


                                {{--@foreach($order_days as $key => $day)--}}

                                    {{--@if($key % 7 == 0)--}}

                                        {{--<br>--}}

                                    {{--@endif--}}

                                    {{--<li class="page-item--}}

                        {{--@if($date_from_url == $day)--}}
                                    {{--{{' active'}}--}}
                                    {{--@endif--}}

                                            {{--"><a class="page-link" href="{{route('app.reservations.create', $day)}}">{{$day}}</a></li>--}}

                                {{--@endforeach--}}


                            {{--</ul>--}}

                        {{--</nav>--}}

                        {{--<br><br>--}}


                        {{--<form method="POST" action="{{route('app.reservations.store')}}">--}}


                            {{--<div id="accordion" role="tablist" aria-multiselectable="true">--}}


                                {{--@if(isset($message))--}}

                                    {{--@if(substr($message, -1) == '!')--}}

                                        {{--<div class="alert alert-success">--}}
                                            {{--<strong>{{ $message }}</strong>--}}
                                        {{--</div>--}}

                                    {{--@else--}}

                                        {{--<div class="alert alert-danger">--}}
                                            {{--<strong>{{ $message }}</strong>--}}
                                        {{--</div>--}}

                                    {{--@endif--}}

                                {{--@endif--}}




                                {{--@foreach($order_days as $day)--}}

                                    {{--@if($day == $date_from_url)--}}

                                        {{--<h1 class="display-4">{{$day}}</h1>--}}

                                        {{--@foreach($categories as $category)--}}

                                            {{--@if($category['id'] == 'virtual_rooms_category_id' and $category['pages'] != [])--}}

                                                {{--@foreach($category['pages'] as $experience)--}}



                                                    {{--<div class="card">--}}
                                                        {{--<div class="card-header" role="tab" id="headingOne">--}}
                                                            {{--<h5 class="mb-0">--}}
                                                                {{--<a data-toggle="collapse" data-parent="#accordion"--}}
                                                                   {{--href="#{{$experience['translation']['slug']}}"--}}
                                                                   {{--aria-expanded="true"--}}
                                                                   {{--aria-controls="{{$experience['translation']['slug']}}">--}}
                                                                    {{--{{$experience['translation']['title']}}--}}
                                                                {{--</a>--}}
                                                            {{--</h5>--}}
                                                        {{--</div>--}}


                                                        {{--<div id="{{$experience['translation']['slug']}}"--}}
                                                             {{--class="collapse" role="tabpanel" aria-labelledby="headingOne">--}}
                                                            {{--<div class="card-block">--}}

                                                                {{--@if($day == $today)--}}

                                                                    {{--@if($disabledTimes != [])--}}

                                                                        {{--@foreach($disabledTimes as $key => $value)--}}

                                                                            {{--@if($key % 6 == 0)--}}

                                                                                {{--<br>--}}

                                                                            {{--@endif--}}

                                                                            {{--<input type="checkbox" name="{{$experience['id'] . '[]'}}"--}}
                                                                                   {{--value="{{$day . ' ' . $value}}"--}}

                                                                                    {{--{{'disabled'}}--}}

                                                                            {{-->{{$value}}--}}


                                                                        {{--@endforeach--}}

                                                                    {{--@endif--}}


                                                                    {{--@foreach($enabledTimes as $key => $value)--}}

                                                                        {{--@if($key % 6 == 0)--}}

                                                                            {{--<br>--}}

                                                                        {{--@endif--}}

                                                                        {{--<input type="checkbox" name="{{$experience['id'] . '[]'}}"--}}
                                                                               {{--value="{{$day . ' ' . $value}}"--}}

                                                                        {{--@if($reservations != [])--}}

                                                                            {{--@foreach($reservations as $reservation)--}}

                                                                                {{--@foreach($reservation['time'] as $time)--}}

                                                                                    {{--@if($time == $day . ' ' . $value and $experience['id'] == $reservation['pages_id'])--}}

                                                                                        {{--{{'disabled'}}--}}

                                                                                            {{--@endif--}}

                                                                                        {{--@endforeach--}}

                                                                                    {{--@endforeach--}}

                                                                                {{--@endif--}}

                                                                        {{-->{{$value}}--}}

                                                                    {{--@endforeach--}}






                                                                {{--@elseif($day != $today)--}}

                                                                    {{--@foreach($shop_working_times as $key => $value)--}}

                                                                        {{--@if($key % 6 == 0)--}}

                                                                            {{--<br>--}}

                                                                        {{--@endif--}}

                                                                        {{--<input type="checkbox" name="{{$experience['id'] . '[]'}}"--}}
                                                                               {{--value="{{$day . ' ' . $value}}"--}}

                                                                        {{--@if($reservations != [])--}}

                                                                            {{--@foreach($reservations as $reservation)--}}

                                                                                {{--@foreach($reservation['time'] as $time)--}}

                                                                                    {{--@if($time == $day . ' ' . $value and $experience['id'] == $reservation['pages_id'])--}}

                                                                                        {{--{{'disabled'}}--}}

                                                                                            {{--@endif--}}

                                                                                        {{--@endforeach--}}

                                                                                    {{--@endforeach--}}

                                                                                {{--@endif--}}

                                                                        {{-->{{$value}}--}}

                                                                    {{--@endforeach--}}
                                                                {{--@endif--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}

                                                {{--@endforeach--}}
                                            {{--@endif--}}
                                        {{--@endforeach--}}
                                    {{--@endif--}}
                                {{--@endforeach--}}

                            {{--</div>--}}


                            {{--{{csrf_field()}}--}}
                            {{--<input class="btn btn-outline-primary submit-button" type="submit">--}}
                        {{--</form>--}}
























                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

</div>