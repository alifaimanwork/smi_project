<?php

namespace App\Http\Controllers\Dashboard;

use App\Extras\Traits\WorkCenterTrait;
use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\WorkCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    use WorkCenterTrait;
    //
    public function index(Request $request, $plantUid, $workCenterUid)
    {
        $plant = Plant::where('uid', $plantUid)->firstOrFail();

        $workCenter = $plant->onPlantDb()->workCenters()->where(WorkCenter::TABLE_NAME . '.uid', $workCenterUid)->firstOrFail();


        if (!$workCenter->dashboardLayout)
            abort(404);

        $view = $workCenter->dashboardLayout->getView();

        //check view available
        if (!$view || !View::exists($view))
            abort(404);


        /** @var \App\Models\Production $currentProduction */
        $currentProduction = $workCenter->currentProduction;

        if ($currentProduction)
            $productionLines = $currentProduction->productionLines()->with(['productionOrder', 'part'])->get();
        else
            $productionLines = [];

        $viewData = [
            'plant' => $plant,
            'workCenter' => $workCenter,
            'production' => $currentProduction,
            'productionLines' => $productionLines,
            'updateTerminalUrl' => route('dashboard.get.data', [$plant->uid, $workCenter->uid]),
            'pageTitle' => 'IPOS DASHBOARD'
        ];
        return view($view, $viewData);
    }
    public function getTerminalData(Request $request, $plantUid, $workCenterUid)
    {
        $zoneData = $this->getPlantWorkCenter($plantUid, $workCenterUid);
        if (is_null($zoneData))
            abort(404);

        /** @var \App\Models\Plant $plant */
        $plant = $zoneData['plant'];

        /** @var \App\Models\WorkCenter $workCenter */
        $workCenter = $zoneData['workCenter'];

        $responseData = [
            'plantId' => $plant->id,
            'plantUid' => $plant->uid,
            'workCenterUid' => $workCenter->uid,
        ];

        /** @var \App\Models\Production $currentProduction */
        $currentProduction = $workCenter->currentProduction()->first();
        if ($currentProduction) {
            $responseData['production'] = $currentProduction->toArray();
            $responseData['productionLines'] = $currentProduction->productionLines()->with('productionOrder')->get()->toArray();
        } else {
            $responseData['production'] = null;
            $responseData['productionLines'] = [];
        }
        $responseData['workCenter'] = $workCenter->toArray();

        //Reply data similar to WorkCenterDataUpdatedEvent broadcast
        return $responseData;
    }
}
