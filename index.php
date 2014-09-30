<?php
require_once('config.php');
session_start();
$_SESSION['person']['cash'] = $initialCash;
$_SESSION['person']['currency'] = $currency;
$_SESSION['person']['stocks'] = array();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Simple Stock Exchange</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">	
	</head>
	<body>
		<header>
			<nav class="navbar navbar-default" role="navigation">
                        <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                    <a class="navbar-brand" href="#">Simple Stock Exchange</a>
                                </div>
        
                                <!-- Search Form -->
                                <ul class="nav navbar-nav navbar-right">
                                    <form class="navbar-form navbar-left" role="search">
                                        <div class="form-group">
                                            <input id="search-text" type="text" class="form-control" placeholder="Enter Symbol">
                                        </div>
										<button id="search-button" type="submit" class="btn btn-default">Lookup</button>
                                    </form>
                                </ul>
                        </div><!-- /.container-fluid -->
            </nav>
		</header>
		
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<h4 id="stock-name">&nbsp;</h4>
							<input id="searched-stock-symbol" type="hidden" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table id='portfolio-table' class="table">
								<thead>
								<tr>
									<th><div class="row"><div class="col-md-12">Bid</div></div></th>
									<th><div class="row"><div class="col-md-12">Ask</div></div></th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td>
										<div class="row">
											<div id="stock-bid-price" class="col-md-12">
												&nbsp;
											</div>
										</div>
									</th>
									<td>
										<div class="row">
											<div id="stock-ask-price" class="col-md-12">
												&nbsp;
											</div>
										</div>
									</th>
								</tr>
								<tr>
									<td colspan="2">
										<div class="row">
											<div class="col-md-6">
												<input id="stock-quantity" type="text" class="form-control" placeholder="Quantity">
											</div>
											<div class="col-md-3">
												<button id="btn-stock-buy" type="submit" class="btn btn-default">Buy</button>
											</div>
											<div class="col-md-3">
												<button id="btn-stock-sell" type="submit" class="btn btn-default">Sell</button>
											</div>
										</div>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-6">
							<h4>Current Portfolio</h4>
						</div>
						<div class="col-md-6 text-right">
							<h4 id="person-cash">Cash : <?php echo $currency.number_format($_SESSION['person']['cash'],2,'.',','); ?></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table class="table">
								<thead>
								<tr>
									<th>Company</th>
									<th>Quantity</th>
									<th>Price Paid</th>
									<th>&nbsp;</th>
								</tr>
								</thead>
								<tbody id="person-stocks">
								
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="js/jquery-2.1.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/exchange.js"></script>
	</body>
</html>
