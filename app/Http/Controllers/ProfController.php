<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Experience;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;


class ProfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Select * From profiles
        $profiles = Profile::all();
        return view('admin.profile.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_lengkap' => 'required|string|max:55',
            'no_telpon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255',
            'deskripsi' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'alamat' => 'nullable|string|max:250',
        ]);

        //Menghandle file upload
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $path = $image->store('public/image');
            $name = basename($path); //menyimpan file saja
        }

        //Insert into profiles () values ():
        Profile::create([
            'picture' => $name,
            'nama_lengkap' => $request->nama_lengkap,
            'no_telpon' => $request->no_telpon,
            'email' => $request->email,
            'deskripsi' => $request->deskripsi,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('profile.index')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Print PDF
        $data = Profile::findOrFail($id);
        $idprofile = $data->id;
        $experience = Experience::where('id_profile', $idprofile)->get();

        $pdf = Pdf::loadView('admin.generate-pdf.index', compact(['data', 'experience']));
        return $pdf->download('Portofolio.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $profile = Profile::findOrFail($id);
        return view('admin.profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $profile = Profile::findOrFail($id);
        $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_lengkap' => 'required|string|max:55',
            'no_telpon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255',
            'deskripsi' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'alamat' => 'nullable|string|max:250',
        ]);

        //Simpan gambar jika di upload
        if ($request->hasFile('picture')) {
            //hapus gambar lama jika ada
            if ($profile->picture) {
                Storage::delete('public/image/' . $profile->picture);
            }
            $image = $request->file('picture');
            $path = $image->store('public/image');
            $name = basename($path); //menyimpan file saja
            $profile->picture = $name;
        }
        $profile->nama_lengkap = $request->nama_lengkap;
        $profile->no_telpon = $request->no_telpon;
        $profile->email = $request->email;
        $profile->facebook = $request->facebook;
        $profile->twitter = $request->twitter;
        $profile->linkedin = $request->linkedin;
        $profile->instagram = $request->instagram;
        $profile->deskripsi = $request->deskripsi;
        $profile->save();

        return redirect()->route('profile.index')->with('success', 'Update Profile berhasil');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profile = Profile::withTrashed()->findOrFail($id);
        if ($profile->picture) {
            Storage::delete('public/image/' . $profile->picture);
        }

        $profile->forceDelete();
        return redirect()->route('profile.index')->with('success', 'Delete berhasil');
    }

    public function softDelete(string $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return redirect()->route('profile.index')->with('success', 'Data berhasil di delete sementara');
    }

    public function update_status($id): JsonResponse
    {
        try {
            $profile = Profile::findOrFail($id);

            // Update status for the specified profile
            $profile->status = 1;
            $profile->save();

            // Reset status for all other profiles
            Profile::where('id', '!=', $id)->update(['status' => 0]);

            // Return a successful response
            return response()->json(['success' => 'Status berhasil diubah'], 200);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui status'], 500);
        }
    }

    public function recycle()
    {
        $profiles = Profile::onlyTrashed()->paginate(15);
        return view('admin.profile.recycle', compact('profiles'));
    }

    public function restore($id)
    {
        $profile = Profile::withTrashed()->findOrFail($id);
        $profile->restore();
        return redirect()->route('profile.index')->with('success', 'Data berhasil di restore');
    }
}
