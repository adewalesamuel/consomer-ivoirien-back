<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use Illuminate\Support\Str;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'success' => true,
            'notifications' => Notification::where('id', '>', -1)
            ->orderBy('created_at', 'desc')->get()
        ];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $request)
    {
        $validated = $request->validated();

        $notification = new Notification;

        $notification->titre = $validated['titre'] ?? null;
		$notification->contenu = $validated['contenu'] ?? null;
		$notification->utilisateur_id = $validated['utilisateur_id'] ?? null;
		
        $notification->save();

        $data = [
            'success'       => true,
            'notification'   => $notification
        ];
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        $data = [
            'success' => true,
            'notification' => $notification
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $validated = $request->validated();

        $notification->titre = $validated['titre'] ?? null;
		$notification->contenu = $validated['contenu'] ?? null;
		$notification->utilisateur_id = $validated['utilisateur_id'] ?? null;
		
        $notification->save();

        $data = [
            'success'       => true,
            'notification'   => $notification
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {   
        $notification->delete();

        $data = [
            'success' => true,
            'notification' => $notification
        ];

        return response()->json($data);
    }
}