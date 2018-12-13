<?php

namespace App\Http\Controllers\App;

use Exception;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Traits\PaginationTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ErrorFlashMessagesTrait;

class NotificationsController extends Controller
{
    use ErrorFlashMessagesTrait, PaginationTrait;

    /**
     * NotificationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax')->only(['viewedAjax']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notifications = Auth::user()->notifications->sortByDesc('created_at');
        foreach($notifications as $notification)
        {
            $notification->viewed = true;
            $notification->save();
            //$notification->update(['viewed' => true]);
        }
        $this->paginate($request, $notifications, 10, 3);
        $paginationTools = $this->paginationTools;
        return view('app.notifications.index', compact('paginationTools'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $language
     * @param Notification $notification
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $language, Notification $notification)
    {
        try
        {
            if($notification->authorised)
            {
                $notification->delete();
                info_flash_message(trans('auth.info'),
                    trans('general.delete_successful', ['name' => trans('general.notifications') . ': ' .$notification->details]));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }
        return back();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewedAjax()
    {
        $notifications = Auth::user()->notifications->sortByDesc('created_at');
        $notifications->splice(4);
        $visible_notifications = $notifications->all();
        foreach($visible_notifications as $notification)
        {
            $notification->viewed = true;
            $notification->save();
            //$notification->update(['viewed' => true]);
        }
        return response()->json();
    }
}
