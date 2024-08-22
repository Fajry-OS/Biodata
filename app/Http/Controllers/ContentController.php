<?php

//Buat Controller Web CV

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Experience;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = Profile::where('status', 1)->first(); //kalo first satu data yang ditampilikan
        $id = $profile->id;
        $experience = Experience::where('id_profile', $id)->get(); //Kalo get ambil data berdasarkan id Profile
        // $experience = Experience::where('id_profile', $profile->id)->get();
        return view('compro.index', compact(['profile', 'experience']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
