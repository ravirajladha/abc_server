<?php session()->put('curnav','quiz'); ?>
@include("inc_recruiter.header")


<body class="color-theme-orange mont-font">

    <div class="preloader"></div>


    <div class="main-wrapper">

        <!-- navigation -->
        @include("inc_recruiter.navbar")

        <!-- navigation -->
        <!-- main content -->
        <div class="main-content menu-active">
            @include("inc_recruiter.topbar")

            {{-- <div class="middle-sidebar-bottom bg-lightblue theme-dark-bg"> --}}
            <div class="middle-sidebar-bottom ">

                <div class="middle-sidebar-left">
                    {{-- <div class="middle-wrap mb-3"> --}}
                    {{-- <div class="mb-3">
                        <div class="card w-100 border-0 bg-white shadow-xs p-0 mb-4">
                            <div class="card-body p-4 w-100 bg-current border-0 d-flex rounded-lg">
                                <a href="default_settings" class="d-inline-block mt-2"><i class="ti-arrow-left font-sm text-white"></i></a>
                                <h4 class="font-xs text-white fw-600 ml-4 mb-0 mt-2">All quizes</h4>
                            </div>

                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-lg-12 pt-0 mb-3 d-flex justify-content-between">
                            <div>
                                <h2 class="fw-400 font-lg d-block">All <b> Quizzes</b> </h2>
                            </div>
                            <div class="float-right">
                                <a href="/recruiter/add_question" class="p-2  d-inline-block text-white fw-700 lh-30 rounded-lg  text-center font-xsssss ls-3 bg-current">ADD QUESTIONS</a>
                                <a href="/recruiter/create_quiz" class="p-2  d-inline-block text-white fw-700 lh-30 rounded-lg  text-center font-xsssss ls-3 bg-current">CREATE QUIZ</a>
                            </div>
                        </div>
                        @foreach ($data['all_quiz'] as $quiz)
                        <div class="col-lg-3 col-md-6 col-12 col-sm-6">
                            <div class="item">
                                <div class="card p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1 mb-4">
                                    <div class="card-image w-100 mb-3">
                                        <a href="" class="position-relative d-block"><img src="/{{$quiz->image}}" alt="image" class="w-100" style="height: 200px"></a>
                                    </div>
                                    <div class="card-body pt-0">
                                        <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-danger d-inline-block text-danger mr-1">Desinger</span>

                                        <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="default_course_details" class="text-dark text-grey-900">{{$quiz->title}}</a></h4>

                                        <div class="text-center">
                                            <a href="/recruiter/quiz_details/{{$quiz->id}}" class="p-2 mt-4 d-inline-block text-white fw-700 lh-30 rounded-lg w100 text-center font-xsssss ls-3 bg-current">DETAILS</a>
                                            <a href="/recruiter/all_results/{{$quiz->id}}" class="p-2 mt-4 d-inline-block text-white fw-700 lh-30 rounded-lg w100 text-center font-xsssss ls-3 bg-current">RESULTS</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include("inc_recruiter.footer")

</body>

</html>
