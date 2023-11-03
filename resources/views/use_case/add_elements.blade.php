
@include("inc_admin.header")

@php
$use_case_module = $data['use_case_module'];
$use_case = $data['use_case'];
$elements = $data['element'];

@endphp
<body class="color-theme-orange mont-font">

    {{-- <div class="preloader"></div> --}}


    <div class="main-wrapper">

        <!-- navigation -->
        @include("inc_admin.navbar")

        <!-- navigation -->
        <!-- main content -->
        <div class="main-content menu-active">
            @include("inc_admin.topbar")


            <div class="middle-sidebar-bottom bg-lightblue theme-dark-bg">
                <div class="middle-sidebar-left">
                    <div class="">
                        <div class="card w-100 border-0 bg-white shadow-xs p-0 mb-4">
                            <div class="card-body p-4 w-100 border-0 d-flex rounded-lg justify-content-between">
                                <h2 class="fw-400 font-lg d-block">Add <b> Elements</b> </h2>
                                <div class="float-right">
                                    <ol class="breadcrumb " style="padding: 0.25rem 1rem;">
                                        <li><i class="fa fa-home"></i>&nbsp;<a class="fw-500 font-xsss text-dark" href="/admin/index">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                        </li>
                                        <li><a class="fw-500 font-xsss text-dark" href="/admin/use_cases">&nbsp; Use Cases</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                        <li><a class="fw-500 font-xsss text-dark" href="/admin/use_case_modules/{{$use_case->id}}">&nbsp; Modules</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                        <li class="active fw-500 text-black">&nbsp; Add Elements</li>
                                    </ol>
                                </div>
                            </div>

                            <div class="card-body p-lg-5 p-4 w-100 border-0 ">


                            <form action="/admin/add_use_case_elements/{{$use_case_module->id}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <div class="form-group">
                                            <label class="mont-font fw-600 font-xsss">Use Case Title</label>
                                            <input type="text" name="" value="{{$use_case->title}}" class="form-control" placeholder="Enter Course Title" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <div class="form-group">
                                            <label class="mont-font fw-600 font-xsss">Module Title</label>
                                            <input type="text" name="" value="{{$use_case_module->module_title}}" class="form-control" placeholder="Enter Course Title" readonly>
                                        </div>
                                    </div>

                                </div>



<br>
<hr><br>
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <div class="form-group">
                                            <label class="mont-font fw-600 font-xsss">Elements</label>
                                            <select class="form-control" name="element_name" id="element-select">
                                                <option value="" selected disabled readonly>--select--</option>
                                                @foreach ($elements as $element)
                                                <option value="{{$element->id}}">{{$element->element_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div id="additional-field-container" class="row">

                                </div>

                                <div class="col-lg-12">
                                    <button style="float:right" type="submit" class="btn bg-current text-center text-white font-xsss fw-600 p-3 w175 rounded-lg d-inline-block border-0">save</button>

                                </div>
                            </form>
                            </div>
                        </div>
                        <!-- <div class="card w-100 border-0 p-2"></div> -->
                    </div>
                </div>

            </div>
        </div>
        <!-- main content -->
        <div class="app-footer border-0 shadow-lg">
            <a href="default.html" class="nav-content-bttn nav-center"><i class="feather-home"></i></a>
            <a href="default-follower.html" class="nav-content-bttn"><i class="feather-package"></i></a>
            <a href="default-live-stream.html" class="nav-content-bttn" data-tab="chats"><i class="feather-layout"></i></a>
            <a href="#" class="nav-content-bttn sidebar-layer"><i class="feather-layers"></i></a>
            <a href="default-settings.html" class="nav-content-bttn"><img src="https://via.placeholder.com/60x60.png" alt="user" class="w30 shadow-xss"></a>
        </div>

        <div class="app-header-search">
            <form class="search-form">
                <div class="form-group searchbox mb-0 border-0 p-1">
                    <input type="text" class="form-control border-0" placeholder="Search...">
                    <i class="input-icon">
                        <ion-icon name="search-outline" role="img" class="md hydrated" aria-label="search outline"></ion-icon>
                    </i>
                    <a href="#" class="ml-1 mt-1 d-inline-block close searchbox-close">
                        <i class="ti-close font-xs"></i>
                    </a>
                </div>
            </form>
        </div>

    </div>





    @include("inc_admin.footer")

    <script>
        $(document).ready(function() {
            $('#element-select').change(function() {
                var selectedElementId = $(this).val();
                var selectedElementName = $(this).find(':selected').text();

                // Check if a specific option is selected (change the condition as needed)
                if (selectedElementId == 1) {
                    // heading
                    // Create and display the additional input field
                    var additionalField = '<div class="col-lg-4 mb-3">' +
                                             '<div class="form-group">' +
                                                '<label class="mont-font fw-600 font-xsss">Heading</label>' +
                                                '<input type="text" class="form-control" placeholder="Enter Heading" name="content">' +
                                             '</div>'+
                                            '</div>';

                } else if (selectedElementId == 2){
                    // paragraph

                    var additionalField = '<div class="col-lg-12 mb-3">' +
                                             '<div class="form-group">' +
                                                '<label class="mont-font fw-600 font-xsss">Paragraph</label>' +
                                                '<textarea name="content" class="form-control mb-0 p-3 h100 bg-greylight lh-16" rows="5" placeholder="Enter Description..." spellcheck="false" id="abc_editor"></textarea>' +
                                             '</div>'+
                                          '</div>';
                }else if (selectedElementId == 3){
                        // list
                        var additionalField = '<div class="col-lg-4 mb-3">' +
                                                '<div class="form-group">' +
                                                    '<label class="mont-font fw-600 font-xsss">List Type</label>' +
                                                    '<select class="form-control" name="list_type" id="list_type">'+
                                                    '<option value="" selected disabled readonly>--select--</option>'+
                                                    '<option value="Square">Square</option>'+
                                                    '<option value="Bullet">Bullet</option>'+
                                                    '<option value="Check">Check</option>'+
                                                    '<option value="Arrow">Arrow</option>'+
                                                    '<option value="Star">Star</option>'+
                                                    '</select>' +
                                                '</div>'+
                                                '</div>'+
                                                '<div class="col-lg-6 mb-3">' +
                                                '<div class="form-group">' +
                                                    '<button style="float:right" type="button" id="add_input" class="btn btn-default btn-add bg-current text-white font-xsss">+ADD POINTS'
                                                    '</button>'+
                                                '</div>'+
                                                '</div>';
                            $(document).on('click', '#add_input', function() {
                    var htmlCode = '<div class="col-lg-6 mb-3">' +
                                        '<div class="form-group">' +
                                        '<label class="mont-font fw-600 font-xsss">Points</label>' +
                                        '<input type="text" class="form-control" placeholder="Enter Points" name="list_points[]">' +
                                        '</div>' +
                                    '</div>';

                    $(htmlCode).insertAfter('.col-lg-6.mb-3:last');
                    });

                    }else if (selectedElementId == 4){
                        // list
                        var additionalField = '<div class="col-lg-4 mb-3">' +
                                                '<div class="form-group">' +
                                                    '<label class="mont-font fw-600 font-xsss">List Type</label>' +
                                                    '<select class="form-control" name="list_type" id="list_type">'+
                                                    '<option value="" selected disabled readonly>--select--</option>'+
                                                    '<option value="Square">Square</option>'+
                                                    '<option value="Bullet">Bullet</option>'+
                                                    '<option value="Check">Check</option>'+
                                                    '<option value="Arrow">Arrow</option>'+
                                                    '<option value="Star">Star</option>'+
                                                    '</select>' +
                                                '</div>'+
                                                '</div>'+
                                                '<div class="col-lg-6 mb-3">' +
                                                '<div class="form-group">' +
                                                    '<button style="float:right" type="button" id="add_input2" class="btn btn-default btn-add bg-current text-white font-xsss">+ADD POINTS'
                                                    '</button>'+
                                                '</div>'+
                                                '</div>';
                            $(document).on('click', '#add_input2', function() {
                    var htmlCode = '<div class="col-lg-6 mb-3">' +
                                        '<div class="form-group">' +
                                        '<label class="mont-font fw-600 font-xsss">Points</label>' +
                                        '<input type="text" class="form-control" placeholder="Enter Points" name="list_points[]">' +
                                        '</div>' +
                                    '</div>'+
                                    '<div class="col-lg-6 mb-3">' +
                                        '<div class="form-group">' +
                                        '<label class="mont-font fw-600 font-xsss">Description</label>' +
                                        '<input type="text" class="form-control" placeholder="Enter Description" name="list_description[]">' +
                                        '</div>' +
                                    '</div>';

                    $(htmlCode).insertAfter('.col-lg-6.mb-3:last');
                    });

                    }else if (selectedElementId == 5){
                        // list
                        var additionalField = '<div class="col-lg-4 mb-3">'+
                                                '</div>'+
                                                '<div class="col-lg-4 mb-3">'+
                                                '</div>'+
                                                '<div class="col-lg-4 mb-3">' +
                                                '<div class="form-group">' +
                                                    '<button style="float:right" type="button" id="add_input3" class="btn btn-default btn-add bg-current text-white font-xsss">+ADD'
                                                    '</button>'+
                                                '</div>'+
                                                '</div>';
                            $(document).on('click', '#add_input3', function() {
                    var htmlCode = '<div class="col-lg-4 mb-3">' +
                                        '<div class="form-group">' +
                                        '<label class="mont-font fw-600 font-xsss">Heading</label>' +
                                        '<input type="text" class="form-control" placeholder="Enter Points" name="appendices_heading[]">' +
                                        '</div>' +
                                    '</div>'+
                                    '<div class="col-lg-4 mb-3">' +
                                        '<div class="form-group">' +
                                        '<label class="mont-font fw-600 font-xsss">Sub Heading</label>' +
                                        '<input type="text" class="form-control" placeholder="Enter Description" name="appendices_sub_heading[]">' +
                                        '</div>' +
                                    '</div>'+
                                    '<div class="col-lg-4 mb-3">' +
                                        '<div class="form-group">' +
                                        '<label class="mont-font fw-600 font-xsss">Description</label>' +
                                        '<input type="text" class="form-control" placeholder="Enter Description" name="appendices_desc[]">' +
                                        '</div>' +
                                    '</div>';

                    $(htmlCode).insertAfter('.col-lg-4.mb-3:last');
                    });

                    }
                $('#additional-field-container').html(additionalField);
                // initializeCKEditor('abc_editor');
            });



        });
    </script>


</body>

</html>
