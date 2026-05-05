<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'fst_name' => 'required|string|max:255',
            'sur_name' => 'required|string|max:255',
        ]);
        User::create([
            'fst_name'   => $request->fst_name,
            'sur_name'   => $request->sur_name,
            'birth_date' => now()->toDateString(),
        ]);
        return back()->with('success', 'Utilizador adicionado.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Utilizador removido.');
    }
}
