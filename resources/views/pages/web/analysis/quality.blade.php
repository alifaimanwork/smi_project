@extends('layouts.app')
@include('components.web.top-nav-bar')
@include('components.web.side-nav-bar',['menuActive' => 'analysis'])
@include('pages.web.analysis.components.drop-menu-navigation',['dropMenuSelected' => 'QUALITY'])

@section('head')
@parent
<style>
    .table {
        background-color: #FFFFFF;
    }

    .table thead {
        background-color: #CB84A3;
        color: #FFFFFF;
    }

    .table tbody {
        font-weight: 500;
        color: #575353;
    }

    .table thead th {
        font-size: 14px;
        font-weight: 500;
    }

    .table th,
    .table td {
        text-align: center !important;
        vertical-align: middle !important;
    }
</style>
@endsection

@section('body')
<main>
    @yield('drop-menu-navigation')
    <div class="container">
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

        <div class="row mb-3">
            <div class="col-12 col-md-4 mt-3">
                <div class="card">
                    <div class="card-header">
                        <i class="fa-solid fa-clipboard-check me-2"></i> REJECT SUMMARY STATUS
                    </div>
                    <div class="card-body" style="color:white;">
                        <div class="d-flex justify-content-between mt-3">
                            <div class="flex-fill m-1 d-flex flex-column align-items-center p-3" style="background-color: #f6e8ee;box-shadow: 0px 0px 4px #00000040; border-top-left-radius: 10px;">
                                <span style="font-size: 80%; font-weight: 600; color: #787779" class="primary-text">ACTUAL OUTPUT</span>
                                <span style="font-size: 200%; font-weight: 600; color: #000080" class="analysis-quality-data" data-tag="total_actual_output">--</span>
                                <span style="font-size: 80%; color: #000080; font-weight: 600">PCS</span>
                            </div>
                            <div class="flex-fill m-1 d-flex flex-column align-items-center p-3" style="background-color: #f6e8ee;box-shadow: 0px 0px 4px #00000040;border-top-right-radius: 10px;">
                                <span style="font-size: 80%; font-weight: 600; color: #787779" class="primary-text">TOTAL REJECT</span>
                                <span style="font-size: 200%; font-weight: 600; color: #000080" class="analysis-quality-data" data-tag="total_reject_count">--</span>
                                <span style="font-size: 80%; color: #000080; font-weight: 600">PCS</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between p-2 m-1" style="background-color: #f6e8ee;box-shadow: 0px 0px 4px #00000040;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                            <span class="primary-text text-wrap w-50">
                                REJECT PERCENTAGE (%)
                            </span>
                            <span style="font-size: 200%; font-weight: 600;color: #000080" class="align-self-center renderer-percentage analysis-quality-data" data-tag="reject_percentage">
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card mobile-card mt-3">
                    <div class="card-header">
                        <i class="fa-light fa-file-invoice me-2"></i> DOWNLOAD / PRINT REPORT
                    </div>
                    <div class="card-body secondary-text" style="font-size: 2.5em;">
                        <form id="report-form" target="_blank" action="{{ route('analysis.quality.get.data', [$plant->uid]) }}" method="POST">
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

            <div class="col-12 col-md-4 d-flex justify-content-center align-items-center">
                <div>
                    <canvas id="defects"></canvas>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="d-flex flex-column h-100">
                    <h5 class="secondary-text">TOP 10 REJECT BY DEFECT PART (PCS)</h5>
                    <div class="w-100 my-3" style="flex-grow:1">
                        <canvas id="top10reject"></canvas>
                    </div>
                </div>
            </div>


            <div class="col-12 overflow-auto mt-3">
                <table id="production-line-datatable" class="table nowrap table-hover mt-3 text-wrap" style="width:100%; font-size:80%">
                </table>
            </div>

            <div class="col-12 overflow-auto mt-3">
                <table id="production-line-reject-datatable" class="table nowrap table-hover mt-3 text-wrap" style="width:100%; font-size:80%">
                </table>
            </div>
        </div>


    </div>
</main>
@endsection

@section('scripts')
@parent
<script>

        //Renderer


        //Date Range picker

                //result code


                //TODO: display error message in modal

            // $('#report-form').submit();

        /*

            <th>NO</th>
            <th>DATE</th>
            <th>SHIFT</th>
            <th>LINE</th>
            <th class="text-wrap" style="width: 50px;">PRODUCTION ORDER</th>
            <th>PART NUMBER</th>
            <th>PART NAME</th>
            <th class="text-wrap" style="width: 50px;">TOTAL OUTPUT</th>
            <th class="text-wrap" style="width: 50px;">TOTAL REJECT</th>
            <th class="text-wrap" style="width: 50px;">SETTING REJECT (PCS)</th>
            <th class="text-wrap" style="width: 50px;">PROCESS REJECT (PCS)</th>
            <th class="text-wrap" style="width: 50px;">MATERIAL REJECT (PCS)</th>
        */

        /*
            <th>NO</th>
            <th>DATE</th>
            <th>SHIFT</th>
            <th>LINE</th>
            <th class="text-wrap" style="width: 50px;">PRODUCTION ORDER</th>
            <th>PART NUMBER</th>
            <th>PART NAME</th>
        */

</script>
@endsection

@section('modals')
@parent
<div>

</div>
@endsection