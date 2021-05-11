@extends('brackets/admin-ui::admin.layout.default')

@section('title', 'Dashboard')

@section('bottom-scripts')
    <script>
        window.app.my = @json($my);
        window.app.avg = @json($avg);
    </script>

    <script src="{{ mix('js/dashboarde.js') }}"></script>
@endsection

@section('body')
    <div id="dashboard" v-cloak>
        <div class="row">
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