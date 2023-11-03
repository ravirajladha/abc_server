@include("inc_admin.header")

<style>
	/* Tooltip container */
.tip{
/* position: absolute; */
display: inline-block;
cursor: help; /*change the cursor symbol to a question mark on mouse over*/
color: inherit; /*inherit text color*/
text-decoration: none; /*remove underline*/

}

/*Tooltip text*/
.tip span {
visibility: hidden;
width:80%;
text-align: center;
padding: 1em 0em 1em 0em;
border: 1px solid;
border-radius: 0.5em;
font: 400 12px Arial;
color: #ffffff;
background-color: #E8D300;
display: inline-block;

/*Position the tooltip text*/
position: relative; /*positioned relative to the tooltip container*/
top: 105%;
z-index:100;
}

.tip:hover span {
visibility: visible;
}
	</style>

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

                                <h2 class="fw-400 font-lg d-block">Lab: <b> {{$data['lab']->name}}</b> </h2>
                                <div class="float-right">
                                    <ol class="breadcrumb " style="padding: 0.25rem 1rem;">
                                        <li><i class="fa fa-home"></i>&nbsp;<a class="fw-500 font-xsss text-dark" href="/index">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                        </li>
                                        <li><a class="fw-500 font-xsss text-dark" href="/default_live_stream/{{$data['lab']->course_id}}/0">&nbsp; Course</a>&nbsp;<i class="fa fa-angle-right"></i>
                                        </li>
                                        <li class="active fw-500 text-black">&nbsp; Lab</li>
                                    </ol>
                                </div>
                            </div>
                            {{-- ----- --}}
                            <div class="card-body w-100 border-0 ">
                              
                                    <div class="row">
                                        <div class=" col-sm-12">
                                            <div class="card-box">

                                              
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                                            <div class="row">

                                                               
                                                              
                                                              
                                                                <div class="col-lg-12 mt-3"  >
                                                                    <iframe
                                                                    frameBorder="0"
                                                                    height="450px"  
                                                                    src="https://onecompiler.com/embed/java/{{$data['lab']->code}}" 
                                                                    width="100%"
                                                                    ></iframe>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               

                            </div>
                        </div>


                        <!-- <div class="card w-100 border-0 p-2"></div> -->
                    </div>
                </div>


                <button class="btn btn-circle text-white btn-neutral sidebar-right">
                    <i class="ti-angle-left"></i>
                </button>
            </div>


        </div>

    </div>

    @include("inc_admin.footer")

{{-- <script>
function showCode() {
  document.getElementById("code").style.display = "block";
}
</script> --}}


<script>
function toggleCode() {
  var div = document.getElementById("code");
  if (div.style.display === "none") {
    div.style.display = "block";
  } else {
    div.style.display = "none";
  }
}
</script>

<script>
    $('#course').change(function() {
    var subjectId = $(this).val();
    if (subjectId) {
        // alert(subjectId);
        $.ajax({
            url: '/get_sections',
            type: 'get',
            dataType: 'json',
            data: {
                subject_id: subjectId
            },
            success: function(data) {
            // console.log(data);
                // console.log(data.length);
                // var sections=JSON.parse(data);
                var sections=data;
                // console.log(sections.length);
                var options = '<option readonly disabled selected value="">--Select--</option>';
                for (var i = 0; i < sections.length; i++) {
                    // console.log(data);
                    options += '<option value="' + sections[i].id + '">' + sections[i].section_name + '</option>';
                }
                $('#section-dropdown').html(options);
            }
        });
    } else {
        $('#section-dropdown').html('<option value="">Select Section</option>');
    }
});

</script>
<script>
    $('#section-dropdown').change(function() {
    var sectionId = $(this).val();
    var courseId = $('#course').val();
    if (sectionId) {
        // alert(subjectId);
        $.ajax({
            url: '/get_videos',
            type: 'get',
            dataType: 'json',
            data: {
                sectionId: sectionId,
                courseId: courseId
            },
            success: function(data) {
            console.log(data);

                // console.log(data.length);
                // var videos=data.split(',');
                var videos =data;
                console.log(videos.length);
                var options = '<option readonly disabled selected value="">--Select--</option>';
                for (var i = 0; i < videos.length; i++) {
                    // console.log(data);
                    options += '<option value="' + videos[i].id + '">' + videos[i].video_name + '</option>';
                }
                $('#video-dropdown').html(options);
            }
        });
    } else {
        $('#video-dropdown').html('<option value="">Select Section</option>');
    }
});

</script>

</body>

</html>
