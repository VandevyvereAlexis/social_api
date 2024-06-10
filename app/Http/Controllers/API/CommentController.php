<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CommentController extends Controller
{
    // "except(')" -> pas besoin d'être connecté pour ..
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::paginate(10);

        return response()->json([
            'status'   => true,
            'message'  => 'Commentaires récupérés avec succès',
            'comments' => $comments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->all());

        if ($request->image)
        {
            $imageName = uploadImage($request['image']);
            $comment->update(['image' => $imageName]);
        }

        return response()->json([
            'status'   => true,
            'message'  => 'commentaire créé avec succès',
            'comments' => $comment,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        if ($comment)
        {
            return response()->json([
                'status'  => true,
                'message' => 'Commentaire récupéré avec succès',
                'comment' => $comment,
            ]);
        } else
        {
            return response()->json([
                'status'  => false,
                'message' => 'Commentaire non trouvé',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->all());

        if ($request->image)
        {
            $imageName = uploadImage($request['image']);
            $imagePath = 'images/' . $comment->image;

            if (File::exists(public_path($imagePath)))
            {
                File::delete(public_path($imagePath));
            }

            $comment->update(['image' => $imageName]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Commentaire modifié avec succès',
            'comment' => $comment,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        $imagePath = 'images/' . $comment->image;

        if (File::exists(public_path($imagePath)))
        {
            File::delete(public_path($imagePath));
        }

        return response()->json([
            'status'  => true,
            'message' => 'Commentaire supprimé avec succès',
        ]);
    }
}
