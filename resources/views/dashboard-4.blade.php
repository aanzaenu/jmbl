@extends('layouts.vertical', ['title' => 'Dashboard 4'])

@section('css')

@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
    
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
        

        <div class="row">
            <div class="col-xl-6 col-md-6">
                <!-- Portlet card -->
                <div class="card">
                    <div class="card-body" dir="ltr">
                        <div class="card-widgets">
                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                            <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h4 class="header-title mb-0">Konten</h4>

                        <div id="cardCollpase1" class="collapse pt-3 show">
                            <div class="text-center">

                                <div id="lifetime-sales" data-colors="#4fc6e1,#6658dd,#ebeff2,#FFBA00" style="height: 270px;" class="morris-chart mt-3"></div>                
                            
                            </div>
                        </div> <!-- end collapse-->
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-xl-6 col-md-6">
                <div class="card">
                    <div class="card-body" dir="ltr">
                        <div class="card-widgets">
                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                            <a data-toggle="collapse" href="#cardCollpase3" role="button" aria-expanded="false" aria-controls="cardCollpase3"><i class="mdi mdi-minus"></i></a>
                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h4 class="header-title mb-0">Statistics</h4>

                        <div id="cardCollpase3" class="collapse pt-3 show">
                            <div class="text-center">
                                <div id="statistics-chart" data-colors="#02c0ce" style="height: 270px;" class="morris-chart mt-3"></div>

                            </div>
                        </div> <!-- end collapse-->
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->
        
    </div> <!-- container -->
@endsection

@section('script')
    <!-- Plugins js-->
    <script src="{{asset('assets/libs/morris.js06/morris.js06.min.js')}}"></script>
    <script src="{{asset('assets/libs/raphael/raphael.min.js')}}"></script>

    <!-- Page js-->
    <script>
        !function($) {
            "use strict";
        
            var Dashboard4 = function() {};
        
            //creates Bar chart
            Dashboard4.prototype.createBarChart  = function(element, data, xkey, ykeys, labels, lineColors) {
                Morris.Bar({
                    element: element,
                    data: data,
                    xkey: xkey,
                    ykeys: ykeys,
                    labels: labels,
                    dataLabels: false,
                    hideHover: 'auto',
                    resize: true, //defaulted to true
                    gridLineColor: 'rgba(65, 80, 95, 0.07)',
                    barSizeRatio: 0.2,
                    barColors: lineColors
                });
            },
                
            //creates Donut chart
            Dashboard4.prototype.createDonutChart = function(element, data, colors) {
                Morris.Donut({
                    element: element,
                    data: data,
                    barSize: 0.2,
                    resize: true, //defaulted to true
                    colors: colors,
                    backgroundColor: 'transparent'
                });
            },
            Dashboard4.prototype.init = function() {
        
                //creating bar chart
                var $barData  = [
                    @foreach($days as $key=>$val)
                        { y: "{{ $val }}", a: <?php echo rand($key, 20) ;?>},
                    @endforeach
                ];
                var colors = ['#02c0ce'];
                var dataColors = $("#statistics-chart").data('colors');
                if (dataColors) {
                    colors = dataColors.split(",");
                }
                this.createBarChart('statistics-chart', $barData, 'y', ['a'], ["Statistics"], colors);
        
        
                //creating donut chart
                var $donutData = [
                    {label: " Artikel Draft", value: {{ $pos_draft }}},
                    {label: " Artikel Terbit ", value: {{ $pos_publish }}},
                    {label: " Info Grafik Draft ", value: {{ $ig_draft }}},
                    {label: " Info Grafik Terbit ", value: {{ $ig_publish }}},
                ];
                var colors = ['#4fc6e1','#6658dd', '#ebeff2'];
                var dataColors = $("#lifetime-sales").data('colors');
                if (dataColors) {
                    colors = dataColors.split(",");
                }
                this.createDonutChart('lifetime-sales', $donutData, colors);
            },
            //init
            $.Dashboard4 = new Dashboard4, $.Dashboard4.Constructor = Dashboard4
        }(window.jQuery),
        
        //initializing 
        function($) {
            "use strict";
            $.Dashboard4.init();
        }(window.jQuery);        
    </script>
@endsection
