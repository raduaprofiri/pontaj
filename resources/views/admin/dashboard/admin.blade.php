@extends('brackets/admin-ui::admin.layout.default')

@section('title', 'Dashboard')

@section('bottom-scripts')
    <script>
        window.app.my = @json($my);
        window.app.avg = @json($avg);
    </script>

    <script src="{{ mix('js/dashboarda.js') }}"></script>
@endsection

@section('body')
    <div id="dashboard" v-cloak>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group" v-if="!loading">
                            <label>User</label>

                            <select class="form-control" id="userselect">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <h4 class="text-center">Worked minutes</h4>
                <div id="chart"></div>
            </div>

            <div class="col-6">
                <h4 class="text-center">Average worked minutes</h4>
                <div id="chart2"></div>
            </div>
        </div>
    </div>
@endsection