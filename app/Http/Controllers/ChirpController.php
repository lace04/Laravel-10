<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations;

class ChirpController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('chirps.index', [
      'chirps' => Chirp::with('user')->latest()->get()
    ]);
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
    //Validate
    $validated = $request->validate([
      'message' => 'required|string|max:225|min:3'
    ]);

    $request->user()->chirps()->create($validated);

    //Insert into db
    // Chirp::create([
    //   'message' => $request->get('message'),
    //   'user_id' => auth()->id()
    // ]);

    return to_route('chirps.index')
      ->with('status', __('Chirp created successfully!'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Chirp $chirp)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Chirp $chirp)
  {
    //Autorization
    $this->authorize('update', $chirp);

    return view('chirps.edit', [
      'chirp' => $chirp
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Chirp $chirp)
  {
    //Autorization
    $this->authorize('update', $chirp);

    //Validate
    $validated = $request->validate([
      'message' => 'required|string|max:225|min:3'
    ]);

    $chirp->update($validated);

    return to_route('chirps.index')
      ->with('status', __('Chirp updated successfully!'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Chirp $chirp)
  {
    //Autorization
    $this->authorize('delete', $chirp);

    $chirp->delete();

    return to_route('chirps.index')
      ->with('status', __('Chirp deleted successfully!'));
  }
}
