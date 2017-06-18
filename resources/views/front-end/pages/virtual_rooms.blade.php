
    @foreach($categories as $category)

        @if($category['id'] == 'virtual_rooms_category_id' and $category['pages'] != [])

            @foreach($category['pages'] as $page)

                @if($page['translation'] != [] and isset($page['translation']['title']) and isset($page['translation']['description_short']) and isset($page['cover_image']))

                    <div id={{strtolower(str_replace(" ", "-", trans('app.virtual_rooms_title')))}} class="col-xs-12"><h2 class="page_title_h2">{{trans('app.virtual_rooms_title')}}</h2>

                        <div class="row col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10 col-lg-offset-1 col-lg-10">

                            @foreach($category['pages'] as $experience)

                                @if($experience['translation'] != [] and isset($experience['translation']['title']) and isset($experience['translation']['description_short']) and isset($experience['cover_image']))

                                    <div class="text-center virtual-rooms-experiences col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6 col-md-6 col-lg-6"><img id="virtual-room-img" class="img-responsive center-block img-circle" src="{{asset($experience['cover_image']['path'])}}" alt="">

                                        <h3>{{$experience['translation']['title']}}</h3>

                                        <div class="row">
                                            <div class="col-lg-offset-2 col-lg-8">
                                                <p>{{$experience['translation']['description_short']}}</p>
                                            </div>
                                        </div>

                                    @if($experience['translation']['description_long'] != 'translation value')

                                        <div class="row">
                                            <div class="col-lg-offset-4 col-lg-4">
                                                <a class="btn btn-info btn-sm" href="{{app()->getLocale(). "/" . $experience['translation']['slug']}}"><i class="fa fa-info-circle fm-sm" aria-hidden="true"></i>{{' ' . trans('app.more_info')}}</a>
                                            </div>
                                        </div>

                                    @endif

                                    </div>

                                @endif

                            @endforeach

                        </div>

                    </div>

                @break

                @endif

            @endforeach

        @endif

    @endforeach


