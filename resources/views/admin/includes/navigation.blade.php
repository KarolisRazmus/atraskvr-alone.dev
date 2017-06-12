<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li class="treeview
        @if($tableName == 'pages')
            active
        @endif
        ">
        <a href="{{route('app.pages.index')}}">
            <i class="fa fa-files-o"></i> <span>Pages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        {{--<ul class="treeview-menu">--}}
            {{--<li><a href="http://atraskvr-alone.dev/admin/pages"><i class="fa fa-circle-o"></i> List</a></li>--}}
            {{--<li><a href="index2.html"><i class="fa fa-circle-o"></i> View</a></li>--}}
        {{--</ul>--}}
    </li>
    <li class="treeview
        @if($tableName == 'pages_categories')
            active
        @endif
        ">
        <a href="{{route('app.pages_categories.index')}}">
            <i class="fa fa-folder-open-o"></i> <span>Pages categories</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
    </li>
    <li class="treeview
        @if($tableName == 'orders')
            active
        @endif
        ">
        <a href="{{route('app.orders.index')}}">
            <i class="fa fa-list-ul"></i> <span>Orders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
    </li>
    <li class="treeview
        @if($tableName == 'reservations')
            active
        @endif
            ">
        <a href="{{route('app.reservations.index')}}">
            <i class="fa fa-calendar"></i> <span>Reservations</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
    </li>
    <li class="treeview
        @if($tableName == 'languages')
            active
        @endif
        ">
        <a href="{{route('app.languages.index')}}">
            <i class="fa fa-language"></i> <span>Languages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
    </li>
    <li class="treeview
        @if($tableName == 'users')
            active
        @endif
            ">
        <a href="{{route('app.users.index')}}">
            <i class="fa fa-users"></i> <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
    </li>
</ul>