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

            <div id="mainTitleDescription">{{trans('app.header_description')}}</div>

        </div>

        <div class="irregular-shape"></div>

        @include('front-end.pages.about')

        <h2>Apie</h2>

        @include('front-end.pages.virtual_rooms')

        <h2>Virtualus kambariai</h2>

        @include('front-end.pages.time_and_place')

        <h2>Vieta ir laikas</h2>

        @include('front-end.pages.tickets')

        <h2>Bilietai</h2>

        @include('front-end.pages.buy')

        <h2>Pirkti</h2>

        @include('front-end.pages.sponsors')

        {{--<h2>Remejai</h2>--}}

@endsection

