@extends('front-end.main')

@section('content')

        <div id="part-1">

            <div id="elektroMarkt">

                <h4 class="logo-title">{{trans('app.inspired_by')}} </h4>
                <div id="elektroMarktLogo"></div>

            </div>

            <div id="mainTitle">

                {{trans('app.main_title')}}

            </div>

            @include('front-end.pages.reservation')

        </div>

        <div class="irregular-shape"></div>

        @include('front-end.pages.about')

        @include('front-end.pages.virtual_rooms')

        @include('front-end.pages.time_and_place')

        @include('front-end.pages.tickets')

        {{--<h2>Bilietai</h2>--}}

        @include('front-end.pages.sponsors')

@endsection

