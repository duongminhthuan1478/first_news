<header class="main-header">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>N</b>P</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <img src="{{ asset(\App\Setting::getLogo())}}" alt="Logo" width="200px" height="50px">
        </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <script>
                    $.ajax({
                            type: "GET",
                            url: "{{url('api/submit-info/notify')}}",
                            success: function(data){
                                $("#notifyPlace").html(data);
                            }
                        });
                    var delayInMilliseconds = 5000; //1 second
                    setInterval(function() {
                        if($("ul.dropdown-menu").css('display') == 'none')
                        {
                            $.ajax({
                                type: "GET",
                                url: "{{url('api/submit-info/notify')}}",
                                success: function(data){
                                    $("#notifyPlace").html(data);
                                }
                            });
                        }
                    }, delayInMilliseconds)



                </script>
                <li id="notifyPlace" class="dropdown messages-menu">

                </li>
                <li id="notifyPlace" class="dropdown messages-menu">
                    <!--{{ $comment = \App\Comment::select('*', 'comments.id as cmtId')->leftJoin('news', function($join) {$join->on('news.id', '=', 'comments.newsId'); })->where("cmt_status","0")->get() }}-->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="readedCmt()">
                        <i class="fa  fa-comments-o"></i>
                        <span class="label label-success">{{\count($comment)}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <script>
                            function readedCmt(params) {
                                @foreach($comment as $key => $value)
                                    fetch("{{url('api/comment/read/'.$value->cmtId)}}"); //extract JSON from the http response
                                @endforeach
                            }
                        </script>
                        <li class="header">You have {{\count($comment)}} messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                @foreach($comment as $key => $value)
                                <li>
                                    <!-- start message -->
                                    <a href="{{ url('page/news/'.$value->slug) }}">
                                        <div class="pull-left">
                                            <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            {{ $value->title }}
                                            <small><i class="fa fa-clock-o"></i> {{ $value->created_at->diffForHumans() }}</small>
                                        </h4>
                                        <p>{{ $value->content }}</p>
                                    </a>
                                </li>
                                <!-- end message -->
                                @endforeach
                            </ul>
                        </li>
                        <li class="footer"><a href="{{url('admin/info-submit')}}">See All Messages</a></li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('images/'.auth()->user()->photo) }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset('images/'.auth()->user()->photo) }}" class="img-circle" alt="User Image">
                            <p>
                                {{ auth()->user()->name }}
                                <small>Member since {{ date('M. Y',strtotime(auth()->user()->created_at)) }}</small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('profile.update') }}" class="btn btn-success btn-flat">Profile</a>
                            </div>
                            <div>
                                <a href="{{ route('home') }}" target="_blank" class="btn btn-info btn-flat">Visit
                                    Website</a>
                            </div>
                            <div class="pull-right">
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="{{ url('/log-viewer') }}"><i class="fa fa-gears">&nbspLogs</i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
