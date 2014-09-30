<?php
require_once('config.php');
session_start();
unset($_SESSION['person']['status']);
unset($_SESSION['person']['msg']);
header('Content-type','application/json');
class Exchange
{
	function searchStock($symbol)
	{
		$ch = curl_init(REST_API_URL."/".$symbol);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	function buyStock($symbol, $quantity)
	{
		$data = $this->searchStock($symbol);
		$dataObj = json_decode($data);
		$purchaseAmount = $quantity * $dataObj->ask;
		if($_SESSION['person']['cash'] > $purchaseAmount)
		{
			$_SESSION['person']['cash'] = $_SESSION['person']['cash'] - $purchaseAmount;
			$userArray['name'] = $dataObj->name;
			$userArray['symbol'] = $dataObj->symbol;
			$userArray['quantity'] = $quantity;
			$userArray['price'] = $dataObj->ask;
			$_SESSION['person']['stocks'][] = $userArray;
		}
		else
		{
			$_SESSION['person']['status'] = 'error';
			$_SESSION['person']['msg'] = 'Insufficient Cash Balance';
		}
	}

	function sellStock($symbol, $quantity)
	{
		$data = $this->searchStock($symbol);
		$dataObj = json_decode($data);
		
		$total = 0;
		$keys = array();
		
		foreach($_SESSION['person']['stocks'] as $key => $stock)
		{
			if($stock['symbol'] == $symbol)
			{
				$keys[] = $key;
				$total += $stock['quantity'];
			}
		}
		
		if($total >= $quantity)
		{
			$sellAmount = $quantity * $dataObj->bid;
			$sold = 0;
			foreach($keys as $key)
			{
				if($sold == $quantity)
				{
					break;
				}
				else
				{
					if($sold < $quantity)
					{
						$toSell = $quantity - $sold;
						if($_SESSION['person']['stocks'][$key]['quantity'] <= $toSell)
						{
							$sold +=  $_SESSION['person']['stocks'][$key]['quantity'];
							unset($_SESSION['person']['stocks'][$key]);
						}
						else
						{
							$sold +=  $toSell;
							$_SESSION['person']['stocks'][$key]['quantity'] = $_SESSION['person']['stocks'][$key]['quantity'] - $toSell;
						}
					}
					else
					{
						break;
					}
				}
			}
			$_SESSION['person']['stocks'] = array_values($_SESSION['person']['stocks']);
			$_SESSION['person']['cash'] = $_SESSION['person']['cash'] + $sellAmount;
		}
		else
		{
			$_SESSION['person']['status'] = 'error';
			$_SESSION['person']['msg'] = 'Insufficient Stock Quantity';
		}
	}
}

$validOperation = array('f','b','s');

if(!in_array(strtolower($_POST['operation']), $validOperation))
{
	echo '{"status":"error","msg":"Invalid Operation"}';
	die;
}
else
{
	$operation = $_POST['operation'];
}

$exchange = new Exchange();

switch($operation)
{
	case 'f':
		$data = $exchange->searchStock(strtoupper($_POST['symbol']));
		echo $data;
		die;
	case 'b':
		$exchange->buyStock(strtoupper($_POST['symbol']), $_POST['quantity']);
		echo json_encode($_SESSION['person']);
		die;
	case 's':
		$exchange->sellStock(strtoupper($_POST['symbol']), $_POST['quantity']);
		echo json_encode($_SESSION['person']);
		die;
	default:
		echo '{"status":"error","msg":"Invalid Operation"}';
		die;
}