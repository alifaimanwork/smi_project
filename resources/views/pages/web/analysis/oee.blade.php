@extends('layouts.app')
@include('components.web.top-nav-bar')
@include('components.web.side-nav-bar',['menuActive' => 'analysis'])
@include('pages.web.analysis.components.drop-menu-navigation',['dropMenuSelected' => 'OEE'])

@section('head')
@parent
<style>
    @media only screen and (max-width: 768px) {
        .chart-title {
            font-size: 65% !important;
        }
    }

    .table {
        background-color: #FFFFFF;
    }

    .chart-label-middle.mini-chart {
        top: calc(50%);
        font-size: 1.2rem;
    }

    @media only screen and (max-width: 1400px) {
        .chart-label-middle.mini-chart {
            font-size: 1rem;
        }
    }

    .chart-label-middle {
        position: absolute;
        top: calc(50% - 20px);
        left: 0;
        right: 0;
        text-align: center;
        font-size: 1.6rem;
        font-weight: bold;
        color: #000080;
    }

    .chart-label-middle span:nth-child(2) {
        font-size: 0.8rem;
        font-weight: 600;
    }



    .bar-active {
        transition-duration: 500ms;
    }

    .bar-availability {
        background-color: #f98a8a;
    }

    .bar-availability .bar-active {
        background-color: #f31414;
    }

    .bar-performance {
        background-color: #f98a8a;
    }

    .bar-performance .bar-active {
        background-color: #f31414;
        ;
    }

    .bar-quality {
        background-color: #f98a8a;
    }

    .bar-quality .bar-active {
        background-color: #f31414;
    }

    .box-header {
        display: flex;
        padding: 0.3rem;
        font-weight: bold;
        font-size: 1.2rem;
        color: #000080;
    }

    .table {
        background-color: #FFFFFF;
    }

    .table thead {
        background-color: #CB84A3;
        color: #FFFFFF;
    }

    .table thead th {
        font-weight: 500;
    }

    .table tbody {
        font-weight: 500;
        color: #575353;
    }
</style>
@endsection

@section('body')
<main>
    @yield('drop-menu-navigation')
    <div class="container mb-3">
        @yield('mobile-title')
        <div class="my-2 d-flex flex-column flex-md-row justify-content-between align-items-md-center align-items-start">
            <div class="mt-3">
                @include('components.web.change-plant-selector')
            </div>
            @if(isset($workCenter,$workCenters))
            <div class="ms-md-3 mt-3">
                @include('pages.web.analysis.components.change-workcenter-selector')
            </div>
            @endif
            <div class="ms-md-3 mt-3">
                <div class="d-flex gap-3 align-items-center">
                    <div class="text-nowrap me-2 primary-text">DATE RANGE</div>
                    <div>
                        <input type="text" class="form-control text-center" id="production-date" style="color: #000080; background-color: #dddddd;">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 p-1 h-100 mt-3">
                <div class="card">
                    <div class="box-header justify-content-center">
                        DAY & NIGHT SHIFT (%)
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-center align-items-center">
                            <div style="height: 52% ; width: 52%" class="position-relative">
                                <canvas id="average_oee"></canvas>
                                <div class="chart-label-middle d-flex flex-column">
                                    <span class="renderer-percentage analysis-oee-data" data-tag="average_oee">--</span>
                                    <span>AVERAGE OEE</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column mt-3">
                            <div class="d-flex justify-content-between">
                                <span class="secondary-text text-center">AVAILABILITY</span>
                                <span class="primary-text renderer-bar-text analysis-oee-data" data-tag="average_availability">--- / ---</span>
                            </div>
                            <div style="position: relative;height: 10px;padding: 0 !important;">
                                <div class="status-bar-container bar-availability renderer-bar-progress analysis-oee-data" data-tag="average_availability">
                                    <div class="bar-active" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column mt-3">
                            <div class="d-flex justify-content-between">
                                <span class="secondary-text text-center">PERFORMANCE</span>
                                <span class="primary-text renderer-bar-text analysis-oee-data" data-tag="average_performance">--- / ---</span>
                            </div>
                            <div style="position: relative;height: 10px;padding: 0 !important;">
                                <div class="status-bar-container bar-performance renderer-bar-progress analysis-oee-data" data-tag="average_performance">
                                    <div class="bar-active" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column mt-3">
                            <div class="d-flex justify-content-between">
                                <span class="secondary-text text-center">QUALITY</span>
                                <span class="primary-text renderer-bar-text analysis-oee-data" data-tag="average_quality">--- / ---</span>
                            </div>
                            <div style="position: relative;height: 10px;padding: 0 !important;">
                                <div class="status-bar-container bar-quality renderer-bar-progress analysis-oee-data" data-tag="average_quality">
                                    <div class="bar-active" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 p-1 flex-fill mt-3">
                <div class="d-flex justify-content-between gap-3 flex-column h-100">
                    <div class="card flex-fill">
                        <div class="box-header ms-3">
                            DAY SHIFT (%)
                        </div>
                        <div class="card-body py-0 d-flex align-items-center">
                            <div class="container p-0">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="position-relative">
                                            <canvas id="day_average_oee"></canvas>
                                            <span class="chart-label-middle mini-chart renderer-percentage analysis-oee-data" data-tag="average_oee" data-shift-type-id="1">--</span>
                                        </div>
                                        <div class="text-center secondary-text chart-title">OEE</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="position-relative">
                                            <canvas id="day_average_availability"></canvas>
                                            <span class="chart-label-middle mini-chart renderer-percentage analysis-oee-data" data-tag="average_availability" data-shift-type-id="1">--</span>
                                        </div>
                                        <div class="text-center secondary-text chart-title">AVAILABILITY</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="position-relative">
                                            <canvas id="day_average_performance" class="position-relative"></canvas>
                                            <span class="chart-label-middle mini-chart renderer-percentage analysis-oee-data" data-tag="average_performance" data-shift-type-id="1">--</span>
                                        </div>
                                        <div class="text-center secondary-text chart-title">PERFORMANCE</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="position-relative">
                                            <canvas id="day_average_quality"></canvas>
                                            <span class="chart-label-middle mini-chart renderer-percentage analysis-oee-data" data-tag="average_quality" data-shift-type-id="1">--</span>
                                        </div>
                                        <div class="text-center secondary-text chart-title">QUALITY</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card flex-fill">
                        <div class="box-header ms-3">
                            NIGHT SHIFT (%)
                        </div>
                        <div class="card-body py-0 d-flex align-items-center">
                            <div class="container p-0">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="position-relative">
                                            <canvas id="night_average_oee"></canvas>
                                            <span class="chart-label-middle mini-chart renderer-percentage analysis-oee-data" data-tag="average_oee" data-shift-type-id="2">--</span>
                                        </div>
                                        <div class="text-center secondary-text chart-title">OEE</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="position-relative">
                                            <canvas id="night_average_availability"></canvas>
                                            <span class="chart-label-middle mini-chart renderer-percentage analysis-oee-data" data-tag="average_availability" data-shift-type-id="2">--</span>
                                        </div>
                                        <div class="text-center secondary-text chart-title">AVAILABILITY</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="position-relative">
                                            <canvas id="night_average_performance"></canvas>
                                            <span class="chart-label-middle mini-chart renderer-percentage analysis-oee-data" data-tag="average_performance" data-shift-type-id="2">--</span>
                                        </div>
                                        <div class="text-center secondary-text chart-title">PERFORMANCE</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="position-relative">
                                            <canvas id="night_average_quality"></canvas>
                                            <span class="chart-label-middle mini-chart renderer-percentage analysis-oee-data" data-tag="average_quality" data-shift-type-id="2">--</span>
                                        </div>
                                        <div class="text-center secondary-text chart-title">QUALITY</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="row mt-3">
            <div class="col-12 col-md-3 p-1">
                <div class="card mobile-card">
                    <div class="card-header">
                        <i class="fa-light fa-file-invoice me-2"></i> DOWNLOAD / PRINT REPORT
                    </div>
                    <div class="card-body secondary-text" style="font-size: 2.5em;">
                        <form id="report-form" target="_blank" action="{{ route('analysis.oee.get.data',[ $plant->uid ]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="date_start">
                            <input type="hidden" name="date_end">
                            <input type="hidden" name="work_center_uid">
                            <input type="hidden" name="format">
                            <button type="submit" class="blank-button px-1" onclick="pageData.download('download')">
                                <i class="fa-light fa-file-spreadsheet"></i>
                            </button>
                            <button type="submit" class="blank-button px-1" onclick="pageData.download('print')">
                                <i class="fa-solid fa-print"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-12 overflow-auto p-1">
                <table id="production-line-datatable" class="table nowrap table-striped text-wrap" style="width:100%; font-size:80%">
                </table>
            </div>
        </div>

    </div>
</main>
@endsection

@section('scripts')
@parent
<script>

        //Date Range picker

</script>
@endsection