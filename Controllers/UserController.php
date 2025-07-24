<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserDataRequest;
use App\Traits\SavesUserData;
use App\Enums\UserType;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use SavesUserData;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if(auth()->user()->isAdmin()) {
            $users = User::where('status', '1')->get();
            return view('users.index', compact('users'));
        } else {
            return view('auth.restricted');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->isAdmin()) {
            $user_types = UserType::cases();
            return view('users.form', compact('user_types'));
        } else {
            return view('auth.restricted');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserDataRequest $request)
    {
        if(auth()->user()->isAdmin()) {
            $this->saveUser($request->validated());
            return redirect()->route('users.index')->with('success', 'User created successfully');
        } else {
            return view('auth.restricted');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(auth()->user()->isAdmin()) {
            $user = User::find($id);
            if(isset($user->id) && $user->status != '0') {
                return view('users.view', compact('user'));
            } else {
                return redirect()->route('users.index')->with('error', "This user is no longer available"); 
            }
        } else {
            return view('auth.restricted');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->isAdmin() || (auth()->id() == $id)) {
            $user = User::find($id);
            if(isset($user->id) && $user->status != '0') {
                $user_types = UserType::cases();
                return view('users.form', compact('user', 'user_types'));
            } else {
                if(auth()->user()->isAdmin()) {
                    return redirect()->route('users.index')->with('error', "This user is no longer available"); 
                } else {
                    return view('auth.restricted');
                }
            }
        } else {
            return view('auth.restricted');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserDataRequest $request, User $user)
    {
        if(isset($user->id) && (auth()->user()->isAdmin() || (auth()->id() == $user->id))) {
            if($user->status != '0') {
                $this->saveUser($request->validated(), $user);
                if(auth()->user()->isAdmin()) {
                    return redirect()->route('users.index')->with('success', 'User updated successfully');
                } else {
                    return redirect()->route('users.edit', $user->id)->with('success', 'Updated your profile successfully');
                }
            } else {
                if(auth()->user()->isAdmin()) {
                    return redirect()->route('users.index')->with('error', "This user is no longer available"); 
                } else {
                    return view('auth.restricted');
                }
            }
        } else {
            return view('auth.restricted');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->isAdmin()) {
            $user = User::find($id);
            if(isset($user->id) && $user->status != '0') {
                $user->status = '0';
                $user->save();
                return redirect()->route('users.index')->with('success', 'User deleted successfully');
            } else {
                return redirect()->route('users.index')->with('error', "This user is no longer available");  
            }
        } else {
            return view('auth.restricted');
        }
    }
}
