<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Group;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard() {

        $groups = Group::orderBy('id')
            ->where('user_id', auth()->user()->id)
            ->has('annivs')
            ->with('annivs')
            ->get();

        // days_next でソート
        foreach ($groups as $key => $group) {
            $annivs = $group->annivs->sortBy('days_next');
            unset($group->annivs);
            $group->annivs = array_values($annivs->toArray());
        }

        return $groups;
    }
}
