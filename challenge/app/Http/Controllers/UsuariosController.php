<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\userRolModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{

    // Muestra la vista principal de administración
    public function index()
    {
        return view('admin.admin');
    }

    // Obtiene y lista los usuarios, con la posibilidad de filtrarlos por nombre y mostrar sus roles asociados
    public function getUsers(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'search' => 'nullable|string|max:255'
        ])->validate();
    
        $search = strip_tags($validated['search'] ?? '');
    
        $query = User::query();
    
        if ($search) {
            $query->where('users.name', 'like', '%' . $search . '%');
        }
    
        $totalUsuarios = $query->count();
    

        $usuarios = $query->leftJoin('user_rol', 'users.id', '=', 'user_rol.user_id')
            ->leftJoin('rol', 'rol.id', '=', 'user_rol.role_id')
            ->select('users.*')
            ->distinct()
            ->orderBy('users.id', 'desc')
            ->paginate(5);
              
       
        $roles = Rol::all();
        return view('admin.admin-usuarios', [
            'usuarios' => $usuarios,
            'search' => $search,
            'roles' => $roles,
            'totalUsuarios' => $totalUsuarios
        ]);
    }
    

    // Valida y crea un nuevo usuario, asignándole un rol
    public function addUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string'
        ]);


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role']
        ]);
        userRolModel::create([
            'user_id' => $user->id,
            'role_id' => $validated['role']
        ]);


        return redirect()->route('admin.users')->with('success', 'Usuario creado correctamente.');
    }

    // Modifica el usuario que recibe por parámetros
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $user = User::findOrFail($id);
        if ($user) {
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }
            $user->save();

            return redirect()->route('admin.users')->with('success', 'Usuario modificado correctamente.');
        }

        return redirect()->route('admin.users')->with('error', 'El usuario no fue encontrado.');
    }

    // Elimina un usuario por su ID, pero evita eliminar la cuenta del usuario actual
    public function deleteUser($id)
    {
        if ( Auth::user()->id == $id) {
            return redirect()->route('admin.users')->with('error', 'No puedes eliminar tu propia cuenta.');
        }
    
        $usuario = User::find($id);
    
        if ($usuario) {
            $usuario->delete();
            return redirect()->route('admin.users')->with('success', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->route('admin.users')->with('error', 'Usuario no encontrado.');
        }
    }

    // Asocia un rol a un usuario si no lo tiene 
    public function agregarRol(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->roles()->where('role_id', $request->role_id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'El usuario ya tiene este rol'
            ]);
        }
        $user->roles()->attach($request->role_id);

        return response()->json([
            'success' => true,
            'message' => 'Rol agregado correctamente',
            'role' => [
                'id' => $request->role_id,
                'name' => $user->roles()->find($request->role_id)->name
            ]
        ]);
    }
    
    // Elimina un rol asignado a un usuario
    public function eliminarRol($id, $role_id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach($role_id);
        return response()->json(['success' => true, 'message' => 'Rol eliminado correctamente']);
    }
}
