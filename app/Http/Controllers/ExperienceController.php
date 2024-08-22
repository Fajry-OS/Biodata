<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $experiences = Experience::all();
        return view('admin.experience.index', compact('experiences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profile = Profile::all();
        return view('admin.experience.create', compact('profile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_profile' => 'required|string|max:55',
            'judul' => 'required|string|max:55',
            'subjudul' => 'required|string|max:15',
            'tgl_experience' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);
        Experience::create([
            'id_profile' => $request->id_profile,
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'tgl_experience' => $request->tgl_experience,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('experience.index')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Experience $experience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        //
    }
}
