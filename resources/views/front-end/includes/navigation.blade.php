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

                <li><a href="#{{strtolower(str_replace(" ", "-", trans('app.about_title')))}}">{{trans('app.about_title')}}</a></li>

                    @foreach($categories as $category)

                        @if($category['id'] == 'virtual_rooms_category_id' and $category['pages'] != [])

                            @foreach($category['pages'] as $experience)

                                @if($experience['translation'] != [] and isset($experience['translation']['title']))

                                    <li class="dropdown">

                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{trans('app.virtual_rooms_title')}}<span class="caret"></span></a>

                                        <ul class="dropdown-menu">

                                            @foreach($category['pages'] as $dropdownItem)

                                                @if($dropdownItem['translation'] != [] and isset($dropdownItem['translation']['title']))

                                                    @if(($dropdownItem['translation']['description_long']) == 'translation value')

                                                        <li>

                                                        <a href="#{{strtolower(str_replace(" ", "-", trans('app.virtual_rooms_title')))}}">

                                                            {{$dropdownItem['translation']['title']}}</a>

                                                        </li>

                                                    @else

                                                        <li>

                                                        <a href="{{app()->getLocale(). "/" . $dropdownItem['translation']['slug']}}">

                                                            {{$dropdownItem['translation']['title']}}</a>

                                                        </li>

                                                    @endif

                                                @endif

                                            @endforeach

                                        </ul>

                                    @break
{{--TODO jei nera isverstu experiencu title ir short description tai nereik isvis virtual rooms menujyje:)--}}
                                {{--@else--}}

                                    {{--@if(end($category['pages']) == $experience)--}}

                                    {{--<li><a href="#{{trans('app.virtual_rooms_title')}}">{{trans('app.virtual_rooms_title')}}</a></li>--}}

                                    {{--@endif--}}

                                @endif

                            @endforeach

                        @endif

                    @endforeach

                <li><a href="#{{strtolower(str_replace(" ", "-", trans('app.time_and_place_title')))}}">{{trans('app.time_and_place_title')}}</a></li>

                <li><a href="#{{strtolower(str_replace(" ", "-", trans('app.tickets_title')))}}">{{trans('app.tickets_title')}}</a></li>

                <li><a href="#{{strtolower(str_replace(" ", "-", trans('app.sponsors_title')))}}">{{trans('app.sponsors_title')}}</a></li>

                @foreach($categories as $category)

                    @if($category['id'] == 'menu_category_id' and $category['pages'] != [])

                        @foreach($category['pages'] as $page)

                            @if(isset($page['translation']['description_long']) and isset($page['translation']['title']) and isset($page['translation']['description_long']))

                                @if(array_search($page['translation']['title'], [trans('app.about_title'), trans('app.virtual_rooms_title'), trans('app.time_and_place_title'), trans('app.tickets_title'), trans('app.sponsors_title')]) == false)

                                    <li><a href="{{app()->getLocale(). "/" . $page['translation']['slug']}}">

                                    {{$page['translation']['title']}}</a></li>

                                @endif

                            @endif

                        @endforeach

                    @endif

                @endforeach

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

