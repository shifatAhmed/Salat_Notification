<?php
namespace Shifat\Salat_notification\Controllers;

use Illuminate\Routing\Controller;
use Shifat\Salat_notification\Salat_notification;
use Shifat\Salat_notification\Models\salat_waqt;
use datetime;
use Illuminate\Support\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Http\Request;

class SalatController
{
    public function salat_waqt_view() {
        $data = salat_waqt::all();
        return view('salatTime_form',  ['waqts' => $data]);
    }

    public function create_waqt(Request $request) {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'nullable|date_format:H:i',
        ]);
        $salat_waqt = new salat_waqt;
        $salat_waqt->name = $request->name;
        $salat_waqt->time = $request->time;
        $result=$salat_waqt->save();
       
        return redirect()->route('salat_waqt_view');
    }

    public function update_waqt(Request $request, $id){
        $salat_waqt = salat_waqt::find($id);

        if (!$salat_waqt) {
            return response()->json(['message' => 'salat_waqt not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'nullable|date_format:H:i',
        ]);

        $salat_waqt->name = $request->input('name');
        $salat_waqt->time = $request->input('time');
        $salat_waqt->save();

        return response()->json(['message' => 'salat_waqt updated successfully']);
    }

    public function delete_waqt (Request $request, $id){

        $salat_waqt = salat_waqt::find($id);

        if (!$salat_waqt) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $salat_waqt->delete();
    
        return response()->json(['message' => 'Item deleted successfully']);

    }

}

