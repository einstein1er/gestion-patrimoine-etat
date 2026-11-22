<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json(Notification::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'utilisateur_id' => ['required', 'integer'],
            'titre' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['nullable', 'string', 'max:255'],
            'lue' => ['nullable', 'boolean'],
        ]);

        $notification = Notification::create($data);

        return response()->json($notification, 201);
    }

    public function show($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json([
                'message' => 'Notification introuvable'
            ], 404);
        }

        return response()->json($notification);
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json([
                'message' => 'Notification introuvable'
            ], 404);
        }

        $data = $request->validate([
            'utilisateur_id' => ['sometimes', 'integer'],
            'titre' => ['sometimes', 'string', 'max:255'],
            'message' => ['sometimes', 'string'],
            'type' => ['nullable', 'string', 'max:255'],
            'lue' => ['nullable', 'boolean'],
        ]);

        $notification->update($data);

        return response()->json($notification);
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json([
                'message' => 'Notification introuvable'
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'message' => 'Notification supprimée'
        ]);
    }
}
