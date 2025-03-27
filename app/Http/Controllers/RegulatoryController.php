<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departments;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\RegulatoryOffice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class RegulatoryController extends Controller
{
    public function getOfficer()
    {
        $officer = RegulatoryOffice::with(['users' => function ($q) {
            $q->select('*')->with(['departments' => function ($q) {
                $q->select('*');
            }]);
        }])->latest()->get();
        return response()->json(['success' => true, 'officer' => $officer], 200);
    }

    public function viewofficer($id)
    {
        $viewofficer = RegulatoryOffice::where('id', $id)->with(['users' => function ($q) {
            $q->select('*')->with(['departments' => function ($q) {
                $q->select('*');
            }]);
        }])->latest()->get();
        return response()->json(['success' => true, 'viewofficer' => $viewofficer], 200);
    }

    public function activeofficer($id)
    {
        $status = 'Active';
        $activeofficer = RegulatoryOffice::findOrfail($id);
        $activeofficer->update([
            'status' => $status,
        ]);
        return response()->json(['success' => true, 'activeofficer' => $activeofficer], 200);
    }


    public function disableofficer($id)
    {
        $status = 'Disable';
        $disableofficer = RegulatoryOffice::findOrfail($id);
        $disableofficer->update([
            'status' => $status,
        ]);
        return response()->json(['success' => true, 'disableofficer' => $disableofficer], 200);
    }


    public function editofficer(Request $request)
    {
        $id = request('id');
        $user_id = request('user_id');


        $profile = RegulatoryOffice::findOrFail($id);
        // Validate the input
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $oldImage = $profile->image;

        // Store the new image if provided
        if ($request->hasFile('image')) {
            if ($oldImage && Storage::exists('public/images/' . $oldImage)) {
                Storage::delete('public/images/' . $oldImage);
            }
            $newImagePath = $request->file('image')->store('public/images');
            $profile->image = basename($newImagePath);
        }

        $editofficer =  RegulatoryOffice::updateOrCreate(
            ['id' => request('id')],
            [
                'firstname' => request('first_name'),
                'lastname' => request('last_name'),
                'middlename' => request('middle_name'),
                'age' => request('age'),
                'contact' => request('contact_number'),
                // 'email' => request('email'),
                'department_id' => request('dept'),
                'position' => request('position'),
                'gender' => request('gender'),
                'address' => request('address'),

            ]
        );

        $edituser = null;

        if ($edituser = User::find($user_id)) {
            $edituser->update([
                'email' => request('email'),
                'username' => request('first_name'),
            ]);
        } else {
            $edituser = User::updateOrCreate(
                ['id' => $user_id],
                [
                    'email' => request('email'),
                    'username' => request('first_name'),

                ]
            );
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = rand() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $filename); // Store image in storage/public/images
            $editofficer->image = $filename; // Update image filename in the database
            $editofficer->save(); // Save the changes
        }

        return response()->json(['success' => true, 'editofficer' => $editofficer, 'edituser' => $edituser], 200);
    }

    public function getdepartment()
    {
        $department = Departments::get();
        return response()->json(['success' => true, 'department' => $department], 200);
    }

    public function getImage()
    {
        $latestProfile = RegulatoryOffice::latest()->get();

        return response()->json(['message' => 'Image uploaded successfully', 'image' => $latestProfile]);
    }

    public function addofficer(Request $request)
    {
        $random_password = bcrypt('password');
    
        $adduser = User::create([
            'username' => request('first_name'),
            'email' => request('email'),
            'password' => $random_password,
            'department_id' => request('dept'),
        ]);
    
        $filename = null; // Initialize the filename as null
    
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|max:5000',
            ]);
    
            $image = $request->file('image');
    
            // Generate a unique filename
            $filename = rand() . '.' . $image->getClientOriginalExtension();
    
            // Store the image in the 'public' disk (you can configure other disks in config/filesystems.php)
            $image->storeAs('images', $filename, 'public');
        }
    
        $addofficer = RegulatoryOffice::create([
            'user_id' => $adduser->id,
            'firstname' => request('first_name'),
            'lastname' => request('last_name'),
            'middlename' => request('middle_name'),
            'age' => request('age'),
            'contact' => request('contact_number'),
            'position' => request('position'),
            'gender' => request('gender'),
            'address' => request('address'),
            'image' => $filename,
        ]);
    
        return response()->json(['success' => true, 'addofficer' => $addofficer, 'adduser' => $adduser], 200);
    }


    
    
}
