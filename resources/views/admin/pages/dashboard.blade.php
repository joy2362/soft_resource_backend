@extends('admin.layout.master')
@section('title')
    <title>Dashboard</title>
@endsection
@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Dashboard</h1>
        <div class="row">
            <div class="col-xl-6 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Category</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="list"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">{{$category}}</h1>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Item</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="file"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">{{$item}}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Visit</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="folder"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">{{$totalHit}}</h1>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Visitors</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="users"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">{{$visitors}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-xxl-7">
                <div class="card flex-fill w-100">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Monthly Visitor Count</h5>
                    </div>
                    <div class="card-body py-3">
                        <div class="chart chart-sm">
                            <div id="visitorCount"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
                        <div class="col-12 col-lg-8 col-xxl-9 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header">

                                    <h5 class="card-title mb-0">Recent Visitor</h5>
                                </div>
                                <table class="table table-hover my-0">
                                    <thead>
                                        <tr>
                                            <th>Ip</th>
                                            <th class="d-none d-xl-table-cell">Date</th>
                                            <th class="d-none d-xl-table-cell">Time</th>
                                            <th class="d-none d-xl-table-cell">Hits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($recentVisit as $row)
                                        <tr>
                                            <td>{{$row->visitor}}</td>
                                            <td class="d-none d-xl-table-cell">{{$row->visit_date}}</td>
                                            <td class="d-none d-xl-table-cell">{{$row->visit_time}}</td>
                                            <td class="d-none d-xl-table-cell">{{$row->hits}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-xxl-3 d-flex">
                            <div class="card flex-fill w-100">
                                <div class="card-header">

                                    <h5 class="card-title mb-0">Monthly Total Visit</h5>
                                </div>
                                <div class="card-body d-flex w-100">
                                    <div class="align-self-center chart chart-lg">
                                        <div id="hitsCount"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
</main>
@endsection
@section('script')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Month Name', 'Visitor'],

                @php
                    foreach($lineChart as $d) {
                        echo "['".$d->month_name."', ".$d->count."],";
                    }
                @endphp
            ]);

            var options = {
                title: 'Visitor Month Wise',
                curveType: 'function',
                legend: { position: 'none' },
                bar: { groupWidth: "90%" }
            };

            var chart = new google.visualization.LineChart(document.getElementById('visitorCount'));

            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Month Name', 'Visitor'],

                @php
                    foreach($hitCount as $d) {
                        echo "['".$d->month_name."', ".$d->count."],";
                    }
                @endphp
            ]);

            var options = {
                title: 'Visitor Month Wise',
                curveType: 'function',
                legend: { position: 'none' },
                bar: { groupWidth: "90%" }
            };

            var chart = new google.visualization.LineChart(document.getElementById('hitsCount'));

            chart.draw(data, options);
        }
    </script>

    @endsection
