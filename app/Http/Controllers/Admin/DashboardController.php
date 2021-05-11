<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUser\IndexAdminUser;
use App\Models\Timekeeping;
use Brackets\AdminAuth\Models\AdminUser;
use Carbon\Carbon;
use Facade\FlareClient\Time\Time;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class DashboardController extends Controller
{

    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'admin';

    /**
     * AdminUsersController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guard = config('admin-auth.defaults.guard');
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexAdminUser $request
     * @return Factory|View
     */
    public function employee(IndexAdminUser $request)
    {
        $data = Timekeeping::query()
            ->where('user_id', auth()->id())
            ->get()
            ->map(static function (Timekeeping $data) {
                $data->day = Carbon::parse($data->start_date)->format('d/m/Y');

                return $data;
            })
            ->groupBy('day')
            ->map(static function ($data) {
                return $data->sum('minutes');
            });

        $avg = Timekeeping::query()
            ->get()
            ->map(static function (Timekeeping $data) {
                $data->day = Carbon::parse($data->start_date)->format('d/m/Y');
                
                return $data;
            })
            ->groupBy('day')
            ->map(static function ($data) {
                $data = $data
                    ->map(static function (Timekeeping $data) {
                        $data->day = Carbon::parse($data->start_date)->format('d/m/Y');
        
                        return $data;
                    })
                    ->groupBy('user_id')
                    ->map(static function ($data) {
                        return $data->sum('minutes');
                    });
                
                return $data->avg();
            });

        return view('admin.dashboard.employee', [
            'my' => $data,
            'avg' => $avg
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexAdminUser $request
     * @return Factory|View
     */
    public function admin(IndexAdminUser $request)
    {
        $data = Timekeeping::query()
            ->get()
            ->groupBy('user_id')
            ->map(static function ($data) {
                $data = $data
                    ->map(static function (Timekeeping $data) {
                        $data->day = Carbon::parse($data->start_date)->format('d/m/Y');
        
                        return $data;
                    })
                    ->groupBy('day')
                    ->map(static function ($data) {
                        return $data->sum('minutes');
                    });
                
                return $data;
            });

        $avg = Timekeeping::query()
            ->get()
            ->map(static function (Timekeeping $data) {
                $data->day = Carbon::parse($data->start_date)->format('d/m/Y');
                
                return $data;
            })
            ->groupBy('day')
            ->map(static function ($data) {
                $data = $data
                    ->groupBy('user_id')
                    ->map(static function ($data) {
                        return $data->sum('minutes');
                    });
                
                return $data->avg();
            });

        return view('admin.dashboard.admin', [
            'my' => $data,
            'avg' => $avg,
            'users' => AdminUser::all()
        ]);
    }
}
