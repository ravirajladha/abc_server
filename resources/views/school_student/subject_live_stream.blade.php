@include('inc.header')
<style>
    .video-playlist .title {
        padding-left: 1rem;
        color: #fff;
    }

    .video-playlist p {
        padding: 1rem;
        color: var(--secondary);
    }

    .video-playlist .videos {
        height: 70%;
        overflow-y: auto;
    }

    .video-playlist .videos::-webkit-scrollbar {
        width: .4rem;
        border-radius: .4rem;
        background-color: #0005;
    }

    .video-playlist .videos::-webkit-scrollbar-thumb {
        border-radius: .4rem;
        background-color: #fff;
    }

    .video-playlist .videos .video {
        position: relative;
        width: 100%;
        height: 5rem;

        display: flex;
        /* justify-content: center; */
        align-items: center;

        padding: 0 1rem;
        margin-top: .1rem;
        cursor: pointer;

        border-radius: .5rem;
    }

    .video-playlist .videos .video:hover {
        background-color: #0003;
    }

    .video-playlist .videos .video.active {
        background-color: #0003;
        color: var(--secondary);
    }

    .main-video video {
        width: 100%;
        border-radius: .5rem;
    }

    .video img {
        position: absolute;
        left: 1rem;
        top: 30%;
        transform: translateY(-50%);

        width: 1.5rem;
        height: 1.5rem;

        filter: invert(100%);
    }

    .video-playlist .videos .video.active img {
        filter: invert(100%) sepia(100%) saturate(2000%) hue-rotate(360deg);
    }

    .video p {
        margin-left: 2.5rem;
    }

    .video h3 {
        width: 23rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;

        font: 100 1rem sans-serif;
        padding: 0 .5rem;
    }

    @media (max-width: 992px){
    .main-content.menu-active {
    padding-left: 0;
}
#course-tabs{
    display:none;
}
.save-div{
    display: flex !important;
}
#dropdownMenu2{
    margin-left: 5px;
}

}
</style>
<style>
    /* .result p{
        padding-left: 30px;
    } */
.result p{
    padding-left: 1rem;
    margin-bottom: 0rem;
    font-weight: 500;
    font-size: .9rem;
}
</style>

@php
    use Carbon\Carbon;
    use App\Models\Assesment;
        use App\Models\Video;
        use App\Models\Section;
        use App\Models\Lab;
        use App\Models\Subject;
@endphp
@php

    use App\Models\Quiz;
    use App\Models\Quiz_result;

@endphp

    {{-- video.js library --}}
<link href="https://vjs.zencdn.net/8.6.0/video-js.css" rel="stylesheet" />

<body class="color-theme-orange mont-font">

    {{-- <div class="preloader"></div> --}}


    <div class="main-wrapper">

        <!-- navigation -->
        @include('inc.navbar')
        <!-- navigation -->
        <!-- main content -->
        <div class="main-content menu-active">
            @include('inc.topbar')
            <div class="middle-sidebar-bottom">
                <div class="middle-sidebar-left">
                    <div class="row">
                        <div class="col-xl-8 col-xxl-9">
                            <div class="card border-0 mb-0 rounded-lg overflow-hidden">
                                    @php

                                    @endphp

                                <video
                                id="video"
                                class="video-js"
                                controls
                                preload="auto"
                                width="900"
                                height="490"
                                data-setup="{}"
                              >
                                <source src="{{ asset($video_details->video_file) }}" type="video/mp4" />
                                <source src="MY_VIDEO.webm" type="video/webm" />
                                <p class="vjs-no-js">
                                  To view this video please enable JavaScript, and consider upgrading to a
                                  web browser that
                                  <a href="https://videojs.com/html5-video-support/" target="_blank"
                                    >supports HTML5 video</a
                                  >
                                </p>
                              </video>


                            </div>


                        </div>
                        <div class="col-xl-4 col-xxl-3" id="course-tabs">
                            <div class="card d-block w-100 border-0 shadow-xss rounded-lg overflow-hidden">
                                <ul class="nav nav-tabs xs-p-4 d-flex align-items-center justify-content-between product-info-tab border-bottom-0"
                                    id="pills-tab" role="tablist">
                                    <li class="active list-inline-item"><a
                                            class="fw-700 pb-sm-3 pt-sm-3 xs-mb-2 ml-sm-5 font-xssss text-grey-500 ls-3 d-inline-block text-uppercase {{ $data['id'] == 0 ? 'active' : '' }}"
                                            href="#navtabs0" data-toggle="tab">Course</a></li>
                                    <li class="list-inline-item"><a
                                            class="fw-700 pb-sm-3 pt-sm-3 xs-mb-2 font-xssss text-grey-500 ls-3 d-inline-block text-uppercase {{ $data['id'] == 1 ? 'active' : '' }}"
                                            href="#navtabs1" data-toggle="tab">Notes</a></li>

                                    <li class="list-inline-item"><a
                                            class="fw-700 pb-sm-3 pt-sm-3 xs-mb-2 mr-sm-5 font-xssss text-grey-500 ls-3 d-inline-block text-uppercase {{ $data['id'] == 2 ? 'active' : '' }}"
                                            href="#navtabs2" data-toggle="tab">Chats</a></li>
                                </ul>
                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show {{ $data['id'] == 0 ? 'active' : '' }}" id="navtabs0">
                                    <div class="video-playlist shadow-xss"
                                        style="background-color: #fff;border-radius:10px">
                                        <p class="text-dark fw-300 font-xss">{{count($data['videos'])}}&nbsp; Videos</p>
                                        <div class="videos scroll-bar" style="height: 310px;">

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade show {{ $data['id'] == 1 ? 'active' : '' }}" id="navtabs1">
                                    <div
                                        class="card w-100 d-block chat-body p-0 border-0 shadow-xss rounded-lg mb-3 position-relative">
                                        <div class="messages-content scroll-bar p-3" style="height: 390px;">
                                            @foreach ($data['notes'] as $note)
                                                <div class="message-item outgoing-message">
                                                    <div class="message-wrap">{{ $note->note }}</div>
                                                    <div class="message-user">
                                                        <div>
                                                            <div class="time">@php echo Carbon::parse($note->created_at)->diffForHumans() @endphp<i
                                                                    class="ti-double-check text-info"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <form method="post" action="/save_school_notes"
                                            class="chat-form position-absolute bottom-0 w-100 left-0 bg-white z-index-1 p-3 shadow-xs theme-dark-bg ">
                                            @csrf
                                            <input type="hidden" name="subject_id" value="{{ $data['subject']->id }}">

                                            <div class="form-group"><input type="text" name="note"
                                                    placeholder="Start typing.."></div>
                                            <button class="bg-current"><i
                                                    class="ti-arrow-right text-white"></i></button>
                                        </form>
                                    </div>

                                </div>

                                <div class="tab-pane fade show {{ $data['id'] == 2 ? 'active' : '' }}" id="navtabs2">
                                    <div
                                        class="card w-100 d-block chat-body p-0 border-0 shadow-xss rounded-lg mb-3 position-relative">
                                        <div class="messages-content scroll-bar p-3" id="messagesContent" style="height: 390px;">

                                            @php
                                                $merged_messages = $data['sent_messages']->merge($data['received_messages'])->sortBy('created_at');
                                            @endphp
                                            @foreach ($merged_messages as $message)
                                                @if ($message->sender_id == session('rexkod_user_id'))
                                                    <div class="message-item outgoing-message">
                                                        <div class="message-user">
                                                            <figure class="avatar">
                                                                <img src="https://via.placeholder.com/50x50.png"
                                                                    alt="image">
                                                            </figure>
                                                            <div>
                                                                <h5>You</h5>
                                                                <div class="time">@php echo Carbon::parse($message->created_at)->diffForHumans() @endphp<i
                                                                        class="ti-double-check text-info"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="message-wrap">{{ $message->message }}</div>
                                                    </div>
                                                @else
                                                    <div class="message-item">
                                                        <div class="message-user">
                                                            <figure class="avatar">
                                                                <img src="https://via.placeholder.com/50x50.png"
                                                                    alt="image">
                                                            </figure>
                                                            <div>
                                                                <h5 class="font-xssss mt-2">
                                                                    Teacher</h5>
                                                                <div class="time">@php echo Carbon::parse($message->created_at)->diffForHumans() @endphp</div>
                                                            </div>
                                                        </div>
                                                        <div class="message-wrap shadow-none">
                                                            {{ $message->message }}</div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <form method="post" action="/school_send_message"
                                            class="chat-form position-absolute bottom-0 w-100 left-0 bg-white z-index-1 p-3 shadow-xs theme-dark-bg ">
                                            @csrf
                                            <input type="hidden" name="receiver_id"
                                                value="{{ $data['teacher']->auth_id }}">
                                            <input type="hidden" name="subject_id"
                                                value="{{ $data['subject_id'] }}">

                                            <div class="form-group search-box"><input type="text" name="message"
                                                    placeholder="Start typing.."></div>
                                            <button class="bg-current"><i
                                                    class="ti-arrow-right text-white"></i></button>
                                        </form>
                                        <div class="row w-100" style="position: absolute;z-index: 10;">
                                            <div class="col-12">
                                                <div class="result scroll-bar card border-0 bg-white shadow-xs"
                                                    ><p></p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-12 col-xxl-12">
                            <div
                                class="card d-block border-0 rounded-lg overflow-hidden dark-bg-transparent bg-transparent mt-4 pb-4">
                                <div class="row">
                                    <div class="col-8">
                                        <h2 class="fw-700 font-md d-block lh-4 mb-2 title">
                                            {{ $video_details->video_name }}</h2>
                                    </div>
                                    <div class="col-4 save-div">
                                        <a href="#"
                                            class="btn-round-md ml-3 mb-2 d-inline-block float-right rounded-lg bg-danger"><i
                                                class="feather-bookmark font-sm text-white"></i></a>
                                        <a href="#"
                                            class="btn-round-md ml-0 d-inline-block float-right rounded-lg bg-greylight"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="feather-share-2 font-sm text-grey-700"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right p-3 border-0 shadow-xss"
                                            aria-labelledby="dropdownMenu2">
                                            <ul class="d-flex align-items-center mt-0 float-left">
                                                <li class="mr-2">
                                                    <h4 class="fw-600 font-xss text-grey-900  mt-2 mr-3">Share: </h4>
                                                </li>
                                                <li class="mr-2"><a href="#"
                                                        class="btn-round-md bg-facebook"><i
                                                            class="font-xs ti-facebook text-white"></i></a></li>
                                                <li class="mr-2"><a href="#"
                                                        class="btn-round-md bg-twiiter"><i
                                                            class="font-xs ti-twitter-alt text-white"></i></a></li>
                                                <li class="mr-2"><a href="#"
                                                        class="btn-round-md bg-linkedin"><i
                                                            class="font-xs ti-linkedin text-white"></i></a></li>
                                                <li class="mr-2"><a href="#"
                                                        class="btn-round-md bg-instagram"><i
                                                            class="font-xs ti-instagram text-white"></i></a></li>
                                                <li class="mr-2"><a href="#"
                                                        class="btn-round-md bg-pinterest"><i
                                                            class="font-xs ti-pinterest text-white"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <span class="font-xssss fw-700 text-grey-900 d-inline-block ml-0 text-dark">{{$data['teacher']->user->name}}</span>

                            </div>


                        </div>
                        <div class="col-xl-12 col-xxl-12 col-lg-12">
                            <div class="card d-block border-0 rounded-lg overflow-hidden p-4 shadow-xss mt-4" style="background: #cfe7ff">
                                @if (!empty($test->id))
                                    @if ($test_result && $test_result->score_percentage >= 50)
                                        <a href="/view_subject_certificate/{{$data['subject_id']}}/{{$test_result->score_percentage}}">
                                            <h2 class="fw-700 font-sm mt-1 pl-1">View certificate. <i class="ti-arrow-right font-sm text-dark float-right"></i></h2>
                                        </a>
                                    @else
                                        <a href="/take_school_test/{{ $data['subject_id']}}/{{ $test->id }}">
                                            <h2 class="fw-700 font-sm mt-1 pl-1">Take test to get certified. <i class="ti-arrow-right font-sm text-dark float-right"></i></h2>
                                        </a>
                                    @endif
                                @else
                                    <a href="#">
                                        <h2 class="fw-700 font-sm mt-1 pl-1">Test coming soon!. <i class="ti-arrow-right font-sm text-dark float-right"></i></h2>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12 pt-0 mb-3 mt-4">
                            <h2 class="fw-400 font-lg d-block">Mini <b>Projetcs</b> <a href="#"
                                    class="float-right"><i class="feather-edit text-grey-500 font-xs"></i></a></h2>
                        </div>

                        <div class="col-lg-12 pt-2">
                            <div
                                class="owl-carousel category-card owl-theme overflow-hidden overflow-visible-xl nav-none">
                                @foreach ($data['mini_projects'] as $mini_project)
                                    <div class="item">
                                        <div
                                            class="card w200 d-block border-0 shadow-xss rounded-lg overflow-hidden mb-4">

                                            <div class="card-image w-100 ">
                                                <img src="/{{ $mini_project->project_image }}" alt="image"
                                                    class="w-100" style="height: 100px">
                                            </div>
                                            <div class="card-body d-block w-100 pl-4 pr-4 pb-4 text-center">

                                                <div class="clearfix"></div>
                                                <h4 class="fw-700 font-xsss mt-3 mb-1"><a href="#"
                                                        class="text-dark text-grey-900">
                                                    </a>{{ ucwords($mini_project->project_name) }}</h4>
                                                <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-2">
                                                    {{ $mini_project->description }}</p>
                                                <a href="/view_school_project/{{ $mini_project->id }}"
                                                    class="text-dark text-grey-900">
                                                    <span
                                                        class="live-tag mt-2 mb-3 bg-danger p-2 z-index-1 rounded-lg text-white font-xsssss text-uppersace fw-700 ls-3">Start</span></a>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach


                            </div>
                        </div>

                        {{--  --}}
                        <div class="col-lg-12 pt-0 mb-3 mt-4">
                            <h2 class="fw-400 font-lg d-block">MY <b>Assesments</b> <a href="#"
                                    class="float-right"><i class="feather-edit text-grey-500 font-xs"></i></a></h2>
                        </div>

                        <div class="col-lg-12 pt-2">
                            <div
                                class="owl-carousel category-card owl-theme overflow-hidden overflow-visible-xl nav-none">
                                @foreach ($data['assesments_given'] as $assesments_given)
                                    <div class="item">
                                        <div
                                            class="card w200 d-block border-0 shadow-xss rounded-lg overflow-hidden mb-4">
                                            <div class="card-body d-block w-100 pl-4 pr-4 pb-4 text-center">
                                                <div class="clearfix"></div>
                                                <h4 class="fw-700 font-xsss mt-3 mb-1"><a href="/view_assesment_results/{{$assesments_given->id}}"
                                                        class="text-dark text-grey-900">{{ ucwords($assesments_given->video_name) }}
                                                    </a></h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-xl-12 col-xxl-12 col-lg-12">


                            <div class="card d-block border-0 rounded-lg overflow-hidden p-4 shadow-xss mt-4">
                                <h2 class="fw-700 font-sm mb-3 mt-1 pl-1 mb-3">Description</h2>
                                <p class="font-xssss fw-500 lh-28 text-grey-600 mb-0 pl-2">
                                    {{$data['subject']->description}}
                                </p>
                            </div>

                            <div class="card d-block border-0 rounded-lg overflow-hidden p-4 shadow-xss mt-4 mb-5">
                                <h2 class="fw-700 font-sm mb-3 mt-1 pl-1 mb-3">Instructor</h2>
                                <div class="row">
                                    <div class="col-sm-4">

                                        <div>
                                            <img id="ma" src="/assets/images/manjunath.jpeg"
                                                alt="Author Images" width="300">

                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="author-content">
                                            <h3 class="title">Manjunath Aradhya</h3>
                                            <span class="subtitle">Senior Instructor</span>
                                            <p class="font-xssss fw-500 lh-28 text-grey-600 mb-0 pl-2">A passionate
                                                Tech-Guru, a revered author of numerous hot-selling Computer Science
                                                books, a renowned Educationist, and a celebrated Technocrat. A former
                                                Business-Associate at Wipro Technologies and organically connected to
                                                the academia all through my 24+ years of Journey in Tech-skilling, I
                                                have been impact-fully instrumental in personally transforming 60000+
                                                On-campus & Off-campus Tech-graduates to successful IT-Professionals.
                                            </p>
                                            <p class="font-xssss fw-500 lh-28 text-grey-600 mb-0 pl-2">After creating
                                                more than a dozen courses on Microsoft Access databases and programming
                                                in VBA, many students have contacted me with discussions on specific
                                                problems and scenarios. From these discussions,</p>
                                            <ul class="social-share">
                                                <li><a href="#"><i class="icon-facebook"></i></a></li>
                                                <li><a href="#"><i class="icon-twitter"></i></a></li>
                                                <li><a href="#"><i class="icon-linkedin2"></i></a></li>
                                                <li><a href="#"><i class="icon-youtube"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('inc.sidebar')
            </div>
        </div>
        <!-- main content -->
        <div class="app-footer border-0 shadow-lg">
            <a href="/default_live_stream/{{$data['subject']->id}}/0" class="nav-content-bttn nav-center"><i class="feather-home"></i></a>
            <a href="/aprex/video_player_mobile/{{$data['subject']->id}}" class="nav-content-bttn"><i class="feather-package"></i></a>
            <a href="/aprex/chat/{{$data['subject']->id}}" class="nav-content-bttn" data-tab="chats"><i
                    class="feather-layout"></i></a>
            <a href="/aprex/notes/{{$data['subject']->id}}" class="nav-content-bttn"><i class="feather-layers"></i></a>
            {{-- <a href="/aprex/chat" class="nav-content-bttn sidebar-layer"><i class="feather-layers"></i></a> --}}
            {{-- <a href="default-settings.html" class="nav-content-bttn"><img src="https://via.placeholder.com/50x50.png"
                    alt="user" class="w30 shadow-xss"></a> --}}
        </div>

        <div class="app-header-search">
            <form class="search-form">
                <div class="form-group searchbox mb-0 border-0 p-1">
                    <input type="text" class="form-control border-0" placeholder="Search...">
                    <i class="input-icon">
                        <ion-icon name="search-outline" role="img" class="md hydrated"
                            aria-label="search outline"></ion-icon>
                    </i>
                    <a href="#" class="ml-1 mt-1 d-inline-block close searchbox-close">
                        <i class="ti-close font-xs"></i>
                    </a>

                </div>
            </form>
        </div>

    </div>




    @include('inc.footer')
    {{-- video.js library --}}
    <script src="https://vjs.zencdn.net/8.6.0/video.min.js"></script>



{{-- search suggetion in the chats --}}
    <script>
        $(document).ready(function() {
            var searchBox = $('.search-box');
            var resultDropdown = $(".result");
            $('.search-box input[type="text"]').on("keyup input", function() {
                /* Get input value on change */
                var inputVal = $(this).val();
                // var resultDropdown = $(this).siblings(".result");
                var resultDropdown = $(".result");
                if (inputVal.length) {
                    $.get("/search_school_questions", {
                        term: inputVal
                    }).done(function(data) {
                        // Display the returned data in browser
                        resultDropdown.html(data);
                    });
                } else {
                    resultDropdown.empty();
                }
            });
            // Handle click events on the document
            $(document).on("click", function(event) {
                // Close the search results dropdown if the clicked element is not within the search box
                if (!searchBox.is(event.target) && searchBox.has(event.target).length === 0) {
                resultDropdown.empty();
                }
            });


            // Set search input value on click of result item
            $(document).on("click", ".result p", function() {
                // $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
                $(".search-box").find('input[type="text"]').val($(this).text());
                $(".result").empty();

            });
        });
    </script>

<script>

    // Scroll to the bottom of the messages content
    function scrollToBottom() {
        var messagesContent = document.getElementById('messagesContent');
        messagesContent.scrollTop = messagesContent.scrollHeight;
    }

    // Call the scrollToBottom function when the page finishes loading
    window.addEventListener('load', function() {
        scrollToBottom();
    });
</script>

@php
        $subject_id = $data['subject_id'];
        $chapters = $data['chapters'];
        $chapter_videos = $data['videos'];
        $assesments  = $data['assesments'];
@endphp
<script>
    var timestamp = {{ $video_timestamp}};
    $(document).ready(function () {
        var video_player = videojs('video');
        video_player.currentTime(timestamp);
    });
</script>
    <script>
        const main_video = document.querySelector('#video');
        const main_video_title = document.querySelector('.title');
        const video_playlist = document.querySelector('.video-playlist .videos');

        let subject_id = {{$subject_id}};
        let chapters = @json($chapters);
        let chapter_videos = @json($chapter_videos);
        let assesments = @json($assesments);
        let active_video_id = {{ $video_details->id }};

        // console.log(active_video_id);
        let count = 0;

        chapters.forEach((chapter, j) => {
        let video_names_html = '<ul class="list-unstyled">';
            for (let i = 0; i < chapter_videos.length; i++) {
            let flag = 0;
            let lab_flag =0;
            if(chapter_videos[i].chapter_id == chapter.id){
                assesments.forEach(assesment => {
                    if(assesment.chapter_id == chapter.id && assesment.video_id == chapter_videos[i].id){
                        flag = 1;
                    }
                });



                video_names_html +=
                    `<li class="video " data-id="${chapter_videos[i].id}">
                        <div class="d-flex flex-column">
                            <div>
                                <img src="/assets/images/play.svg" alt="">
                                <div style="margin-left: 2rem;"><span class="bg-current btn-round-xs rounded-lg font-xssss text-white fw-600">${i+1}</span><span class="font-xssss fw-500 text-dark-500 ml-2">${chapter_videos[i].video_name}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between" style="width: 100%;margin-left: 2rem;">
                                ${flag == 1 ? `
                                <div style="border: 1px solid #b8afaf;padding: 0 8px;"><a class="font-xssss" href="/take_assesment_school/${subject_id}/${chapter.id}/${chapter_videos[i].id}">Assesments</a></div>` : ''}
                                <div style="border: 1px solid #b8afaf;padding: 0 8px;"><a class="font-xssss" href="/ebook/${chapter_videos[i].id}" >EBook</a></div>

                            </div>
                        </div>
                    </li>`;
            }
        }
        video_names_html += '</ul>';

        let video_element = `
                                <div id="accordion" class="accordion mb-0">

                                    <div class="card shadow-xss mb-0">
                                        <div class="card-header bg-greylight theme-dark-bg" id="heading${count}">
                                            <h5 class="mb-0"><button class="btn font-xsss fw-600 btn-link " data-toggle="collapse" data-target="#collapse${count}" aria-expanded="false" aria-controls="collapse${count}">${count+1+'.'}${chapter.chapter_name}</button></h5>
                                        </div>

                                        <div id="collapse${count}" class="collapse" aria-labelledby="heading${count}" data-parent="#accordion">
                                            <div class="card-body p-2">

                                                ${video_names_html}
                                            </div>

                                        </div>
                                    </div>
                                </div>`;



            video_playlist.innerHTML += video_element;
            count++;
        });
        let videos = document.querySelectorAll('.video');

        var match_video = {!! json_encode($video_details) !!};

        videos.forEach(selected_video => {
            if(selected_video.dataset.id == active_video_id){
                selected_video.classList.add('active');
                selected_video.querySelector('img').src = '/assets/images/pause.svg';
            }
            selected_video.onclick = () => {

                for (all_videos of videos) {
                    all_videos.classList.remove('active');
                    all_videos.querySelector('img').src = '/assets/images/play.svg';

                }
                selected_video.classList.add('active');
                selected_video.querySelector('img').src = '/assets/images/pause.svg';

                match_video = chapter_videos.find(video => video.id == selected_video.dataset.id);
                main_video.src = '/' + match_video.video_file;
                main_video_title.innerHTML = match_video.video_name;
            }



        });
        // Store the timestamp on leaving the page
        var activeVideo = null;
        var ended = false;
        var video_player = videojs(main_video);

        // console.log(video_player);
        video_player.on('playing', function() {
            activeVideo = video_player;
        });

        window.addEventListener('beforeunload', function() {
            if (activeVideo) {
                var currentTime = activeVideo.currentTime();
                var videoId = match_video.id;

                var csrfToken = '{{ csrf_token() }}';

                $.ajax({
                    url: '/save_video_timestamp_school',
                    type: 'POST',
                    data: {
                        subjectId: {{$subject_id}},
                        videoId: videoId,
                        timestamp: currentTime,
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(responseData) {
                        // Handle the response as needed
                        console.log(responseData);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        });


        // Update the video status when it ends
        video_player.on('ended', function () {
            // console.log("Video ended");
            ended = true;
            updateVideoStatus();
        });

        function updateVideoStatus() {
            // console.log(123);
            if (activeVideo) {
                var videoId = match_video.id;
                var currentTime = video_player.currentTime();
                var csrfToken = '{{ csrf_token() }}';

                console.log(videoId);
                $.ajax({
                    url: '/update_video_status_school',
                    type: 'POST',
                    data: {
                        videoId: videoId,
                        status: ended,
                        timestamp: currentTime,
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (responseData) {
                        console.log('Video status updated:', responseData);
                    },
                    error: function (error) {
                        console.error('Error updating video status:', error);
                    }
                });
            }
        }

    </script>


</body>

</html>
<script src="/assets/js/video-player.js"></script>
