<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PetController extends Controller
{
    public function index()
    {
        $pets = Http::get('https://petstore.swagger.io/v2/pet/findByStatus', [
            'status' => 'available'
        ])->json();

        if (empty($pets)) {
            return view('pets.index', ['pets' => []]);
        }

        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'status' => 'required',
        ]);

        try {
            $response = Http::post('https://petstore.swagger.io/v2/pet', [
                'name' => $validated['name'],
                'status' => $validated['status'],
            ]);

            if ($response->successful()) {
                return redirect()->route('pets.index')->with('success', 'Pet has been added.');
            } else {
                return back()->withErrors('Failed to add pet. Please try again.');
            }
        } catch (\Exception $e) {
            return back()->withErrors('Server connection error. Please try again.');
        }
    }

    public function edit($id)
    {
        $response = Http::get("https://petstore.swagger.io/v2/pet/{$id}");

        if ($response->status() != 200) {  
            return redirect()->route('pets.index')->with('error', "Pet with ID {$id} not found.");
        }

        $pet = $response->json();
        if (!$pet) {
            return redirect()->route('pets.index')->with('error', 'This ID isn\'t working or pet not found.');
        }
        return view('pets.edit', compact('pet'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:available,unavailable',
        ]);

        $response = Http::get('https://petstore.swagger.io/v2/pet/' . $id);

        if ($response->status() != 200) {
            return redirect()->route('pets.index')->with('error', 'This ID isn\'t working or pet not found.');
        }

        $updateResponse = Http::asForm()->post('https://petstore.swagger.io/v2/pet/' . $id, [
            'name' => $validated['name'],
            'status' => $validated['status'],
        ]);

        if ($updateResponse->status() == 200) {
            return redirect()->route('pets.index')->with('success', 'Pet updated successfully!');
        } else {
            return redirect()->route('pets.index')->with('error', 'Error updating the pet.');
        }
    }

    public function destroy($id)
    {
        $response = Http::delete("https://petstore.swagger.io/v2/pet/{$id}");

        if ($response->successful()) {
            return redirect()->route('pets.index')->with('success', 'Pet deleted successfully!');
        } else {
            return back()->withErrors('Error deleting the pet.');
        }
    }
}
