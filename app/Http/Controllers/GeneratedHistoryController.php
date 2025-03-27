<?php

namespace App\Http\Controllers;

use App\Models\RequestList;
use Illuminate\Http\Request;
use App\Models\GeneratedHistory;

class GeneratedHistoryController extends Controller
{
    public function generated_history($id)
    {
        $reqsList = RequestList::findOrfail($id);

        $genrated_history = GeneratedHistory::create([
            'request_list_id' => $reqsList->id,
        ]);

        $status = 'Yes';
        $approvehistory = RequestList::findOrfail($id);
        $approvehistory->update([
            'generated_status' => $status,
        ]);
        

        return response()->json(['success' => true, 'genrated_history' => $genrated_history], 200);
    }

    public function get_generated_history() {
        $get_generated_history = GeneratedHistory::with(['requestlist' => function ($q) {
            $q->select("*")->with(['client' => function ($q) {
                $q->select('*');
            }])->with(['permit' => function ($q) {
                $q->select('*');
            }])->with(['category' => function ($q) {
                $q->select('*');
            }]);
        }])->latest()->get();

        return response()->json(['success' => true, 'get_generated_history' => $get_generated_history], 200);
    }

}
