<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Listing User Data
    public function index(Request $request)
    {
        $query = User::orderBy('id', 'desc');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }
        $data['users'] = $query->paginate(10)->withQueryString();
        return view('admin.user.index', $data);       
    }

    // Add user Data
    public function create()
    {               
        return view('admin.user.add');
    }

    //Insert Customer Data
    public function store(Request $request)
    {
        // Validation
        $request->validate([            
            'name'                 => 'required|string|max:255',
            'business_name'        => 'required|string|max:255',
            'vat_number'           => 'required|string|max:255',
            'mobile'               => ['required', 'regex:/^[0-9]{10,15}$/'],
            'address'              => 'nullable|string|max:500',
            'email'                => 'required|email|unique:users,email|max:255',
            'password'             => 'required|string|min:6|confirmed',
            'photo'                => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'status'               => 'required|boolean',
        ], [
            'mobile.regex'         => 'The mobile number must be 10 to 15 digits.',
            'email.email'          => 'Enter a valid email address.',
            'email.unique'         => 'This email is already registered.',
            'password.confirmed'   => 'Password confirmation does not match.',
            'photo.image'          => 'Profile photo must be an image.',
            'photo.mimes'          => 'Only jpeg, jpg, png images are allowed.',
        ]);
        
        // Store Data
        $user = new User();
        $user->name                 = $request->name;
        $user->business_name        = $request->business_name;
        $user->vat_number           = $request->vat_number;
        $user->mobile               = $request->mobile;
        $user->address              = $request->address;
        $user->email                = $request->email;
        $user->password             = Hash::make($request->password);
        $user->status               = $request->status;

        // Handle photo upload if exists             
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/users'), $filename);
            $user->photo = $filename;
        }

        $user->save();
        return redirect()->route('admin.user.list')->with('success', 'User created successfully.');
    }
    
    //Edit Customer Data
    public function edit($id)
    {
        $data['user'] = User::findOrFail($id);               
        return view('admin.user.edit', $data);
    }

    //Update Customer Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'business_name'     => 'required|string|max:255',
            'vat_number'        => 'required|string|max:255',
            'mobile'            => ['required', 'regex:/^[0-9]{10,15}$/'],
            'address'           => 'nullable|string|max:500',
            'email'    => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'nullable|string|min:6|confirmed', 
            'photo'    => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'status'   => 'required|boolean',
        ], [
            'email.unique'       => 'This email is already registered.',
            'mobile.regex'       => 'The mobile number must be 10 to 15 digits.',
            'password.confirmed' => 'Password confirmation does not match.',
            'photo.image'        => 'Profile photo must be an image.',
            'photo.mimes'        => 'Only jpeg, jpg, png images are allowed.',
        ]);

        $user = User::findOrFail($id);
        $user->name              = $request->name;
        $user->vat_number        = $request->business_name;
        $user->mobile            = $request->mobile;
        $user->address           = $request->address;
        $user->email             = $request->email;
        $user->status            = $request->status;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/users'), $filename);
            $user->photo = $filename;
        }

        $user->save();
        return redirect()->route('admin.user.list')->with('success', 'User updated successfully.');
    }   

    //Detail View User Data
    public function detailView($id)
    {
        $data['user'] = User::findOrFail($id);        
        return view('admin.user.view', $data);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Delete photo from storage if exists
        if ($user->photo && file_exists(public_path('uploads/users/' . $user->photo))) {
            File::delete(public_path('uploads/users/' . $user->photo));
        }

        $user->delete();

        return redirect()->route('admin.user.list')->with('success', 'User deleted successfully.');
    }

}