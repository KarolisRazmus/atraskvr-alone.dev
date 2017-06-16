<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">

                <li><a href="#{{trans('app.about_title')}}">{{trans('app.about_title')}}</a></li>

                @foreach($pages as $page)

                    @if($page['pages_categories_id'] == 'virtual_rooms_category_id')

                        @if($page['translation']['languages_id'] == app()->getLocale())

                            <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{trans('app.virtual_rooms_title')}}<span class="caret"></span></a>

                                @foreach($pages as $dropdownItem)

                                    @if($dropdownItem['pages_categories_id'] == 'virtual_rooms_category_id')

                                        @if($dropdownItem['translation']['languages_id'] == app()->getLocale())

                                            <ul class="dropdown-menu">

                                                <li>

                                                    @if($dropdownItem['translation']['description_long'] == 'translation value')

                                                        <a href="#{{trans('app.virtual_rooms_title')}}">

                                                            @else

                                                        <a href="{{app()->getLocale(). "/" . $dropdownItem['translation']['slug']}}">

                                                    @endif

                                                        {{$dropdownItem['translation']['title']}}</a></a>

                                                </li>

                                            </ul>

                                        @endif

                                    @endif

                                @endforeach

                            </li>

                        @endif

                    @endif

                @endforeach

                <li><a href="#{{trans('app.time_and_place_title')}}">{{trans('app.time_and_place_title')}}</a></li>

                <li><a href="#{{trans('app.tickets_title')}}">{{trans('app.tickets_title')}}</a></li>

                <li><a href="#{{trans('app.sponsors_title')}}">{{trans('app.sponsors_title')}}</a></li>

                {{--@foreach($pages as $page)--}}

                    {{--@if($page['pages_categories_id'] == 'menu_category_id')--}}

                        {{--@if($page['translation']['languages_id'] == app()->getLocale())--}}

                            {{--@if(array_search($page['name'], [trans('app.about_title'), trans('app.virtual_rooms_title'), trans('app.time_and_place_title'), trans('app.tickets_title'), trans('app.sponsors_title')]) == false)--}}

                                {{--<li>--}}

                                    {{--@if($page['translation']['description_long'] == 'translation value')--}}

                                        {{--<a href="#{{$page['translation']['title']}}">--}}

                                            {{--@else--}}

                                        {{--<a href="{{app()->getLocale(). "/" . $page['translation']['slug']}}">--}}

                                    {{--@endif--}}

                                        {{--{{$page['translation']['title']}}</a></a></li>--}}

                            {{--@endif--}}

                        {{--@endif--}}

                    {{--@endif--}}

                {{--@endforeach--}}

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{trans('app.language')}}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/lt">Lt</a></li>
                        <li><a href="/en">En</a></li>
                    </ul>
                </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

