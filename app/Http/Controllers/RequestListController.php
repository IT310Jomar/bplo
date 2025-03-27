<?php

namespace App\Http\Controllers;

// use App\Models\Client;
use App\Models\User;
use Twilio\Rest\Client;
use App\Models\RequestList;
use Illuminate\Http\Request;
use App\Models\PermitCategory;
use App\Models\GeneratedHistory;
use App\Notifications\SendTwilioSms;

class RequestListController extends Controller
{

    //GET PENDING REQUEST LIST
    public function getpendingrequestlist()
    {
        $getrequestlist = RequestList::where('request_status_id', '=', '1')
            ->with(['client' => function ($q) {
                $q->select('*');
            }])->with(['permit' => function ($q) {
                $q->select('*');
            }])->with(['status' => function ($q) {
                $q->select('*');
            }])->with(['category' => function ($q) {
                $q->select('*');
            }])
            ->latest()->get();
        return response()->json(['success' => true, 'getrequestlist' => $getrequestlist], 200);
    }


    //pending search
    public function searchRequestPending()
    {
        $search = request('query');
        $categoryPending = request('category'); // Assuming you are searching by category here

        // No need to cast $categoryPending to an integer if it's an ID.

        if ($search) {
            $searchPending = RequestList::with(['client', 'permit', 'status', 'category'])
                ->where('request_status_id', '=', 1) // Use integer value for comparison
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('client', function ($q) use ($search) {
                        $q->whereRaw("concat(firstname, ' ', middlename, ' ', lastname) like ?", ["%{$search}%"]);
                    })
                        ->orWhereHas('client', function ($q) use ($search) {
                            $q->where('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('permit', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('status', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('client', function ($q) use ($search) {
                            $q->where('contact', 'like', "%{$search}%");
                        });
                })
                ->get();

            return response()->json(['success' => true, 'searchPending' => $searchPending], 200);
        } else {
            $searchPending = RequestList::with(['client', 'permit', 'status', 'category'])
                ->where('request_status_id', '=', 1) // Use integer value for comparison
                ->where('category_id', $categoryPending)
                ->get();

            return response()->json(['success' => true, 'searchPending' => $searchPending], 200);
        }
    }


    //pending category

    public function getcategory()
    {
        $categoryPermit = PermitCategory::get();
        return response()->json(['success' => true, 'categoryPermit' => $categoryPermit], 200);
    }


    //approved search

    public function searchRequestApprove()
    {
        $search = request('query');
        $categoryApprove = request('category'); // Assuming you are searching by category here

        if ($search) {
            $searchApproved = RequestList::with(['client', 'permit', 'status', 'category'])
                ->where('request_status_id', '=', '2') // Filter by request_status_id
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('client', function ($q) use ($search) {
                        $q->whereRaw("concat(firstname, ' ', middlename, ' ', lastname) like ?", ["%{$search}%"]);
                    })
                        ->orWhereHas('client', function ($q) use ($search) {
                            $q->where('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('permit', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('status', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('client', function ($q) use ($search) {
                            $q->where('contact', 'like', "%{$search}%");
                        });
                })
                ->get();
            return response()->json(['success' => true, 'searchApproved' => $searchApproved], 200);
        } else {
            $searchApproved = RequestList::with(['client', 'permit', 'status', 'category'])
                ->where('request_status_id', '=', '2') // Use integer value for comparison
                ->where('category_id', $categoryApprove)
                ->get();

            return response()->json(['success' => true, 'searchApproved' => $searchApproved], 200);
        }
    }


    //reject search

    public function searchRequestReject()
    {
        $search = request('query');
        $categoryReject = request('category'); // Assuming you are searching by category here

        if ($search) {
            $searchReject = RequestList::with(['client', 'permit', 'status', 'category'])
                ->where('request_status_id', '=', '3') // Filter by request_status_id
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('client', function ($q) use ($search) {
                        $q->whereRaw("concat(firstname, ' ', middlename, ' ', lastname) like ?", ["%{$search}%"]);
                    })
                        ->orWhereHas('client', function ($q) use ($search) {
                            $q->where('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('permit', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('status', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('client', function ($q) use ($search) {
                            $q->where('contact', 'like', "%{$search}%");
                        });
                })
                ->get();

            return response()->json(['success' => true, 'searchReject' => $searchReject], 200);
        } else {
            $searchReject = RequestList::with(['client', 'permit', 'status', 'category'])
                ->where('request_status_id', '=', '3') // Use integer value for comparison
                ->where('category_id', $categoryReject)
                ->get();

            return response()->json(['success' => true, 'searchReject' => $searchReject], 200);
        }
    }


    //rejected category

    // public function approvecategory()
    // {
    //     $categoryPermit = PermitCategory::get();
    //     return response()->json(['success' => true, 'categoryPermit' => $categoryPermit], 200);
    // }



    //GET APPROVAL REQUEST LIST
    public function getapprovalrequestlist()
    {
        $getapprovalrequestlist = RequestList::where('request_status_id', '=', '2')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['status' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])
            ->latest()->get();
        return response()->json(['success' => true, 'getapprovalrequestlist' => $getapprovalrequestlist], 200);
    }

    //GET REJECT REQUEST LIST
    public function getrejectrequestlist()
    {
        $getrejectrequestlist = RequestList::where('request_status_id', '=', '3')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['status' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])
            ->latest()->get();
        return response()->json(['success' => true, 'getrejectrequestlist' => $getrejectrequestlist], 200);
    }



    //buco start
    public function approveRequestList()
    {
        $approverequestlist = RequestList::where('request_status_id', '=', '2')->where('buco_status', 'Pending')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'approverequestlist' => $approverequestlist], 200);
    }

    public function approveList()
    {
        $approverequestlist = RequestList::where('request_status_id', '=', '2')->where('buco_status', 'Approved')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'approverequestlist' => $approverequestlist], 200);
    }

    public function rejectList()
    {
        $rejectrequestlist = RequestList::where('request_status_id', '=', '2')->where('buco_status', 'Reject')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'rejectrequestlist' => $rejectrequestlist], 200);
    }

    //buco end


    //bfp start

    public function approveRequestbfp()
    {
        $approverequestlist = RequestList::where('request_status_id', '=', '2')->where('bfp_status', 'Pending')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'approverequestlist' => $approverequestlist], 200);
    }

    public function approvebfplist()
    {
        $approverequestlist = RequestList::where('request_status_id', '=', '2')->where('bfp_status', 'Approved')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'approverequestlist' => $approverequestlist], 200);
    }

    public function rejectbfp()
    {
        $rejectrequestlist = RequestList::where('request_status_id', '=', '2')->where('bfp_status', 'Reject')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'rejectrequestlist' => $rejectrequestlist], 200);
    }


    //bfp end 


    //cleanro start

    public function pendinglistcleanro()
    {
        $approverequestlist = RequestList::where('request_status_id', '=', '2')->where('cleanro_status', 'Pending')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'approverequestlist' => $approverequestlist], 200);
    }

    public function approveListcleanro()
    {
        $approverequestlist = RequestList::where('request_status_id', '=', '2')->where('cleanro_status', 'Approved')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'approverequestlist' => $approverequestlist], 200);
    }

    public function rejectcleanros()
    {
        $rejectrequestlist = RequestList::where('request_status_id', '=', '2')->where('cleanro_status', 'Reject')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'rejectrequestlist' => $rejectrequestlist], 200);
    }
    //cleanro end



    //health start

    public function pendinglisthealth()
    {
        $approverequestlist = RequestList::where('request_status_id', '=', '2')->where('health_status', 'Pending')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'approverequestlist' => $approverequestlist], 200);
    }

    public function approveListhealth()
    {
        $approverequestlist = RequestList::where('request_status_id', '=', '2')->where('health_status', 'Approved')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'approverequestlist' => $approverequestlist], 200);
    }

    public function rejecthealths()
    {
        $rejectrequestlist = RequestList::where('request_status_id', '=', '2')->where('health_status', 'Reject')->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])->latest()->get();

        return response()->json(['success' => true, 'rejectrequestlist' => $rejectrequestlist], 200);
    }
    //health end




    public function viewrequirments($id)
    {

        $viewrequirments = RequestList::where('id', $id)->with(['client' => function ($q) {
            $q->select('*');
        }])->with(['permit' => function ($q) {
            $q->select('*');
        }])->with(['status' => function ($q) {
            $q->select('*');
        }])->with(['category' => function ($q) {
            $q->select('*');
        }])


            ->latest()->get();
        return response()->json(['success' => true, 'viewrequirments' => $viewrequirments], 200);
    }


    public function approvepermit($id)
    {
        $status = '2';
        $approvepermit = RequestList::with(['status' => function ($q) {
            $q->select('*');
        }])->findOrfail($id);
        $approvepermit->update([
            'request_status_id' => $status,
        ]);
        return response()->json(['success' => true, 'approvepermit' => $approvepermit], 200);
    }

    public function rejectpermit($id)
    {
        $status = '3';
        $rejectpermit = RequestList::with(['status' => function ($q) {
            $q->select('*');
        }])->findOrfail($id);
        $rejectpermit->update([
            'request_status_id' => $status,
        ]);
        return response()->json(['success' => true, 'rejectpermit' => $rejectpermit], 200);
    }

    public function requirements(Request $request, $id)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'NBI' => 'string', // Adjust validation rules as needed
            'SSS' => 'string'
        ]);

        // Find the RequestList record by ID
        $reqsList = RequestList::findOrFail($id);

        // Update the requirements field
        $reqsList->update([
            'requirements' => json_encode([$validatedData['NBI'], $validatedData['SSS']])
        ]);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Requirements updated successfully',
            'reqs' => $reqsList
        ], 200);
    }


    public function listData()
    {
        $reqsData = RequestList::latest()->get();

        return response()->json(['success' => true, 'list' => $reqsData], 200);
    }

    //buco_APPROVE

    public function approvebuco($id)
    {
        $status = 'Approved';
        $approvebfp = RequestList::findOrfail($id);
        $approvebfp->update([
            'buco_status' => $status,
        ]);
        return response()->json(['success' => true, 'approvebfp' => $approvebfp], 200);
    }
    //reject buco
    public function rejectbuco($id)
    {
        $status = 'Reject';
        $rejectbuco = RequestList::findOrfail($id);
        $rejectbuco->update([
            'buco_status' => $status,
        ]);
        return response()->json(['success' => true, 'rejectbuco' => $rejectbuco], 200);
    }




    //bfp_APPROVE

    public function approvebfp($id)
    {
        $status = 'Approved';
        $approvebfp = RequestList::findOrfail($id);
        $approvebfp->update([
            'bfp_status' => $status,
        ]);
        return response()->json(['success' => true, 'approvebfp' => $approvebfp], 200);
    }



    //rejection bfp

    public function rejectlistbfp($id)
    {
        $status = 'Reject';
        $rejectbfp = RequestList::findOrfail($id);
        $rejectbfp->update([
            'bfp_status' => $status,
        ]);
        return response()->json(['success' => true, 'rejectbfp' => $rejectbfp], 200);
    }


    //cleanro_APPROVE

    public function approvecleanro($id)
    {
        $status = 'Approved';
        $approvecleanro = RequestList::findOrfail($id);
        $approvecleanro->update([
            'cleanro_status' => $status,
        ]);
        return response()->json(['success' => true, 'approvecleanro' => $approvecleanro], 200);
    }



    //rejection cleanro

    public function rejectcleanro($id)
    {
        $status = 'Reject';
        $rejectcleanro = RequestList::findOrfail($id);
        $rejectcleanro->update([
            'cleanro_status' => $status,
        ]);
        return response()->json(['success' => true, 'rejectcleanro' => $rejectcleanro], 200);
    }


    //health_APPROVE

    public function approvehealth($id)
    {
        $status = 'Approved';
        $approvehealth = RequestList::findOrfail($id);
        $approvehealth->update([
            'health_status' => $status,
        ]);
        return response()->json(['success' => true, 'approvehealth' => $approvehealth], 200);
    }



    //rejection cleanro

    public function rejecthealth($id)
    {
        $status = 'Reject';
        $rejecthealth = RequestList::findOrfail($id);
        $rejecthealth->update([
            'health_status' => $status,
        ]);
        return response()->json(['success' => true, 'rejecthealth' => $rejecthealth], 200);
    }


    //generate start


    //generate pending 

    //    public function generatependingList()
    //     {
    //         $approverequestlist = RequestList::where('request_status_id', 2)
    //             ->where('buco_status', 'Pending')
    //             ->where('health_status', 'Pending')
    //             ->where('cleanro_status', 'Pending')
    //             ->where('bfp_status', 'Pending')
    //             ->with(['client', 'permit', 'category'])
    //             ->latest()
    //             ->get();

    //         return response()->json(['success' => true, 'approverequestlist' => $approverequestlist], 200);
    //     }
    //generate approve


    public function generateapproveList()
    {
        $approverequestlist = RequestList::where('request_status_id', 2)
            ->where('buco_status', 'Approved')
            ->where('health_status', 'Approved')
            ->where('cleanro_status', 'Approved')
            ->where('bfp_status', 'Approved')
            ->where('generated_status', 'No')
            ->with(['client', 'permit', 'category'])
            ->latest()
            ->get();

        return response()->json(['success' => true, 'approverequestlist' => $approverequestlist], 200);
    }


//buco_sms
    public function sendSMS(Request $request, $id)
    {

        $requestApproved = RequestList::with(['client', 'permit', 'category'])->findOrfail($id);
        // dd($requestApproved);

        // Your Twilio Account SID and Auth Token
        $sid = "ACa51062843a4ddeb247188cc795e4d2c3";
        $token = "4af26be0be7bb8637348c7cfdd489c12";
    
        // Initialize the Twilio client
        $twilio = new Client($sid, $token);
    
        // Recipient's phone number (in E.164 format, including the country code)
        $toPhoneNumber = '+639069291624'; // Replace with the recipient's actual number
    
        // Your Twilio phone number
        $fromPhoneNumber = "+13343848283"; // Replace with your Twilio number
    
        // Message content
        $messageBody = $request->input('requirements');
        $formattedDate = date("F d, Y", strtotime($messageBody));
        $lastname = request('fullname');
        $hello = 'Hello Mr/Ms';
        $welcome = 'Your Schedule is';
    
        try {
            // Send the SMS
            $message = $twilio->messages->create(
                $toPhoneNumber,
                [
                    "from" => $fromPhoneNumber,
                    "body" => $hello.' '. $lastname.' '.$welcome.' '.$formattedDate,
                ]
            );
    
            // You can do something with the message SID if needed
            $messageSid = $message->sid;
    
            return  response()->json(['success' => true, 'requestApproved' => $requestApproved, "SMS sent successfully! Message SID: " . $messageSid], 200);
        } catch (\Exception $e) {
            return "Error sending SMS: " . $e->getMessage();
        }
    }


    //bfp_sms

    public function bfpsms(Request $request, $id)
    {

        $requestApproved = RequestList::with(['client', 'permit', 'category'])->findOrfail($id);
        // dd($requestApproved);

        // Your Twilio Account SID and Auth Token
        $sid = "ACa51062843a4ddeb247188cc795e4d2c3";
        $token = "4af26be0be7bb8637348c7cfdd489c12";
    
        // Initialize the Twilio client
        $twilio = new Client($sid, $token);
    
        // Recipient's phone number (in E.164 format, including the country code)
        $toPhoneNumber = '+639069291624'; // Replace with the recipient's actual number
    
        // Your Twilio phone number
        $fromPhoneNumber = "+13343848283"; // Replace with your Twilio number
    
        // Message content
        $messageBody = $request->input('requirements');
        $formattedDate = date("F d, Y", strtotime($messageBody));
        $lastname = request('fullname');
        $hello = 'Hello Mr/Ms';
        $welcome = 'Your Schedule Inspection Is';
    
        try {
            // Send the SMS
            $message = $twilio->messages->create(
                $toPhoneNumber,
                [
                    "from" => $fromPhoneNumber,
                    "body" => $hello.' '. $lastname.' '.$welcome.' '.$formattedDate,
                ]
            );
    
            // You can do something with the message SID if needed
            $messageSid = $message->sid;
    
            return  response()->json(['success' => true, 'requestApproved' => $requestApproved, "SMS sent successfully! Message SID: " . $messageSid], 200);
        } catch (\Exception $e) {
            return "Error sending SMS: " . $e->getMessage();
        }
    }


    //health_sms

    public function healthsms(Request $request, $id)
    {

        $requestApproved = RequestList::with(['client', 'permit', 'category'])->findOrfail($id);
        // dd($requestApproved);

        // Your Twilio Account SID and Auth Token
        $sid = "ACa51062843a4ddeb247188cc795e4d2c3";
        $token = "4af26be0be7bb8637348c7cfdd489c12";
    
        // Initialize the Twilio client
        $twilio = new Client($sid, $token);
    
        // Recipient's phone number (in E.164 format, including the country code)
        $toPhoneNumber = '+639069291624'; // Replace with the recipient's actual number
    
        // Your Twilio phone number
        $fromPhoneNumber = "+13343848283"; // Replace with your Twilio number
    
        // Message content
        $messageBody = $request->input('requirements');
        $formattedDate = date("F d, Y", strtotime($messageBody));
        $lastname = request('fullname');
        $hello = 'Hello Mr/Ms';
        $welcome = 'Your Schedule Inspection Is';
    
        try {
            // Send the SMS
            $message = $twilio->messages->create(
                $toPhoneNumber,
                [
                    "from" => $fromPhoneNumber,
                    "body" => $hello.' '. $lastname.' '.$welcome.' '.$formattedDate,
                ]
            );
    
            // You can do something with the message SID if needed
            $messageSid = $message->sid;
    
            return  response()->json(['success' => true, 'requestApproved' => $requestApproved, "SMS sent successfully! Message SID: " . $messageSid], 200);
        } catch (\Exception $e) {
            return "Error sending SMS: " . $e->getMessage();
        }
    }





}
