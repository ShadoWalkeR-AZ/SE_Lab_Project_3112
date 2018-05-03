<?php require_once 'includes/header.php'; ?>

<?php 

$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

$orderSql = "SELECT * FROM orders WHERE order_status = 1";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;



$totalRevenue = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
	$totalRevenue += $orderResult['paid'];
}

$lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;


//$sql = "SELECT categories_id, COUNT(*) maximum FROM product WHERE status = 1 GROUP BY categories_id ORDER BY maximum DESC LIMIT 1";
$sql = "SELECT categories_name, COUNT(*) maximum FROM product p INNER JOIN categories c
    ON c.categories_id=p.categories_id WHERE status = 1 GROUP BY p.categories_id ORDER BY maximum DESC LIMIT 1";
//$sql = "SELECT categories_name, COUNT(*) maximum FROM product,categories WHERE product.categories_id=categories.categories_id and status = 1 GROUP BY product.categories_id ORDER BY maximum DESC LIMIT 1" ;
$query = $connect->query($sql);
//$result = $query->fetch_assoc();
$maxcatagoty = "";

while($result = $query->fetch_assoc())
{
    $temp_catagory = $result['categories_name'];
    $maxcatagoty = $temp_catagory;
}

$sql = "SELECT `title`, `url` FROM `recommendations` WHERE catagory = '$maxcatagoty'";
$catagory_query = $connect->query($sql);








$sql = "SELECT brand_name, COUNT(*) maximum FROM product p INNER JOIN brands b
    ON b.brand_id=p.brand_id WHERE status = 1 GROUP BY p.brand_id ORDER BY maximum DESC LIMIT 1";
//$sql = "SELECT categories_name, COUNT(*) maximum FROM product,categories WHERE product.categories_id=categories.categories_id and status = 1 GROUP BY product.categories_id ORDER BY maximum DESC LIMIT 1" ;
$query = $connect->query($sql);
//$result = $query->fetch_assoc();
$maxnews = "";

while($result = $query->fetch_assoc())
{
    $temp_news = $result['brand_name'];
    $maxnews= $temp_news;
}


$sql = "SELECT `title`, `url` FROM `news` WHERE brand_name = '$maxnews'";
$news_query = $connect->query($sql);



$connect->close();

?>


<style type="text/css">
	.ui-datepicker-calendar {
		display: none;
	}
</style>

<!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">


<div class="row">
	
	<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				
				<a href="product.php" style="text-decoration:none;color:black;">
					Total Product
					<span class="badge pull pull-right"><?php echo $countProduct; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

		<div class="col-md-4">
			<div class="panel panel-info">
			<div class="panel-heading">
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Total Orders
					<span class="badge pull pull-right"><?php echo $countOrder; ?></span>
				</a>
					
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
		</div> <!--/col-md-4-->

	<div class="col-md-4">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<a href="product.php" style="text-decoration:none;color:black;">
					Low Stock
					<span class="badge pull pull-right"><?php echo $countLowStock; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

	<div class="col-md-4">
		<div class="card">
		  <div class="cardHeader">
		    <h1><?php echo date('d'); ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p><?php echo date('l') .' '.date('d').', '.date('Y'); ?></p>
		  </div>
		</div> 
		<br/>

		<div class="card">
		  <div class="cardHeader" style="background-color:#245580;">
		    <h1><?php if($totalRevenue) {
		    	echo $totalRevenue;
		    	} else {
		    		echo '0';
		    		} ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p> <i class="glyphicon glyphicon-usd"></i> Total Revenue</p>
		  </div>
		</div>
        <br/>





        <div class="card">
            <div class="cardHeader" style="background-color:#FF1919;">
                <h1>
                    Catagory Based Recommendations
                </h1>
            </div>

            <div class="cardContainer">
                <?php
                while ($result = $catagory_query->fetch_assoc())
                {
                    $title = $result['title'];
                    $link = $result['url'];
                    echo "<a href='$link' style=\"color:grey\">$title</a></br>";
                }

                ?>
            </div>
        </div>
        </br>


        <div class="card">
            <div class="cardHeader" style="background-color:#f08a24;">
                <h1>
                    News From Companies
                </h1>
            </div>

            <div class="cardContainer">
                <?php
                while ($result = $news_query->fetch_assoc())
                {
                    $title = $result['title'];
                    $link = $result['url'];
                    echo "<a href='$link' style=\"color:grey\">$title</a></br>";
                }

                ?>
            </div>
        </div>










    </div>

	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading"> <i class="glyphicon glyphicon-calendar"></i> Calendar</div>
			<div class="panel-body">
				<div id="calendar"></div>
			</div>	
		</div>
		
	</div>

	
</div> <!--/row-->

<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


<script type="text/javascript">
	$(function () {
			// top bar active
	$('#navDashboard').addClass('active');

      //Date for the calendar events (dummy data)
      var date = new Date();
      var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear();

      $('#calendar').fullCalendar({
        header: {
          left: '',
          center: 'title'
        },
        buttonText: {
          today: 'today',
          month: 'month'          
        }        
      });


    });
</script>

<?php require_once 'includes/footer.php'; ?>