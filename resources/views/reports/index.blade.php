
<x-layout>
    
    <x-section name="scripts">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
     
            function drawChart() {
     
            var data = google.visualization.arrayToDataTable([
                ['Day', 'Registered'],
     
                    @php
                    foreach($pieChart as $d) {
                        echo "['".$d->day_name."', ".$d->count."],";
                    }
                    @endphp
                    
            ]);
     
              var options = {
                title: 'Users Detail',
                is3D: true,
              };
     
              var chart = new google.visualization.PieChart(document.getElementById('piechart'));
     
              chart.draw(data, options);
            }
          </script>
          
    </x-section>
     
        <div class="container p-5">
            <h5>Reports</h5>
     
            <div id="piechart" style="width: 900px; height: 500px;"></div>
        </div>

</x-layout>