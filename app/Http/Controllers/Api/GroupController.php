<?php

namespace App\Http\Controllers\Api;

use App\Model\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return Group::orderBy('id')->get();
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:128',
            'desc' => 'string|max:255',
        ]);

        $group = new Group;
        $group->user_id = auth()->user()->id;
        $group->name = $request->name;
        $group->desc = $request->desc;
        $group->save();

        return $group;
    }


    public function show(Group $group)
    {
        return $group;
    }


    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:128',
            'desc' => 'string|max:255',
        ]);

        $group->name = $request->name;
        $group->desc = $request->desc;
        $group->save();

        return $group;
    }


    public function destroy(Group $group)
    {
        $group->delete();
        return [];
    }
}
