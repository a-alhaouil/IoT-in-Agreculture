<!DOCTYPE html>
<html>

<head>
   <title>   Temperature and Humidity Data Visualisation   </title>
   
    <style>
        .container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .photos {
            width: 40%;
            padding: 10px;
        }

        .content {
            width: 80%;
            padding: 20px;
        }

         
    </style>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body  >
 
        <div class="content">
            <!--<center><h1 style=" color= white;">Temperature and Humidity Data</h1><br><br><br> </center>-->
             
            
             <div class="row">
                <div class="col-md-12">
                    <canvas id="combinedChart" width="800" height="400"></canvas>
                </div>
             </div><br><br>
            
           
             
                <div class="row">
                    <canvas id="temperatureChart" width="500" height="250"></canvas>
                </div><br><br><br>
                
                <div class="row">
                    <canvas id="humidityChart" width="500" height="250"></canvas>
                </div><br>
                <div class="row">
                    <canvas id="soilMoistureChart" width="500" height="250"></canvas>
                </div><br>
            
            <br>
            <br>
            
             
        </div>
 
    </div>

    <script>
        // Prepare data for temperature chart
        var temperatureData = {
            labels: [],
            datasets: [{
                label: 'Temperature',
                data: [],
                borderColor: 'rgb(75, 192, 192)',
                fill: true
            }]
        };

        // Prepare data for humidity chart
        var humidityData = {
            labels: [],
            datasets: [{
                label: 'Humidity',
                data: [],
                borderColor: 'rgb(255, 99, 132)',
                fill: true
            }]
        };

        // Prepare data for soil Moisture chart
            var soilMoistureData = {
            labels: [],
            datasets: [{
                label: 'soilMoisture',
                data: [],
                borderColor: 'rgb(255, 128, 0)',
                fill: true
            }]
        };

        // Prepare data for combined chart
        var combinedData = {
            labels: [],
            datasets: [{
                label: 'Temperature',
                data: [],
                borderColor: 'rgb(75, 192, 192)',
                fill: true
            },
            {
                label: 'Humidity',
                data: [],
                borderColor: 'rgb(255, 99, 132)',
                fill: true
            },
            {
                label: 'soilMoisture',
                data: [],
                borderColor: 'rgb(255, 128, 0)',
                fill: true
            }
        ]
        };

        

        <?php
        // Reset the result pointer to the beginning
        mysqli_data_seek($result, 0);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Add timestamp, temperature, and humidity to the JavaScript variables
                echo "temperatureData.labels.push('" . $row["timestamp"] . "');";
                echo "temperatureData.datasets[0].data.push(" . $row["temperature"] . ");";
                echo "humidityData.labels.push('" . $row["timestamp"] . "');";
                echo "humidityData.datasets[0].data.push(" . $row["humidity"] . ");";
                echo "soilMoistureData.datasets[0].data.push(" . $row["moisture"] . ");";
                echo "soilMoistureData.labels.push('" . $row["timestamp"] . "');";

                echo "combinedData.labels.push('" . $row["timestamp"] . "');";
                echo "combinedData.datasets[0].data.push(" . $row["temperature"] . ");";
                echo "combinedData.datasets[1].data.push(" . $row["humidity"] . ");";
                echo "combinedData.datasets[2].data.push(" . $row["moisture"] . ");";

            }
        }
        ?>

        // Create temperature chart
        var temperatureChartCtx = document.getElementById('temperatureChart').getContext('2d');
        var temperatureChart = new Chart(temperatureChartCtx, {
            type: 'line',
            data: temperatureData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Timestamp'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Temperature'
                        }
                    }
                }
            }
        });

        // Create humidity chart
        var humidityChartCtx = document.getElementById('humidityChart').getContext('2d');
        var humidityChart = new Chart(humidityChartCtx, {
            type: 'line',
            data: humidityData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Timestamp'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Humidity'
                        }
                    }
                }
            }
        });
        // Create soilMoisture chart
        var soilMoistureChartCtx = document.getElementById('soilMoistureChart').getContext('2d');
        var soilMoistureChart = new Chart(soilMoistureChartCtx, {
            type: 'line',
            data: soilMoistureData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Timestamp'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'soilMoisture'
                        }
                    }
                }
            }
        });

        // Create combined chart
        var combinedChartCtx = document.getElementById('combinedChart').getContext('2d');
        var combinedChart = new Chart(combinedChartCtx, {
            type: 'line',
            data: combinedData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Timestamp'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Value'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
