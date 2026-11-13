@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive" style="overflow-x:inherit">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<font size="6">COBROS DE FRECUENCIA POR USUARIO</font>
			</div>
		</div>
	</div>
    

   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Conductor', 'cantidad'],
          @foreach ($carrera as $pastel)
          ['{{$pastel->nombre}} {{$pastel->paterno}} {{$pastel->materno}}',{{$pastel->cantidad}}],
          @endforeach
          ]);

        var options = {
          title: 'Reporte de conductores con mas carreras',
          pieHole: 0.4,

        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

    <div id="piechart_3d" style="width: 900px; height: 500px;"></div>

	</div>

@endsection
