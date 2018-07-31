<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Inventory System</title>
		<meta name="description">
		<meta name="keywords">
		<meta name="author" content="Mohamed Saber">
		<script src="<?php echo base_url()?>/assets/js/jquery.min.js"></script>
	</head>
	<body dir="ltr">
		<div style="width:60%;margin-left: auto;margin-right: auto;background: #fff;padding: 1%;margin-bottom: 50px;">
			<fieldset>
				<legend>First Stage (inventory Items)</legend>
				<div class="first_stage" style="padding-bottom:10px;width:100%;">
					<?php echo form_open(base_url()."inventory/add_items");?>
					<table id="first_stage_table" style="margin:auto;width:100%;text-align:center;">
						<tbody>
							<tr>
								<td style="width:100px;border:1px solid #aaa;">
									<input style="width:98%;text-align:center;" placeholder="ITEM SKU"  type="text" name="item_sku[]" id="item_sku" />
								</td>
								<td style="width:100px;border:1px solid #aaa;">
									<input style="width:98%;text-align:center;" placeholder="ITEM NAME" type="text" name="item_name[]" id="item_name" />
								</td>
								<td style="width:100px;border:1px solid #aaa;">
									<input style="width:98%;text-align:center;" placeholder="ITEM QUANTITY" type="text" name="item_quantity[]" id="item_quantity" />
								</td>
								<td style="width:100px;border:1px solid #aaa;">
									<input style="width:98%;text-align:center;" placeholder="ITEM PRICE" type="text" name="item_price[]" id="item_price" />
								</td>
								<td id="add_cell" style="width:120px;border:1px solid #aaa;">
									<button type="button" id="add_item" name="add_item" style="margin: 0 auto;width:120px;">ADD NEW ITEM</button>
								</td>
							</tr>
						</tbody>
					</table>
					<div style="margin:auto;width:100%;text-align:center;margin-top:10px;">
						<button type="submit" name="singlebutton" style="margin: 0 auto;width:150px;">END</button>
					</div>
					<?php echo form_close();if(isset($items) && !empty($items)){?>
					<table border="1" style="width:100%;margin-top:20px;">
						<tr>
							<thead>
								<tr>
									<th>#</th>
									<th>ITEM SKU</th>
									<th>ITEM NAME</th>
									<th>ITEM QUANTITY</th>
									<th>ITEM PRICE (kn)</th>
								</tr>
							</thead>
							<tbody style="text-align:center;">
								<?php
								if(isset($items) && !empty($items)){
									for($counter = 0;$counter<count($items);$counter++){
								?>
								<tr>
									<td><?php echo $counter+1;?></td>
									<td><?php echo $items[$counter]['item_sku'];?></td>
									<td><?php echo $items[$counter]['item_name'];?></td>
									<td><?php echo $items[$counter]['item_quantity'];?></td>
									<td><?php echo $items[$counter]['item_price'];?></td>
								</tr>
								<?php
									}
								}
								?>
							</tbody>
						</tr>
					</table>
					<?php }?>
				</div>
			</fieldset>
			<fieldset style="margin-top:10px;" >
				<legend>Second Stage (Inventory Transactions)</legend>
				<div class="second_stage" style="padding-bottom:10px;width:100%;">
				<?php echo form_open(base_url()."inventory/add_items_to_cart");?>
					<table id="second_stage_table" style="width:100%;">
						<tr>
							<td style="width:100px;border:1px solid #aaa;">
								<select style="width:100%;text-align:center;" placeholder="SKU" name="sku_needed[]" >
									<?php 
									if(isset($items) && !empty($items)){
										foreach($items as $sku_item){
											echo '<option value="'.$sku_item['item_sku'].'">'.$sku_item['item_sku'].'-'.$sku_item['item_name'].'</option>';
										}
									}
									?>
								</select>
							</td>
							<td style="width:100px;border:1px solid #aaa;">
								<input style="width:98%;text-align:center;" placeholder="QUANTITY" type="text" name="quantity_needed[]" id="quantity_needed" />
							</td>
							<td id="add_cart_cell" style="width:100px;border:1px solid #aaa;text-align:center;">
								<button type="button" name="add_cart_item" id="add_cart_item" style="margin: 0 auto;width:150px;">ADD to shoping cart</button>
							</td>
						</tr>
					</table>
					<div style="margin:auto;width:100%;text-align:center;margin-top:10px;">
						<button type="submit" name="submit_form" style="margin: 0 auto;width:150px;">CHECKOUT</button>
					</div>
					<?php echo form_close();
					if(isset($cart_items) && !empty($cart_items)){
					?>
					<div class="second_stage">
					<table class="cart_table" border="1" style="width:100%;margin-top:20px;">
						<tr>
							<thead>
								<tr>
									<th>#</th>
									<th>ITEM SKU</th>
									<th>ITEM NAME</th>
									<th>QUANTITY NEEDED</th>
									<th>TOTAL PRICE (kn)</th>
									<th>REMOVE</th>
								</tr>
							</thead>
							<tbody style="text-align:center;">
								<?php
								if(isset($cart_items) && !empty($cart_items)){
									for($counter = 0;$counter<count($cart_items);$counter++){
								?>
								<tr>
									<td class="cart_counter"><?php echo $counter+1;?></td>
									<td class="item_sku"><?php echo $cart_items[$counter]['item_sku'];?></td>
									<td class="item_name"><?php echo $cart_items[$counter]['item_name'];?></td>
									<td class="quantity"><?php echo $cart_items[$counter]['total_quantity'];?></td>
									<td class="total_price"><?php echo $cart_items[$counter]['total'];?></td>
									<td class="remove_item">
										<label style="font-size:13px;color:red;cursor:pointer;" id="<?php echo $cart_items[$counter]['item_sku'];?>" >REMOVE</label>
									</td>
								</tr>
								<?php
									}
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<td style="text-align:center;font-weight:bold;" class="total_prices" colspan="6"></td>
								</tr>
							</tfoot>
						</tr>
					</table>
					<div style="margin:auto;width:100%;text-align:center;margin-top:10px;">
						<button type="button" id="add_transaction" id="add_transaction" name="add_transaction" style="margin: 0 auto;width:150px;">ADD TRANSACTION</button>
					</div>
					</div>
					<?php }?>
				</div>
			</fieldset>
		</div>
	</body>

	<script>
	var add_item_rowspan = 2;
	var add_cart_item_rowspan = 2;
	$( "#add_item" ).click(function() {
			$('#first_stage_table > tbody:last-child').append('<tr>'+
				'<td style="width:100px;border:1px solid #aaa;">'+
					'<input style="width:98%;text-align:center;" placeholder="ITEM SKU" type="text" name="item_sku[]" id="item_sku" />'+
				'</td>'+
				'<td style="width:100px;border:1px solid #aaa;">'+
					'<input style="width:98%;text-align:center;" placeholder="ITEM NAME" type="text" name="item_name[]" id="item_name" />'+
				'</td>'+
				'<td style="width:100px;border:1px solid #aaa;">'+
					'<input style="width:98%;text-align:center;" placeholder="ITEM QUANTITY" type="text" name="item_quantity[]" id="item_quantity" />'+
				'</td>'+
				'<td style="width:100px;border:1px solid #aaa;">'+
					'<input style="width:98%;text-align:center;" placeholder="ITEM PRICE" type="text" name="item_price[]" id="item_price" />'+
				'</td>'+
			'</tr>');
			$('#add_cell').attr('rowspan', rowspan++);
	});
	
	$("#add_cart_item").click(function() {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>inventory/sku_select_box",
			success: function(data){
				var options = "";
				var items = $.parseJSON(data);
				console.log(items);
				$.each(items, function(i,d)
				{
					options += '<option value="' + d.item_sku + '">' + d.item_sku + '-' + d.item_name + '</option>';
					
				});
				
				$('#second_stage_table > tbody:last-child').append('<tr>'+
					'<td style="width:100px;border:1px solid #aaa;">'+
						'<select style="width:100%;text-align:center;" class="sku_needed" name="sku_needed[]">'+options+'</select>'+
					'</td>'+
					'<td style="width:100px;border:1px solid #aaa;">'+
						'<input style="width:98%;text-align:center;" placeholder="QUANTITY" type="text" name="quantity_needed[]" id="quantity_needed" />'+
					'</td>'+
				'</tr>');
				$('#add_cart_cell').attr('rowspan', add_cart_item_rowspan++);
			}
		});
	});
	
	//For Total Prices Summation 
	function check_total_prices(){
		var sum = 0;
		$(".total_price").each(function() {
			var value = $(this).text();
			// add only if the value is number
			if(!isNaN(value) && value.length != 0) {
				sum += parseFloat(value);
			}
			$(".total_prices").text("TOTAL PRICES =  "+sum+ " kn");
		});
	}
	check_total_prices();
	/////////////////////////////////
	
	$(".remove_item > label").click(function(){
		var result = confirm("Do you really want to delete this item from the cart?");
		if (result) {
			var item_sku   = $(this).attr('id');
			var closest_tr = $(this).closest('tr');
			$.ajax({
				type:'POST',
				url:'<?php echo base_url();?>inventory/remove_cart_item',
				data:{'item_sku' : item_sku},
				success:function(data) {
					if(data) {
						closest_tr.remove();
						$('.cart_table tbody tr').each(function(i){
							if($('.cart_table tbody tr').length-1 != 0){
								$(this).find('td:first').text(i);
								check_total_prices();
							}
							else{
								$('div > .second_stage').hide();
							}
						});
					} else {
						return false;
					}
				}
			});
		}
	});

	/////////////////////////////////////
        $("#add_transaction").click(function () {
            var table = $(".cart_table tbody");
            var trans_items = [];
            table.find('tr').each(function (i) {
                var $tds = $(this).find('td'),
                    item_sku = $tds.eq(1).text(),
                    item_name = $tds.eq(2).text(),
                    qty_needed = $tds.eq(3).text(),
                    total_price = $tds.eq(4).text(),
                    trans_added_by = 1;

                trans_items[i] = {
                    trans_item_sku:item_sku,
                    trans_item_name:item_name,
                    trans_qty_needed:qty_needed,
                    trans_total_price:total_price,
                    trans_added_by:trans_added_by
                };

            });
            console.log(trans_items);
            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>inventory/add_transaction',
                data:{'trans_items' : trans_items},
                dataType: 'json',
                success:function(data) {
                    console.log(data);
                }
            });
        })
	</script>
</html>