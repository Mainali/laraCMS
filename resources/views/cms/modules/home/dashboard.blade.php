@extends(MODULEFOLDER.'.master')

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon orange"><i class="fa fa-users"></i></span>
            <div class="mini-stat-info">
                <span>{{$totalCount}}</span>
                Total Requests
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><i class="fa fa-map-signs"></i></span>
            <div class="mini-stat-info">
                <span>{{$pendingCount}}</span>
                Pending Requests
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon pink"><i class="fa fa-sticky-note-o"></i></span>
            <div class="mini-stat-info">
                <span>{{$activeCount}}</span>
                Activated Request
            </div>
        </div>
    </div>
    
</div>
<div class="row">
                <div class="col-sm-6">
                    <section class="panel">
                        <header class="panel-heading">
                            Line Chart
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                        </header>
                        <div class="panel-body">
                            <div id="line-chart"></div>
                        </div>
                    </section>
                </div>

                <div class="col-sm-6">
                    <section class="panel">
                        <header class="panel-heading">
                            Request Chart
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                        </header>
                        <div class="panel-body">
                             <div id="donut-chr"></div>
                        </div>
                    </section>
                </div>



            </div>

          

            <script type="text/javascript">

            $(document).ready(function(){

new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'line-chart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  // data: [
  //   { year: '2008', value: 20 },
  //   { year: '2009', value: 10 },
  //   { year: '2010', value: 5 },
  //   { year: '2011', value: 5 },
  //   { year: '2012', value: 20 }
  // ],
  data:{!! $linegraphData !!},
  // The name of the data record attribute that contains x-values.
  xkey: 'date',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['total'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['total']
});

Morris.Donut({
  element: 'donut-chr',
  colors:["#9CC4E4", "#f4aa38", "#00FF00"],
  data: [
    {label: "Total Requests", value: {{$totalCount}}},
    {label: "Pending", value: {{$pendingCount}}},
    {label: "Activated", value: {{$activeCount}}}
  ]
});

  });//doc ready
            </script>

@stop
