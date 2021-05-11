<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Timekeeping\BulkDestroyTimekeeping;
use App\Http\Requests\Admin\Timekeeping\DestroyTimekeeping;
use App\Http\Requests\Admin\Timekeeping\IndexTimekeeping;
use App\Http\Requests\Admin\Timekeeping\StoreTimekeeping;
use App\Http\Requests\Admin\Timekeeping\UpdateTimekeeping;
use App\Models\Project;
use App\Models\Timekeeping;
use App\Models\User;
use Brackets\AdminAuth\Models\AdminUser;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TimekeepingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTimekeeping $request
     * @return array|Factory|View
     */
    public function index(IndexTimekeeping $request)
    {
        $is_admin = !auth()->user()->hasRole('Employee');
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Timekeeping::class);
        
        if (!$is_admin) {
            $data->modifyQuery(function ($query) {
                return $query->where('user_id', auth()->id());
            });
        }
        
        $data = $data->processRequestAndGet(
            // pass the request with params
            $request,
            // set columns to query
            ['id', 'project_id', 'user_id', 'start_date', 'minutes', 'status'],
            // set columns to searchIn
            ['id', 'task', 'description', 'location']
        );

      

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.timekeeping.index', [
            'data' => $data, 
            'projects' => Project::all(), 
            'users' => AdminUser::all(),
            'is_admin' => $is_admin
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.timekeeping.create', [
            'users' => AdminUser::all(),
            'projects' => Project::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTimekeeping $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTimekeeping $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitized = array_merge($sanitized, [
            'project_id' => $sanitized['project_id']['id'],
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);

        // Store the Timekeeping
        $timekeeping = Timekeeping::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/timekeepings'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/timekeepings');
    }

    /**
     * Display the specified resource.
     *
     * @param Timekeeping $timekeeping
     * @throws AuthorizationException
     * @return void
     */
    public function show(Timekeeping $timekeeping)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Timekeeping $timekeeping
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Timekeeping $timekeeping)
    {
        return view('admin.timekeeping.edit', [
            'timekeeping' => $timekeeping,
            'users' => AdminUser::all(),
            'projects' => Project::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTimekeeping $request
     * @param Timekeeping       $timekeeping
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTimekeeping $request, Timekeeping $timekeeping)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();


        $sanitized = array_merge($sanitized, [
            'project_id' => $sanitized['project_id']['id'],
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);


        // Update changed values Timekeeping
        $timekeeping->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/timekeepings'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/timekeepings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTimekeeping $request
     * @param Timekeeping        $timekeeping
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTimekeeping $request, Timekeeping $timekeeping)
    {
        $timekeeping->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTimekeeping $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTimekeeping $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Timekeeping::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function approve(Timekeeping $timekeeping)
    {
        $timekeeping->status = 'approved';
        $timekeeping->save();

        return redirect()->back();
    }

    public function reject(Timekeeping $timekeeping)
    {
        $timekeeping->status = 'rejected';
        $timekeeping->save();

        return redirect()->back();
    }
}
