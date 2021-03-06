<?php

namespace App\Http\Controllers\Admins\DataMaster;

use App\Events\Auth\UserActivationEmail;
use App\Http\Controllers\Api\APIController as Credential;
use App\Models\User;
use App\Models\Admin;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AccountsController extends Controller
{
    public function showAdminsTable()
    {
        $admins = Admin::all();

        return view('_admins.tables.accounts.admin-table', compact('admins'));
    }

    public function createAdmins(Request $request)
    {
        $this->validate($request, [
            'ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:admins',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required'
        ]);

        if ($request->hasfile('ava')) {
            $name = $request->file('ava')->getClientOriginalName();
            $request->file('ava')->storeAs('public/admins/ava', $name);

        } else {
            $name = 'avatar.png';
        }

        Admin::create([
            'ava' => $name,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);
        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updateProfileAdmins(Request $request)
    {
        $admin = Admin::find($request->id);
        $this->validate($request, [
            'ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
        ]);
        if ($request->hasFile('ava')) {
            $name = $request->file('ava')->getClientOriginalName();
            if ($admin->ava != '' || $admin->ava != 'avatar.png') {
                Storage::delete('public/admins/ava/' . $admin->ava);
            }
            $request->file('ava')->storeAs('public/admins/ava', $name);

        } else {
            $name = $admin->ava;
        }
        $admin->update([
            'ava' => $name,
            'name' => $request->name
        ]);

        return back()->with('success', 'Successfully update ' . $admin->name . '\'s profile!');
    }

    public function updateAccountAdmins(Request $request)
    {
        $admin = Admin::find($request->id);

        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', '' . $admin->name . '\'s current password is incorrect!');

        } else {
            if ($request->new_password != $request->password_confirmation) {
                return back()->with('error', '' . $admin->name . '\'s password confirmation doesn\'t match!');

            } else {
                $admin->update([
                    'email' => $request->email,
                    'password' => bcrypt($request->new_password),
                    'role' => $request->role == null ? 'root' : $request->role
                ]);
                return back()->with('success', 'Successfully update ' . $admin->name . '\'s account!');
            }
        }
    }

    public function deleteAdmins($id)
    {
        $admin = Admin::find(decrypt($id));
        if ($admin->ava != '' || $admin->ava != 'avatar.png') {
            Storage::delete('public/admins/ava/' . $admin->ava);
        }
        $admin->forceDelete();

        return back()->with('success', '' . $admin->name . ' is successfully deleted!');
    }

    public function showUsersTable(Request $request)
    {
        if($request->has('q')){
            $find = $request->q;
        } else{
            $find = null;
        }

        $users = User::orderByDesc('id')->get();

        return view('_admins.tables.accounts.user-table', compact('find','users'));
    }

    public function validateUsers(Request $request)
    {
        $user = User::find($request->user_id);
        $user->update([
            'isValid' => $request->isValid,
            'note' => $request->note
        ]);

        event(new UserActivationEmail($user));

        if($user->isValid == false){
            foreach($user->getAttachments as $row){
                Storage::delete('public/users/attachments/' . $row->files);
            }
            $user->forceDelete();

            return redirect()->route('table.users')->with('success', '' . $user->name .
                ' is successfully validated and deleted! The reason behind it is because '.$user->name.
                '\'s graduate certificate and/or transcripts data is invalid!');
        }

        return redirect()->route('table.users')->with('success', '' . $user->name . ' is successfully validated!');
    }

    public function deleteUsers($id)
    {
        $user = User::find(decrypt($id));
        if ($user->ava != '' || $user->ava != 'seeker.png' || $user->ava != 'agency.png') {
            Storage::delete('public/users/ava/' . $user->ava);
        }
        $user->forceDelete();

        $response = app(Credential::class)->getCredentials();
        if ($response['isSync'] == true) {
            $client = new Client([
                'base_uri' => env('SISKA_URI'),
                'defaults' => [
                    'exceptions' => false
                ]
            ]);

            $client->delete(env('SISKA_URI') . '/api/partners/seekers/delete', [
                'form_params' => [
                    'key' => env('SISKA_API_KEY'),
                    'secret' => env('SISKA_API_SECRET'),
                    'email' => $user->email,
                ]
            ]);
        }

        return back()->with('success', '' . $user->name . ' is successfully deleted!');
    }
}
