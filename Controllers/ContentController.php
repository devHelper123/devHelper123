<?php

namespace App\Http\Controllers;
use App\Models\Content;
use App\Models\User;
use App\Enums\UserType;
use App\Traits\SaveContentData;
use App\Http\Requests\ContentRequest;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    use SaveContentData;
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
            $contents = Content::all();
            return view('content.index', compact('contents'));
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
            $users = User::where('status', '1')
                ->where('user_type', 'client')
                ->get();
            $assigned_users = array();
            return view('content.form', compact('users', 'assigned_users'));
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
    public function store(ContentRequest $request)
    {
        $this->saveContent($request->validated());
        return redirect()->route('contents.index')->with('success', 'Content created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assigned_contents = auth()->user()->contents->pluck('id')->toArray();
        if (auth()->user()->isAdmin() || (in_array($id, $assigned_contents))) {
            $content = Content::find($id);
            if(isset($content->id)) {
                $assigned_users = $content->users->pluck('name')->toArray();
                return view('content.view', compact('content', 'assigned_users'));
            } else {
                if(auth()->user()->isAdmin()) {
                    return redirect()->route('contents.index')->with('error', "This content is no longer available"); 
                } else {
                    return view('auth.restricted');
                }
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
        if(auth()->user()->isAdmin()) {
            $content = Content::find($id);
            if(isset($content->id)) {
                $users = User::where('status', '1')
                    ->where('user_type', 'client')
                    ->get();
                $assigned_users = $content->users->pluck('id')->toArray();
                return view('content.form', compact('content', 'users', 'assigned_users'));
            } else {
                return redirect()->route('contents.index')->with('error', "This content is no longer available");  
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
    public function update(ContentRequest $request, Content $content)
    {
        if (auth()->user()->isAdmin()) {
            $this->saveContent($request->validated(), $content);
            return redirect()->route('contents.index')->with('success', 'Content updated successfully');
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
        if (auth()->user()->isAdmin()) {
            $content = Content::find($id);
            if(isset($content->id)) {
                $content->users()->detach();
                $content->delete();
                return redirect()->route('contents.index')->with('success', 'Content deleted successfully');
            } else {
                return redirect()->route('contents.index')->with('error', "This content is no longer available");  
            }
        } else {
            return view('auth.restricted');
        }
    }
}
