@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.timekeeping.actions.index'))

@section('body')

    <timekeeping-listing
        :data="{{ $data->toJson() }}"
        :projects="{{ $projects->toJson() }}"
        :users="{{ $users->toJson() }}"
        :url="'{{ url('admin/timekeepings') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.timekeeping.actions.index') }}
                        @if(!$is_admin)
                            <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/timekeepings/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.timekeeping.actions.create') }}</a>
                        @endif
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">
                                            
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'">{{ trans('admin.timekeeping.columns.id') }}</th>
                                        <th is='sortable' :column="'project_id'">{{ trans('admin.timekeeping.columns.project_id') }}</th>
                                        <th is='sortable' :column="'user_id'">{{ trans('admin.timekeeping.columns.user_id') }}</th>
                                        <th is='sortable' :column="'start_date'">{{ trans('admin.timekeeping.columns.start_date') }}</th>
                                        <th is='sortable' :column="'minutes'">{{ trans('admin.timekeeping.columns.minutes') }}</th>
                                        <th>Status</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="7">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/timekeepings')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/timekeepings/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>

                                        <td>@{{ item.id }}</td>
                                        <td>@{{ projects.find(p => p.id == item.project_id).name }}</td>
                                        <td>@{{ users.find(u => u.id == item.user_id).full_name }}</td>
                                        <td>@{{ item.start_date | datetime }}</td>
                                        <td>@{{ item.minutes }}</td>
                                        
                                        <td>
                                            <span class="badge badge-success px-2 py-1 text-white" v-if="item.status == 'approved'">Approved</span>
                                            <span class="badge badge-danger px-2 py-1 text-white" v-else-if="item.status == 'rejected'">Rejected</span>
                                            <span class="badge badge-info px-2 py-1 text-white" v-else>Pending</span>
                                        </td>
                                        
                                        <td>
                                            <div class="row no-gutters">
                                                @if($is_admin)
                                                    <form class="col" :action="item.resource_url + '/approve'" method="post" v-if="item.status == 'pending'">
                                                        @csrf
                                                        @method('put')

                                                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-thumbs-up"></i></button>
                                                    </form>

                                                    <form class="col" :action="item.resource_url + '/reject'" method="post" v-if="item.status == 'pending'">
                                                        @csrf
                                                        @method('put')

                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-thumbs-down"></i></button>
                                                    </form>
                                                @else
                                                    <div class="col-auto" v-if="item.status == 'pending'">
                                                        <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                    </div>

                                                    <form class="col" @submit.prevent="deleteItem(item.resource_url)" v-if="item.status == 'pending'">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/timekeepings/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.timekeeping.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </timekeeping-listing>

@endsection