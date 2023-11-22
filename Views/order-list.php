
<section class="orderlist">
  <div class="container">
	<div class="row">
	  <div class="col-12">
		<div class="brdcrumb">
		  <a href=""><span>Home</span> ~ My order</a>
		</div>
		<div class="ind-head">
		  <h3>My orders</h3>
		  
		</div>
		<div class="orderlist__input"></div>

		<div class="order-table mt-5">
		  <div class="table-responsive">
			<table class="table mb-3"> 
			  <thead>
				<tr>
				  <th>Order No.</th>
				  <th>User Name</th>
				  <th>Email</th>
				  
				  <th>Transcation ID</th>
				  <th>Order Created</th>
				  <th>Amount</th>
				 
				  <th width="10%">Status</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php //print_r($orders); ?>
			  <?php foreach($orders as $order){ ?>
				<tr>
				  <td>#<?php echo $order['order_id']; ?></td>
				  <td><?php echo $order['user_fullname']; ?></td>
				  <td><?php echo $order['user_email']; ?></td>
				 
				  <td><?php echo $order['paymentId']; ?></td>
				  <td><?php echo $order['order_created']; ?></td>
				  <td><?php echo $order['amount']; ?></td>
				  
				  <td class="succces"><a href=""><?php echo $order['pay_status']; ?></a></td>
				</tr>
			  <?php } ?>
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</section>