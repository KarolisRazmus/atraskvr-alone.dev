<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">

                @foreach($pages as $page)

                    @if($page['translation'] != 0)

                        @if($page['pages_categories_id'] == 'menu_category_id')

                            @if($page['name'] == 'Virtualus kambariai')

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$page['translation']['title']}}<span class="caret"></span></a>

                                    <ul class="dropdown-menu">

                                        @foreach($pages as $dropdownItem)

                                            @if($dropdownItem['pages_categories_id'] == 'virtual_rooms_category_id')

                                                @if($dropdownItem['translation'] != 0)

                                                    <li><a href="#">{{$dropdownItem['translation']['title']}}</a></li>

                                                @endif

                                            @endif

                                        @endforeach

                                    </ul>

                                </li>
                            @else
                                <li><a href="#">{{$page['name']}}</a></li>
                            @endif
                        @endif

                    @endif

                @endforeach

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{trans('app.language')}}<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/lt">Lt</a></li>
                            <li><a href="/en">En</a></li>
                        </ul>
                    </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

