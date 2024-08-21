@extends('layout.main')
@section('title', 'User Management')
@section('content')
@section('Home', 'active')
<section id="contact" class="contact">
    <div class="container-fluid mt-3" data-aos="fade-in">
        <style>
            #brandBaseChart,
            #cateBaseChart {
                height: 600px;
            }

            .highcharts-figure,
            .highcharts-data-table table {
                min-width: 100%;
                max-width: 100%;
                margin: 1em auto;
            }

            .highcharts-data-table table {
                font-family: Verdana, sans-serif;
                border-collapse: collapse;
                border: 1px solid #ebebeb;
                margin: 10px auto;
                text-align: center;
                width: 100%;
                max-width: 100%;
            }

            .highcharts-data-table caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #555;
            }

            .highcharts-data-table th {
                font-weight: 600;
                padding: 0.5em;
            }

            .highcharts-data-table td,
            .highcharts-data-table th,
            .highcharts-data-table caption {
                padding: 0.5em;
            }

            .highcharts-data-table thead tr,
            .highcharts-data-table tr:nth-child(even) {
                background: #f8f8f8;
            }

            .highcharts-data-table tr:hover {
                background: #f1f7ff;
            }
        </style>
        <div class="row">
            <div class="col-md-12">
                <figure class="highcharts-figure">
                    <div id="brandBaseChart"></div>

                </figure>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <figure class="highcharts-figure">
                    <div id="cateBaseChart"></div>

                </figure>

            </div>
        </div>
    </div>
    <script src="{{ url('plugins/chart.js/Chart.min.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ url('orgChart/js/highcharts-3d.js') }}"></script>

    <script src="{{ url('orgChart/js/highcharts.js') }}"></script>
    <script src="{{ url('orgChart/js/sankey.js') }}"></script>
    <script src="{{ url('orgChart/js/organization.js') }}"></script>
    <script src="{{ url('orgChart/js/exporting.js') }}"></script>
    <script src="{{ url('orgChart/js/accessibility.js') }}"></script>
    <script>
        var brandBase = @json($brandBase);
        var categories = @json($categories);
        var brands = @json($brands);
        var cateBase = @json($cateBase);
        Highcharts.chart('brandBaseChart', {
            chart: {
                type: 'column',
                scrollablePlotArea: {
                    minWidth: {{ count($brands) * 70 }},
                    // nr of interval data x (40 + 30) where 40 are column width pixels and
                    // 30 is additional distancing between columns;
                    // Increase spacing pixels if needed
                    scrollPositionX: 1
                }
            },
            title: {
                text: 'Analyze Brand Based on Categories on Raw data set of Comestic',
                align: 'left'
            },
            xAxis: {
                categories: brands,
                labels: {
                    useHTML: true,
                    style: {
                        fontSize: "8px",
                        fontWeight: 'bold'

                    },
                    x: -2,
                    y: 15
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Category'
                },
                stackLabels: {
                    enabled: true
                }
            },
            legend: {
                align: 'left',
                x: 70,
                verticalAlign: 'top',
                y: 70,
                floating: true,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: ["viewFullscreen"]
                    }
                }
            },
            series: brandBase
        });
        Highcharts.chart('cateBaseChart', {
            chart: {
                type: 'column',

            },
            title: {
                text: 'Analyze Category Based on Brands on Raw data set of Comestic',
                align: 'left'
            },
            xAxis: {
                categories: categories,
                labels: {
                    useHTML: true,
                    style: {
                        fontSize: "14px",
                        fontWeight: 'bold'

                    },
                    x: -2,
                    y: 15
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Brand'
                },
                stackLabels: {
                    enabled: false
                }
            },

            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    pointWidth: 80,
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: ["viewFullscreen"]
                    }
                }
            },
            series: cateBase
        });
    </script>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
