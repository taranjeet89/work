$('document').ready(function(){
	
	$('#search-button').click(function(){
		$('#search-text').val($('#search-text').val().trim());
		if($('#search-text').val() == "")
		{
			alert('Please enter stock symbol');
		}
		else
		{
			$.ajax({
				url:'exchange.php',
				type:'post',
				data:{'operation':'f', 'symbol':$('#search-text').val()},
				success:function(response){
					var data = $.parseJSON(response);
					if((data.status != undefined) && data.status == 'error'){
						alert(data.msg);
					} else {
						$('#stock-name').html(data.name+' ('+data.symbol+')');
						$('#searched-stock-symbol').val(data.symbol);
						$('#stock-bid-price').html(parseFloat(data.bid).toFixed(2));
						$('#stock-ask-price').html(parseFloat(data.ask).toFixed(2));
					}
				}
			});
		}
		return false;
	});
	
	$('#btn-stock-buy').click(function(){
		$('#stock-quantity').val($('#stock-quantity').val().trim());
		if($('#stock-quantity').val() == "" || $('#stock-quantity').val() == 0 || !$('#stock-quantity').val().match(/^[0-9]*$/))
		{
			alert('Please enter valid quantity');
		}
		else
		{
			$.ajax({
				url:'exchange.php',
				type:'post',
				data:{'operation':'b', 'symbol':$('#searched-stock-symbol').val(), 'quantity':$('#stock-quantity').val()},
				success:function(response){
					var data = $.parseJSON(response);
					if((data.status != undefined) && data.status == 'error'){
						alert(data.msg);
					} else {
						$('#person-cash').html("Cash : "+data.currency+parseFloat(data.cash).toFixed(2));
						$('#person-stocks').html('');
						for(var counter = 0; counter < data.stocks.length; counter++)
						{
							$('#person-stocks').append("<tr><td>"+data.stocks[counter].name+"</td><td>"+data.stocks[counter].quantity+"</td><td>"+parseFloat(data.stocks[counter].price).toFixed(2)+"</td><td><div class='col-md-3'><button type='submit' class='btn btn-sm btn-default'>View Stock</button></div></td></tr>");
						}
					}
					$('#stock-quantity').val('0');
				}
			});
		}
		return false;
	});
	
	$('#btn-stock-sell').click(function(){
		$('#stock-quantity').val($('#stock-quantity').val().trim());
		if($('#stock-quantity').val() == "" || $('#stock-quantity').val() == 0 || !$('#stock-quantity').val().match(/^[0-9]*$/))
		{
			alert('Please enter valid quantity');
		}
		else
		{
			$.ajax({
				url:'exchange.php',
				type:'post',
				data:{'operation':'s', 'symbol':$('#searched-stock-symbol').val(), 'quantity':$('#stock-quantity').val()},
				success:function(response){
					var data = $.parseJSON(response);
					if((data.status != undefined) && data.status == 'error'){
						alert(data.msg);
					} else {
						$('#person-cash').html("Cash : "+data.currency+parseFloat(data.cash).toFixed(2));
						$('#person-stocks').html('');
						for(var counter = 0; counter < data.stocks.length; counter++)
						{
							$('#person-stocks').append("<tr><td>"+data.stocks[counter].name+"</td><td>"+data.stocks[counter].quantity+"</td><td>"+parseFloat(data.stocks[counter].price).toFixed(2)+"</td><td><div class='col-md-3'><button type='submit' class='btn btn-sm btn-default'>View Stock</button></div></td></tr>");
						}
					}
					$('#stock-quantity').val('0');
				}
			});
		}
		return false;
	});
});