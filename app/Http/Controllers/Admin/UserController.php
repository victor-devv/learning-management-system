<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Mentee;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Actions\Fortify\CreateNewUser;

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
        return view('admin.users.create', [
            'roles' => Role::all(),
            'mentors' => Mentor::all(),
            'mentees' => Mentee::all()
        ]);
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

        $newUser = new CreateNewUser();

        $user = $newUser->create(array_merge($request->only('first-name', 'last-name', 'email', 'password', 'password_confirmation'), ['msisdn' => null]));

        //Add mentor
        if (in_array('3', $request->roles)) {

            $mentor = Mentor::create([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'user_id' => $user->id
            ]);

            if ($request->mentees) {
                $mentor->mentees()->sync($request->mentees);
            }
        } else if (in_array('4', $request->roles)) {

            $mentee = Mentee::create([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'user_id' => $user->id,
                'mentor_id' => $request['mentor']
            ]);
        }

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
        $mentor = Mentor::where('user_id', $id)->first();
        $mentee = Mentee::where('user_id', $id)->first();

        if ($mentor) {
            return view(
                'admin.users.edit',
                [
                    'roles' => Role::all(),
                    'user' => User::find($id),
                    'mentor' => $mentor,
                ]
            );
        } else if ($mentee) {
            return view(
                'admin.users.edit',
                [
                    'roles' => Role::all(),
                    'user' => User::find($id),
                    'mentee' => $mentee,
                ]
            );
        }

        return view('admin.users.edit',
            [
                'roles' => Role::all(),
                'user' => User::find($id),
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

        if (in_array('3', $request->roles)) {

            $mentor = Mentor::where('user_id', $id)->update([
                'first_name' => $request['first-name'],
                'last_name' => $request['last_name'],
            ]);

            if ($request->mentees) {
                $mentor->mentees()->sync($request->mentees);
            }
        } else if (in_array('4', $request->roles)) {
            Mentee::where('user_id', $id)->update([
                'first_name' => $request['first-name'],
                'last_name' => $request['last_name'],
                'mentor_id' => $request['mentor']
            ]);
        }

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
