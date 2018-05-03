<?php require_once 'includes/header.php'; ?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="glyphicon glyphicon-check"></i>	Order Report
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
				
				<form class="form-horizontal" action="php_action/getOrderReport.php" method="post" id="getOrderReportForm">
				  <div class="form-group">
				    <label for="startDate" class="col-sm-2 control-label">Start Date</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="startDate" name="startDate" placeholder="Start Date" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="endDate" class="col-sm-2 control-label">End Date</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date" />
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Generate Report</button>
				    </div>
				  </div>

                    <?php

                    $sql1 = "SELECT year(order_date), count(*) as number FROM orders GROUP BY year(order_date)";
                    //$sql1 = "SELECT substring(order_date,7,4)+substring(order_date,1,2) as dattte, count(*) as number FROM orders GROUP BY substring(order_date,7,4)+substring(order_date,1,2)";
                    $query1 = $connect->query($sql1);

                    ?>
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            google.charts.load('current', {'packages':['corechart']});
                            google.charts.setOnLoadCallback(drawChart);
                            function drawChart()
                            {
                                var data = google.visualization.arrayToDataTable([
                                    ['year(order_date)', 'Number'],
                                    <?php
                                    while($result1 = $query1->fetch_assoc())
                                    {
                                        echo "['".$result1["year(order_date)"]."', ".$result1["number"]."],";
                                    }
                                    ?>
                                ]);
                                var options = {
                                    title: 'Year Sale',
                                    //is3D:true,
                                    pieHole: 0.4
                                };
                                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                chart.draw(data, options);
                            }
                        </script>
                    </head>
                    <body>
                    <br /><br />
                    <div style="width:900px;">
                        <!--            <h3 align="center">Make Simple Pie Chart by Google Chart API with PHP Mysql</h3>-->
                        <br />
                        <div id="piechart" style="width: 900px; height: 500px;"></div>
                    </div>
                    </body>
                    </html>

				</form>

			</div>
			<!-- /panel-body -->
		</div>
	</div>
	<!-- /col-dm-12 -->
</div>
<!-- /row -->

<script src="custom/js/report.js"></script>

<?php require_once 'includes/footer.php'; ?>