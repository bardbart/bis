
<x-layout>
    
    <x-section name="scripts">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        
          
    </x-section>
    
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
                title: 'Filed Documents',
                is3D: true,
              };
     
              var chart = new google.visualization.PieChart(document.getElementById('piechart'));
     
              chart.draw(data, options);
            }
          </script>
     
        <script type="text/javascript">

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
     
            function drawChart() {
     
            var data2 = google.visualization.arrayToDataTable([
                ['Day', 'Registered'],
     
                    @php
                    foreach($pieChart2 as $d2) {
                        echo "['".$d2->day_name."', ".$d2->count."],";
                    }
                    @endphp
                    
            ]);
     
              var options = {
                title: 'Filed Complaints',
                is3D: true,
              };
     
              var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
     
              chart.draw(data2, options);
            }
          </script>

        <script type="text/javascript">

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
     
            function drawChart() {
     
            var data3 = google.visualization.arrayToDataTable([
                ['Day', 'Registered'],
     
                    @php
                    foreach($pieChart3 as $d3) {
                        echo "['".$d3->day_name."', ".$d3->count."],";
                    }
                    @endphp
                    
            ]);
     
              var options = {
                title: 'Filed Blotters',
                is3D: true,
              };
     
              var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
     
              chart.draw(data3, options);
            }
          </script>
          


            


        <h1 >Reports</h1>
        <div class="flex-box-reports" style="display: flex; flex-wrap: wrap; ">
            
            

            <div id="piechart" style="width: 900px; height: 500px; margin: auto; margin-left: 300px"></div>

            <div id="piechart2" style="width: 900px; height: 500px; margin: auto; margin-left: 300px"></div>

            <div id="piechart3"style="width: 900px;height:500px; margin: auto; margin-left: 300px"></div>
            
        </div>

</x-layout>