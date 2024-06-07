<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);

        return response()->json([
            'status'  => true,
            'message' => 'Utilisateurs récupérés avec succès',
            'users'   => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'pseudo'   => $request['pseudo'],
            'email'    => $request['email'],
            'image'    => isset($request['image']) ? uploadImage($request['image']) : 'user.png',
            'password' => Hash::make($request['password']),
        ]);

        return response()->json([
            'status'   => true,
            'message'  => 'Utilisateur créé avec succès',
            'user'     => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user)
        {
            return response()->json([
                'status'  => true,
                'message' => 'Utilisateur récupéré avec succès',
                'user'    => $user->load('posts'),
            ]);
        } else
        {
            return response()->json([
                'status'  => false,
                'message' => 'Aucun utilisateur trouvé',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function Update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());

        if ($request->image)
        {
            $imageName = uploadImage($request['image']);
            $imagePath = 'images/' . $user->image;

            if (File::exists(public_path($imagePath)))
            {
                File::delete(public_path($imagePath));
            }

            $user->update(['image' => $imageName]);
        }

        if ($request->password)
        {
            if ($request->oldPassword && Hash::check($request->oldPassword, User::find($user->id)->password))
            {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'error'  => 'mot de passe actuel non renseigné ou incorrect',
                    'user'   => $user
                ], 400);
            }
        }

        return response()->json([
            'status'  => true,
            'message' => 'Utilisateur mis à jour avec succès',
            'user'    => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        $imagePath = 'images/' . $user->image;

        if (File::exists(public_path($imagePath)))
        {
            File::delete(public_path($imagePath));
        }

        return response()->json([
            'status'  => true,
            'message' => 'Utilisateur supprimé avec succès',
        ]);
    }
}
