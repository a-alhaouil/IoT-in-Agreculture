<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>


<script>
    function exportToExcel() {
        try {
            var table = document.getElementById('dataTable');
    
            // Créer une nouvelle feuille de calcul
            var ws = XLSX.utils.json_to_sheet(getTableData(table));
    
            // Créer un fichier Excel au format blob
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet 1');
            XLSX.writeFile(wb, 'exported_data.xls');
        } catch (error) {
            console.error('Erreur lors de l\'export Excel :', error);
        }
    }
    
    // Fonction pour obtenir les données du tableau sous forme de tableau d'objets
    function getTableData(table) {
        var data = [];
        var headers = [];
        
        // Récupérer les en-têtes
        for (var i = 0; i < table.rows[0].cells.length; i++) {
            headers[i] = table.rows[0].cells[i].innerText.trim();
        }
    
        // Récupérer les données
        for (var i = 1; i < table.rows.length; i++) {
            var rowData = {};
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                rowData[headers[j]] = table.rows[i].cells[j].innerText.trim();
            }
            data.push(rowData);
        }
    
        return data;
    }
</script>
 <h1 style=" font-weight: bold; color:black; " > Table Of Data </h1><br>
<div style="text-align: center;">
    <button class="btnn" onclick="exportToExcel()">Export to Excel </button>
</div>
<br><br>
    <table class="container" id="dataTable">
        <thead>
            <tr>
                <th><h1>Timestamp</h1></th>
                <th><h1>Temperature</h1></th>
                <th><h1>Humidity</h1></th>
                <th><h1>moisture</h1></th>

            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>" ;
                    echo "<td>" . $row["timestamp"] . "</td>";
                    echo "<td>" . $row["temperature"] . "°C </td>";
                    echo "<td>" . $row["humidity"] . "% </td>";
                    echo "<td>" . $row["moisture"] . "% </td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No data available</td></tr>";
            }
            ?>
        </tbody>
         
    </table>
 

    


</html>

<style>
        /*	
	Table Responsive
	===================
	Author: https://github.com/pablorgarcia
 */

@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,700);

body {
  font-family: 'Open Sans', sans-serif;
  font-weight: 300;
  line-height: 1em;
  background-color: white;
}

h1 {
  font-size:3em; 
  font-weight: 300;
  line-height:1em;
  text-align: center;
  color: #4DC3FA;
}

h2 {
  font-size:1em; 
  font-weight: 300;
  text-align: center;
  display: block;
  line-height:1em;
  padding-bottom: 2em;
  color: #FB667A;
}

h2 a {
  font-weight: 700;
  text-transform: uppercase;
  color: #FB667A;
  text-decoration: none;
}

 

.container th h1 {
	  font-weight: bold;
	  font-size: 1em;
  text-align: left;
  color: black;
}

.container td {
	  font-weight: normal;
	  font-size: 1em;
   
}

.container {
	  text-align: left;
	  overflow: visible;
	  width: 90%;
	  margin: 0 auto;
  display: table;
  padding: 0 0 8em 0;
}

.container td, .container th {
	  padding-bottom: 1%;
	  padding-top: 1%;
  padding-left:1%;  
}

/* Background-color of the odd rows */
.container tr:nth-child(odd) {
	  background-color: #A3C1AD ;
}

/* Background-color of the even rows */
.container tr:nth-child(even) {
	  background-color: #d9ead3;
}

/* .container th {
	  background-color: 
} */

.container td:first-child { color: balck;font-weight: bold; }
.container td{ color: black;font-weight: bold; }

.container tr:hover {
   background-color: #c8e28e;
-webkit-box-shadow: 0 6px 6px -6px #0E1119;
	   -moz-box-shadow: 0 6px 6px -6px #0E1119;
	        box-shadow: 0 6px 6px -6px #0E1119;
}

.container td:hover {
  background-color: white;
  color: #403E10;
  font-weight: bold;
  
  
  
  transition-delay: 0s;
	  transition-duration: 0.4s;
	  transition-property: all;
  transition-timing-function: line;
}

@media (max-width: 800px) {
.container td:nth-child(4),
.container th:nth-child(4) { display: none; }
}

.btnn {
text-decoration: none;
font-weight: bold;
padding: 10px;
font-family: arial;
font-size: 1em;
color: #FFFFFF;
background-color: #b6d7a8;
border-radius: 24px;
-webkit-border-radius: 24px;
-moz-border-radius: 24px;
border: 4px solid #b6d7a8;
box-shadow: 3px 3px 13px #444444;
-webkit-box-shadow: 3px 3px 13px #444444;
-moz-box-shadow: 3px 3px 13px #444444;
}


.btnn:hover {
padding: 10px;
background-color:  #6aa84f;
border: 4px solid #8fce0e;
box-shadow: 1px 1px 4px #777777;
-webkit-box-shadow: 1px 1px 4px #777777;
-moz-box-shadow: 1px 1px 4px #777777;
}
    </style>
    
    
    
   
