<?php

namespace App\Http\Controllers\Api;

use App\Model\Anniv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AnnivController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $request->validate([
            'group_id' => 'exists:groups,id',
        ]);
        $annivs = Anniv::orderBy('id');
        if($request->has('group_id')) {
            $annivs = $annivs->where('group_id', $request->group_id);
        }

        return $annivs->get();
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|max:128',
            'desc' => 'string|max:255',
            'anniv_at' => 'required|date_format:Y-m-d',
            'group_id' => 'required|exists:groups,id',
        ]);

        // 名前指定なし
        $name = $request->input('name', 'no name');

        $anniv = new Anniv;
        $anniv->user_id = auth()->user()->id;
        $anniv->name = $name;
        $anniv->desc = $request->desc;
        $anniv->anniv_at = $request->anniv_at;
        if($request->has('group_id'))
            $anniv->group_id = $request->group_id;
        $anniv->save();

        return $anniv;
    }


    public function show(Anniv $anniv)
    {
        return $anniv;
    }


    public function update(Request $request, Anniv $anniv)
    {
        $request->validate([
            'name' => 'required|string|max:128',
            'desc' => 'string|max:255',
            'anniv_at' => 'required|date_format:Y-m-d',
            'group_id' => 'exists:groups,id',
        ]);

        $anniv->name = $request->name;
        $anniv->desc = $request->desc;
        $anniv->anniv_at = $request->anniv_at;
        if($request->has('group_id'))
            $anniv->group_id = $request->group_id;
        else
            $anniv->group_id = 0;
        $anniv->save();

        return $anniv;
    }


    public function destroy(Anniv $anniv)
    {
        $anniv->delete();
        return [];
    }
}
