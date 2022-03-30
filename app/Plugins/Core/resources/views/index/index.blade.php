<div class="row row-cards justify-content-center">
    <div class="col-md-12" >
        <div class="card-tabs border-0">
            <!-- Cards navigation -->
            <div class="btn-group btn-list" role="group" aria-label="Button group with nested dropdown">
                @if(!count(request()->all()))
                    <a href="/" class="btn btn-outline-primary disabled">
                        最新发布
                    </a>
                @else
                    <a href="/" class="btn btn-outline-primary">
                        最新发布
                    </a>
                @endif
                @foreach($topic_menu as $data)
                    @if(\Hyperf\Utils\Str::contains(core_http_url(),$data['parameter']))
                        <a href="{{$data['url']}}" class="btn btn-outline-primary disabled">
                            {{$data['name']}}
                        </a>
                    @else
                        <a href="{{$data['url']}}" class="btn btn-outline-primary">
                            {{$data['name']}}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @if($page->count())
        @foreach($page as $data)
            <article class="col-md-12">
                <div class="border-0 card card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-auto">
                                    <a href="/users/{{$data->user->username}}.html" class="avatar"
                                       style="background-image: url({{super_avatar($data->user)}})">

                                    </a>
                                </div>
                                <div class="col">
                                    <a href="/users/{{$data->user->username}}.html"
                                       style="margin-bottom:0;text-decoration:none;"
                                       class="card-title text-reset">{{$data->user->username}}</a>
                                    <div style="margin-top:1px">发布于:{{$data->created_at}}</div>
                                </div>
                                <div class="col-auto">
                                    @if($data->essence>0)
                                        <div class="ribbon bg-green text-h3">
                                            精华
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 markdown home-article">
                                    <a href="/{{$data->id}}.html" class="text-reset">
                                        <h2>
                                            @if($data->topping>0)
                                                <span class="text-red">
                                                    置顶
                                                </span>
                                            @endif
                                            {{$data->title}}</h2>
                                    </a>
                                    <span class="home-summary">{{ \Hyperf\Utils\Str::limit(core_default(deOptions($data->options)["summary"],"未捕获到本文摘要"),300) }}</span>
                                    <div class="row">
                                        @if(count(deOptions($data->options)["images"])<=6)
                                            @if(count(deOptions($data->options)["images"])>=3)
                                                @foreach(deOptions($data->options)["images"] as $key=>$image)
                                                    <div class="col-4 imgItem">
                                                        <a href="/{{$data->id}}.html"><img src="{{$image}}"
                                                                                           class="mio-lazy-img"
                                                                                           alt="{{$image}}"></a>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if(count(deOptions($data->options)["images"])===2)
                                                @foreach(deOptions($data->options)["images"] as $key=>$image)
                                                    <div class="col-4 imgItem">
                                                        <a href="/{{$data->id}}.html"><img src="{{$image}}"
                                                                                           class="mio-lazy-img"
                                                                                           alt="{{$image}}"></a>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if(count(deOptions($data->options)["images"])===1)
                                                @foreach(deOptions($data->options)["images"] as $key=>$image)
                                                    <div class="col-4 imgItem">
                                                        <a href="/{{$data->id}}.html"><img src="{{$image}}"
                                                                                           class="mio-lazy-img"
                                                                                           alt="{{$image}}"></a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 5px">
                            <div class="d-flex align-items-center">
                                <div class="col-auto bottomLine">
                                    <a href="/tags/{{$data->tag->id}}.html" style="text-decoration:none">
                                        <div class="card-circle">
                                            <img src="{{$data->tag->icon}}" alt="">
                                            <span>{{$data->tag->name}}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <span class="text-muted" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                          title="浏览量">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
                                                                                                  d="M0 0h24v24H0z"
                                                                                                  fill="none"/><circle
                                                    cx="12" cy="12" r="2"/><path
                                                    d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/></svg>
                                        {{$data->view}}
                                    </span>
                                    <a style="text-decoration:none;" core-click="like-topic" topic-id="{{$data->id}}"
                                       class="ms-3 text-muted cursor-pointer" data-bs-toggle="tooltip"
                                       data-bs-placement="bottom" title="点赞">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/>
                                        </svg>
                                        <span core-show="topic-likes">{{$data->like}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    @else
        <div class="col-md-12">
            <div class="border-0 card card-body">
                <div class="text-center card-title">暂无内容</div>
            </div>
        </div>
    @endif
    {!! make_page($page) !!}
</div>