<?php $modulePermission=Session::get('modulePermission');?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="{{URL::asset('public/cms/images/favicon.png')}}">
    <title>{{ ucfirst($thisPageId)}}</title>
    <!--Core CSS -->
    

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

    <link href="{{URL::asset('public/cms/css/bootstrap-reset.css')}}" rel="stylesheet">
    <link href="{{URL::asset('public/cms/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
    <!-- Date Picker-->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/cms/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/cms/js/bootstrap-datepicker/css/datepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/cms/js/bootstrap-timepicker/compiled/timepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/cms/js/jquery-tags-input/jquery.tagsinput.css')}}" />
    <!-- file Uploads -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/cms/js/bootstrap-fileupload/bootstrap-fileupload.css')}}" />
     <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{URL::asset('public/cms/js/morris-chart/morris.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/cms/js/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" />
    
    <!-- Custom styles for this template -->
    <link href="{{URL::asset('public/cms/css/style.css')}}" rel="stylesheet">
    <link href="{{URL::asset('public/cms/css/style-responsive.css')}}" rel="stylesheet" />



    <!-- bluimp-juery-imag-uploader-css -->
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{URL::asset('public/cms/blueimp-jQuery-Uploader/css/jquery.fileupload.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/cms/blueimp-jQuery-Uploader/css/jquery.fileupload-ui.css')}}">

    <!--DataTables -->
    <link href="{{URL::asset('public/cms/js/advanced-datatables/media/css/demo_page.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('public/cms/js/advanced-datatables/media/css/demo_table.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{URL::asset('public/cms/js/data-tables/DT_bootstrap.css')}}"/>
    <!--DataTables -->

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="{{URL::asset('public/cms/js/ie8-responsive-file-warning.js')}}"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js" ></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/cms/css/tooltip.css')}}" />

    <script type="text/javascript" src="{{URL::asset('public/cms/js/moment/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('public/cms/js/eonasdan-bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
    

    <script type="text/javascript" src="{{URL::asset('public/highslide/highslide.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/highslide/highslide.css')}}" />
    <script type="text/javascript">
       
       
    </script>
    <script src="{{URL::asset('public/cms/js/ckeditor/ckeditor.js')}}"></script>
    <!--Morris Chart-->
   <script src="{{URL::asset('public/cms/js/morris-chart/morris.js')}}"></script>
    <script src="{{URL::asset('public/cms/js/morris-chart/raphael-min.js')}}"></script>
    <script src="{{URL::asset('public/cms/js/morris.init.js')}}"></script>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">

    <a href="{{ABS_URL}}home" class="logo">
        <img src="{{URL::asset('public/cms/images/logo.png')}}" alt="">
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <?php 
                if(!empty(Auth::user()->profile_pic)&&File::exists('userUploads/admin/'.Auth::user()->profile_pic)){?>
                {!!Html::image('userUploads/admin/'.Auth::user()->profile_pic, 'alt') !!}
                <?php }else{ ?>
                <img alt="" src="{{URL::asset('public/cms/images/avatar.jpg')}}">
                <?php } ?>
                <?php
                if(Auth::user()->middle_name == '')
                    $username = Auth::user()->first_name.' '.Auth::user()->last_name;
                else
                    $username = Auth::user()->first_name.' '.Auth::user()->middle_name.' '.Auth::user()->last_name;
                ?>
                <span class="username"><?=$username; ?></span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <!--<li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>-->
                <li><a href="{{ URL::to(PREFIX.'/settings') }}"><i class="fa fa-cog"></i> Settings</a></li>
                <li><a href="{{ URL::to(PREFIX.'/logout') }}"><i class="fa fa-key"></i> Log Out</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
        <li>
            <div class="toggle-right-box">
                <div class="fa fa-bars"></div>
            </div>
        </li>
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <?php
    if($thisModuleId == 'numberSearch'){
        $hide = "hide-left-bar";
        $class = 'class="merge-left"';
    }else{
        $hide = "";
        $class = '';
    }
    ?>
    <div id="sidebar" class="nav-collapse <?=$hide ?>">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">

                @foreach($modulePermission as $permission)
                @if($permission['pages']==1)
                    {{--*/$moduleLink = ABS_URL.$permission['id'];/*--}} 
                @else
                    {{--*/$moduleLink = 'javascript:;';/*--}}
                @endif

                <li class="@if($permission['pages']>1){{ 'sub-menu' }}@endif" >
                    <a href="{{ $moduleLink }}" class="@if($permission['id']==$thisModuleId){{ 'active' }} @endif" >
                        <i class="fa {{ $permission['icon'] }}"></i>
                        <span>{{ $permission['title'] }}</span>
                    </a>
                    
                    @if($permission['pages']>1)
                    <ul class="sub">
                        @foreach($permission['subPages'] as $pageid=>$pagetitle)
                            <?php $moduleLink = ABS_URL.$permission['id']."/pages/$pageid";
                            ?>
                            <li class="@if($pageid == $thisModuleId){{ 'active' }} @endif"><a href="<?php echo $moduleLink;?>" >{{ $pagetitle }}</a></li>
                        @endforeach
                    </ul>
                    @endif

                </li>

                @endforeach

            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content" <?=$class; ?>>
<section class="wrapper">
<!-- Main content -->

    @yield('content')

<!-- /.content -->
</section>
</section>
<!--main content end-->

<!--right sidebar start-->
<div class="right-sidebar">
<div class="search-row">
    <input type="text" placeholder="Search" class="form-control">
</div>
<div class="right-stat-bar">
<ul class="right-side-accordion">
<li class="widget-collapsible">
    <a href="#" class="head widget-head red-bg active clearfix">
        <span class="pull-left">work progress (5)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row side-mini-stat clearfix">
                <div class="side-graph-info">
                    <h4>Target sell</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="target-sell">
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info">
                    <h4>product delivery</h4>
                    <p>
                        55%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="p-delivery">
                        <div class="sparkline" data-type="bar" data-resize="true" data-height="30" data-width="90%" data-bar-color="#39b7ab" data-bar-width="5" data-data="[200,135,667,333,526,996,564,123,890,564,455]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info payment-info">
                    <h4>payment collection</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="p-collection">
                        <span class="pc-epie-chart" data-percent="45">
                        <span class="percent"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info">
                    <h4>delivery pending</h4>
                    <p>
                        44%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="d-pending">
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="col-md-12">
                    <h4>total progress</h4>
                    <p>
                        50%, Deadline 12 june 13
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div style="width: 50%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" class="progress-bar progress-bar-info">
                            <span class="sr-only">50% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head terques-bg active clearfix">
        <span class="pull-left">contact online (5)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1_small.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Jonathan Smith</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class="user-status text-danger">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Anjelina Joe</a></h4>
                    <p>
                        Available
                    </p>
                </div>
                <div class="user-status text-success">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/chat-avatar2.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">John Doe</a></h4>
                    <p>
                        Away from Desk
                    </p>
                </div>
                <div class="user-status text-warning">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1_small.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Mark Henry</a></h4>
                    <p>
                        working
                    </p>
                </div>
                <div class="user-status text-info">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Shila Jones</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class="user-status text-danger">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <p class="text-center">
                <a href="#" class="view-btn">View all Contacts</a>
            </p>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head purple-bg active">
        <span class="pull-left"> recent activity (3)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        just now
                    </p>
                    <p>
                        <a href="#">Jim Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        2 min ago
                    </p>
                    <p>
                        <a href="#">Jane Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        1 day ago
                    </p>
                    <p>
                        <a href="#">Jim Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head yellow-bg active">
        <span class="pull-left"> shipment status</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="col-md-12">
                <div class="prog-row">
                    <p>
                        Full sleeve baby wear (SL: 17665)
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete</span>
                        </div>
                    </div>
                </div>
                <div class="prog-row">
                    <p>
                        Full sleeve baby wear (SL: 17665)
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                            <span class="sr-only">70% Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
</ul>
</div>
</div>
<!--right sidebar end-->

<div class="modal fade" id="modalinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
<div class="modal-dialog" >
<div class="modal-body">
</div>
</div> 
</div>
</section>


</section>
<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script src="{{URL::asset('public/cms/js/jquery-ui/jquery-ui-1.10.1.custom.min.js')}}"></script>
<script src="{{URL::asset('public/cms/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{URL::asset('public/cms/js/jquery.scrollTo.min.js')}}"></script>
<script src="{{URL::asset('public/cms/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js')}}"></script>
<script src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}"></script>
<?php /*
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{URL::asset('public/cms/js/skycons/skycons.js')}}"></script>
<script src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}js/jquery.scrollTo/jquery.scrollTo.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}js/calendar/clndr.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
<script src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}js/calendar/moment-2.2.1.js"></script>
<script src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}js/evnt.calendar.init.js"></script>
<script src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}js/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}js/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>
<script src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}js/gauge/gauge.js"></script>
<!--clock init-->
<script src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}js/css3clock/js/css3clock.js"></script>
<!--Easy Pie Chart-->
<script src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="{{URL::asset('public/cms/js/jquery.nicescroll.js')}}js/sparkline/jquery.sparkline.js"></script>
*/ ?>

<!-- Date Picker -->
<!-- <script type="text/javascript" src="{{URL::asset('public/cms/js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script> -->
<!-- <script src="{{URL::asset('public/cms/js/advanced-form.js')}}"></script> -->
<!-- File Uploads -->
{!! Html::script('public/cms/js/bootstrap-fileupload/bootstrap-fileupload.js')!!}
<!--dynamic table-->
<!-- <script type="text/javascript" language="javascript" src="{{URL::asset('public/cms/js/advanced-datatable/js/jquery.dataTables.js')}}"></script> -->
<!-- <script type="text/javascript" src="{{URL::asset('public/cms/js/data-tables/DT_bootstrap.js')}}"></script>
 -->

<?php /*
<!--jQuery Flot Chart-->
<script src="{{URL::asset('public/cms/js/flot-chart/jquery.flot.js')}}"></script>
<script src="{{URL::asset('public/cms/js/flot-chart/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{URL::asset('public/cms/js/flot-chart/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('public/cms/js/flot-chart/jquery.flot.pie.resize.js')}}"></script>
<script src="{{URL::asset('public/cms/js/flot-chart/jquery.flot.animator.min.js')}}"></script>
<script src="{{URL::asset('public/cms/js/flot-chart/jquery.flot.growraf.js')}}"></script>
<script src="{{URL::asset('public/cms/js/dashboard.js')}}"></script>
<script src="{{URL::asset('public/cms/js/jquery.customSelect.min.js')}}" ></script>
*/ ?>
<!--common script init for all pages-->
<script src="{{URL::asset('public/cms/js/scripts.js')}}"></script>
<!--script for this page-->

<!--Slugify slug creator-->
<script src="{{URL::asset('public/cms/js/patrickmcelhaney-slugify/jquery.slugify.js')}}"
        type="text/javascript"></script>

<!-- bluimp-jQuery-File-Upload-js -->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="{{URL::asset('public/cms/blueimp-jQuery-Uploader/js/vendor/jquery.ui.widget.js')}}"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="{{URL::asset('public/cms/blueimp-jQuery-Uploader/js/jquery.iframe-transport.js')}}"></script>
<!-- The basic File Upload plugin -->
<script src="{{URL::asset('public/cms/blueimp-jQuery-Uploader/js/jquery.fileupload.js')}}"></script>
<!-- The File Upload processing plugin -->
<script src="{{URL::asset('public/cms/blueimp-jQuery-Uploader/js/jquery.fileupload-process.js')}}"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="{{URL::asset('public/cms/blueimp-jQuery-Uploader/js/jquery.fileupload-image.js')}}"></script>
<!-- The File Upload validation plugin -->
<script src="{{URL::asset('public/cms/blueimp-jQuery-Uploader/js/jquery.fileupload-validate.js')}}"></script>
<!-- The File Upload user interface plugin -->
<script src="{{URL::asset('public/cms/blueimp-jQuery-Uploader/js/jquery.fileupload-ui.js')}}"></script>
<!-- The main application script -->
<script src="{{URL::asset('public/cms/blueimp-jQuery-Uploader/js/main.js')}}"></script>

<!-- Datatables -->
<script type="text/javascript" language="javascript" src="{{URL::asset('public/cms/js/data-tables/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/cms/js/data-tables/DT_bootstrap.js')}}"></script>
<!-- Datatables -->

<!--dynamic table initialization -->
<script src="{{URL::asset('public/cms/js/dynamic_table_init.js')}}"></script>

<script type="text/javascript">
///form functions
function loadEdit(editurl,id)
{
    $.ajax({
         url: editurl+"?id="+id,
            type: 'get',
            success: function(result)
            {
                
                $('#editModal').html(result);
                $('#editModal').modal('show');
             
            },
            error: function()
            {
               $('#modalinfo div').html(' <div class="modal-content"><div class="modal-header"><h2>Could not complete the request.</h2></div></div>');
                $('#modalinfo').modal('show'); 
            }
    })
}

function loadAddNew(addurl)
{
    $.ajax({
         url: addurl,
            type: 'get',
            success: function(result)
            {
                
                $('#editModal').html(result);
                $('#editModal').modal('show');
             
            },
            error: function()
            {
               $('#modalinfo div').html(' <div class="modal-content"><div class="modal-header"><h2>Could not complete the request.</h2></div></div>');
                $('#modalinfo').modal('show'); 
            }
    })
}

function toggleStatus(togurl,id)
      { 
        $('.myCheckbox').prop('checked', true);
        $.ajax
            ({ 
                url: togurl+"?id="+id,
                type: 'get',
                success: function(result)
                {
                    
                    if (result == 'Active') {
                        $('#status_btn'+id).removeClass('btn btn-danger btn-xs').addClass('btn btn-primary btn-xs');
                        $('#status_btn'+id).html('<i class="fa fa-refresh"></i>&nbsp;'+result);
                    }else{
                        $('#status_btn'+id).removeClass('btn btn-primary btn-xs').addClass('btn btn-danger btn-xs');
                        $('#status_btn'+id).html('<i class="fa fa-refresh"></i>&nbsp;'+result);
                    };
                    //$('#status_txt'+id).attr('class', 'status_'+result);
                 
                },
                error: function()
                {
                   $('#modalinfo div').html(' <div class="modal-content"><div class="modal-header"><h2>Could not complete the request.</h2></div></div>');
                    $('#modalinfo').modal('show'); 
                }
            });
      }

///////end of form functions

$(document).ready(function () {
    // $('#dynamic-table').dataTable( {
        
    // } );

    $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });

    $('#multiUp').change(function(){
        if (this.files.length>10) {

           $('#modalinfo div').html(' <div class="modal-content"><div class="modal-header"><h2 style="color:red;">The number of files that can be uploaded exceeds limit of 10 !</h2></div></div>');
           $('#modalinfo').modal('show');
            return false;
        };
        $('#multiUpCounter').html(this.files.length+' files attached');
    });

    /* Begin Slugify slug creator scripts */
       // $('#slug_input').slugify('#title');

        $('.datepicker').datetimepicker({
        format: 'YYYY-MM-DD'
        });

});//close document get ready

</script>
</body>
</html>