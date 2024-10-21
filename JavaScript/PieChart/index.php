<!DOCTYPE html>
<html>
<head>
    <title>Pie Chart Example</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        fetch('data.php')
          .then(response => response.json())
          .then(data => {
            const formattedData = [['Category', 'Value']].concat(data);
            const googleData = google.visualization.arrayToDataTable(formattedData);

            const options = {
              title: 'My Pie Chart',
              is3D: true,
              // slices: { 0: {offset: 0.1}, 2: {offset: 0.2} },
              fontSize: 14,
              chartArea: {width: '100%', height: '90%'},
            };

            const chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(googleData, options);
          });
      }
    </script>
</head>
<body>
    <div id="piechart" style="width: 900px; height: 500px; margin: 200px 300px;"></div>
</body>
</html>