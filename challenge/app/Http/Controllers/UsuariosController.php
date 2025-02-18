<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\userRolModel;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{

    public function index()
    {
        return view('admin.admin');
    }

    public function deleteUser($id)
    {
        $usuario = User::find($id);
        if ($usuario) {
            $usuario->delete();
            return redirect()->route('admin.users')->with('success', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->route('admin.users')->with('error', 'Usuario no encontrado.');
        }
    }

    public function getUsers(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'search' => 'nullable|string|max:255'
        ])->validate();

        $search = strip_tags($validated['search'] ?? '');


        $usuarios = User::leftJoin('tabla_user_rol', 'users.id', '=', 'tabla_user_rol.user_id')
        ->leftJoin('rol', 'rol.id', '=', 'tabla_user_rol.role_id')
        ->select('users.*')
        ->distinct()
        ->orderBy('users.id', 'desc')
        ->paginate(5);
    
        foreach ($usuarios as $usuario) {
            $usuario->roles = Rol::whereIn('id', function ($query) use ($usuario) {
                $query->select('role_id')
                    ->from('tabla_user_rol')
                    ->where('user_id', $usuario->id);
            })->get();
        }
        
        $roles=Rol::all();
        return view('admin.admin-usuarios', [
            'usuarios' => $usuarios,
            'search' => $search,
            'roles'=>$roles
        ]);
    }


    public function addUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string'
        ]);
        

        $user=User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role']
        ]);
        userRolModel::create([
            'user_id'=>$user->id,
            'role_id'=>$validated['role']
        ]);
        

        return redirect()->route('admin.users')->with('success', 'Usuario creado correctamente.');
    }

    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'roles' => 'required|array|min:1', 
        'roles.*' => 'exists:rol,id',  
    ]);
    
    $user = User::findOrFail($id);
    if ($user) {
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->save();
        $user->roles()->detach();
        $user->roles()->attach($validatedData['roles']);


        return redirect()->route('admin.users')->with('success', 'Usuario modificado correctamente.');
    }

    return redirect()->route('admin.users')->with('error', 'El usuario no fue encontrado.');
}


}
