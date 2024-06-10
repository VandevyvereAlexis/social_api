<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(10);

        return response()->json([
            'status'  => true,
            'message' => 'Posts récupérés avec succès',
            'posts'   => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'content' => $request->content,
            'tags'    => $request['tags'],
            'image'   => isset($request['image']) ? uploadImage($request['image']) : 'user.png',
            'user_id' => Auth::user()->id,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Post créé avec succès',
            'post'    => $post,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if ($post)
        {
            return response()->json([
                'status'  => true,
                'message' => 'Post récupéré avec succès',
                'post'    => $post,
            ]);
        } else
        {
            return response()->json([
                'status'  => false,
                'message' => 'Aucun post trouvé',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());

        if ($request->image)
        {
            $imageName = uploadImage($request['image']);
            $imagePath = 'images/' . $post->image;

            if (File::exists(public_path($imagePath)))
            {
                File::delete(public_path($imagePath));
            }

            $post->update(['image' => $imageName]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Post modifié avec succès',
            'post'    => $post,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        $imagePath = 'images/' . $post->image;

        if (File::exists(public_path($imagePath)))
        {
            File::delete(public_path($imagePath));
        }

        return response()->json([
            'status'  => true,
            'message' => 'Post supprimé avec succès',
        ]);
    }
}
