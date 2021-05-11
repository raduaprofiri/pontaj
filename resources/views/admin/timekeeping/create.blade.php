@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.timekeeping.actions.create'))

@section('body')
    <div class="container-xl">
        <div class="card">
            <timekeeping-form
                :action="'{{ url('admin/timekeepings') }}'"
                v-cloak
                inline-template
                :users="{{ $users->toJson() }}"
                :projects="{{ $projects->toJson() }}"
            >
                <form
                    class="form-horizontal form-create"
                    method="post"
                    @submit.prevent="onSubmit"
                    :action="action"
                    novalidate
                >
                    <div class="card-header">
                        <i class="fa fa-plus"></i>
                        New Timekeeping
                    </div>

                    <div class="card-body">
                        @include('admin.timekeeping.components.form-elements')
                    </div>

                    <div class="card-footer">
                        <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="submiting"
                        >
                            <i
                                class="fa"
                                :class="submiting ? 'fa-spinner' : 'fa-download'"
                            ></i>
                            Save
                        </button>
                    </div>
                </form>
            </timekeeping-form>
        </div>
    </div>
@endsection
