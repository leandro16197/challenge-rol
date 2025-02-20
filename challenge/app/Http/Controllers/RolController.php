<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RolController extends Controller
{
    // Muestra la lista de roles, con la posibilidad de filtrarlos por nombre
    public function index(Request $request){
        
        $validated = Validator::make($request->all(), [
            'search' => 'nullable|string|max:255'
        ])->validate();

        $search = strip_tags($validated['search'] ?? '');

        $roles = Rol::where('name', 'like', '%' . $search . '%')
        ->orderBy('id', 'desc')
        ->paginate(5);

        return view('admin.roles', [
            'roles' => $roles,
            'search' => $search,
        ]);
        

    }  

    // Crea un nuevo rol con el nombre y descripción  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        Rol::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.roles')->with('success', 'Rol agregado exitosamente.');
    }

    // Modifica el rol especificado por su ID
    public function update(Request $request, $id)
    {
        $role = Rol::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.roles')->with('success', 'Rol modificado exitosamente.');
    }
    
    // Elimina el rol especificado por su ID
    public function destroy($id)
    {
        $role = Rol::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles')->with('success', 'Rol eliminado exitosamente.');
    }
    
}
