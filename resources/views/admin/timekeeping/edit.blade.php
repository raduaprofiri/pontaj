@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.timekeeping.actions.edit', ['name' => $timekeeping->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <timekeeping-form
                :action="'{{ $timekeeping->resource_url }}'"
                :data="{{ $timekeeping->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.timekeeping.actions.edit', ['name' => $timekeeping->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.timekeeping.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </timekeeping-form>

        </div>
    
</div>

@endsection