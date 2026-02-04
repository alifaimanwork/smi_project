<?php

namespace App\Http\Controllers\Terminal;

use App\Extras\Traits\TerminalRoutingTrait;
use App\Extras\Traits\WorkCenterTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkCenter;
use Illuminate\Http\Request;

class ProgressStatusController extends Controller
{
    use WorkCenterTrait;
    use TerminalRoutingTrait;
    //
    public function index(Request $request, $plantUid, $workCenterUid)
    {
        $zoneData = $this->getPlantWorkCenter($plantUid, $workCenterUid);
        if (is_null($zoneData))
            abort(404);

        /** @var \App\Models\WorkCenter $workCenter */
        $workCenter = $zoneData['workCenter'];
        
        
        
        if (!$workCenter->currentProduction) {
            //no production, reset work station state to idle
            $workCenter->status = WorkCenter::STATUS_IDLE;
            $workCenter->save();
            return redirect()->route('terminal.production-planning.index', [$plantUid, $workCenterUid]);
        }

        if ($shouldRoute = $this->checkTerminalRoute($workCenter)) {
            return $shouldRoute;
        }

        /** @var \App\Models\Production $currentProduction */
        $currentProduction = $workCenter->currentProduction;

        if ($currentProduction)
            $productionLines = $currentProduction->productionLines()->with(['productionOrder', 'part'])->orderBy('line_no')->get();
        else
            $productionLines = [];

        $workCenterDowntimes = $workCenter->workCenterDowntimes()->get();
        if ($currentProduction)
            $activeDowntimeEvents = $currentProduction->getActiveDowntimeEvent();
        else
            $activeDowntimeEvents = [];

        $viewData = array_merge(
            $zoneData,
            [
                'user' => User::getCurrent(),
                'menuActive' => 'progress-status',
                'topBarTitle' => 'SMI IPOS TERMINAL',

                'production' => $currentProduction,
                'productionLines' => $productionLines,

                'workCenterDowntimes' => $workCenterDowntimes,
                'activeDowntimeEvents' => $activeDowntimeEvents,
                'downtimes' => $workCenter->downtimes
            ]
        );
        
        return view('pages.terminal.progress-status.index', $viewData);
    }


    public function setStopProduction(Request $request, $plantUid, $workCenterUid)
    {
        $zoneData = $this->getPlantWorkCenter($plantUid, $workCenterUid, false);

        if (!$zoneData)
            abort(404);

        /** @var \App\Models\WorkCenter $workCenter  */
        $workCenter = $zoneData->workCenter;

        /** @var \App\Models\Plant $plant */
        $plant = $zoneData->plant;


        //Stop Production
        return $workCenter->setStopProduction();
    }

    public function setResumeProduction(Request $request, $plantUid, $workCenterUid)
    {
        $zoneData = $this->getPlantWorkCenter($plantUid, $workCenterUid, false);

        if (!$zoneData)
            abort(404);

        /** @var \App\Models\WorkCenter $workCenter  */
        $workCenter = $zoneData->workCenter;

        /** @var \App\Models\Plant $plant */
        $plant = $zoneData->plant;


        //Resume Production
        return $workCenter->setResumeProduction();
    }

    public function setBreakProduction(Request $request, $plantUid, $workCenterUid)
    {
        $zoneData = $this->getPlantWorkCenter($plantUid, $workCenterUid, false);

        if (!$zoneData)
            abort(404);

        /** @var \App\Models\WorkCenter $workCenter  */
        $workCenter = $zoneData->workCenter;

        /** @var \App\Models\Plant $plant */
        $plant = $zoneData->plant;


        //Stop Production
        return $workCenter->setBreakProduction();
    }
}
