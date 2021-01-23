<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        if (Gate::denies('logged-in')) {
            dd('unauthorized');
        }
        $users = User::paginate(10);
        // dd($users);

        return view('admin.users.index')->with(
            [
                'users' => $users
            ]
        );
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create', ['roles' => Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // dd($request);

        // if ($request->msisdn) {
        //     $user = User::create([
        //         'first_name' => $request['first-name'],
        //         'last_name' => $request['last-name'],
        //         'msisdn' => $request['msisdn'],
        //         'email' => $request['email'],
        //         'password' => $request['password']
        //     ]);

        //     $user->roles()->sync($request->roles);

        //     session()->flash('success', 'User Created Successfully!');

        //     return redirect(route('admin.users.index'));

        // }

        // $user = User::create([
        //     'first_name' => $request['first-name'],
        //     'last_name' => $request['last-name'],
        //     'email' => $request['email'],
        //     'password' => $request['password']
        // ]);

        $newUser = new CreateNewUser();

        $user = $newUser->create(array_merge($request->only('first-name', 'last-name', 'email', 'password', 'password_confirmation'), ['msisdn' => null]));

        $user->roles()->sync($request->roles);

        session()->flash('success', 'User Created Successfully!');

        return redirect(route('admin.users.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.users.edit',
            [
                'roles' => Role::all(),
                'user' => User::find($id)
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findorFail($id);

        if (!$user) {
            session()->flash('failure', 'You cannot edit this user!');
            return redirect(route('admin.users.index'));
        }

        $data = $request->only(['first-name', 'last-name', 'email']);

        if ($request->roles) {
            $user->roles()->sync($request->roles);
        }

        $user->update($data);

        session()->flash('success', 'User Updated Successfully!');

        return redirect(route('admin.users.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        User::destroy($id);

        session()->flash('success', 'User Deleted Successfully!');

        return redirect(route('admin.users.index'));
    }


}
