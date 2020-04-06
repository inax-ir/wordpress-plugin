<?php
if( isset($_GET['list']) ){
	$smarty->assign('charge_list',true);
	$smarty->assign('title', 'شارژهای خریداری شده');

	if(isset($_GET['inax_token']) && $_GET['inax_token']!=''){//نتیجه تراکنش
		$smarty->assign('bill_list',true);
		$smarty->assign('title', 'نتیجه تراکنش');
		$inax_token 	= $_GET['inax_token'];
		$decrypted 		= inax_url_decrypt( $inax_token );
		if($decrypted['status']){
			parse_str($decrypted['data'], $ir_output);
			$trans_id 	= $ir_output['id'];
			$order_id 	= $ir_output['order_id'];
			$amount 	= $ir_output['amount'];//از آینکس به تومان میاد
			$ref_code	= $ir_output['ref_code'];
			$status 	= $ir_output['status'];
			
			$order_id = substr($order_id, 0, -3);
			
			$can_display_result = true;
			
			$date 	= date('Y-m-d H:i:s');
			$pay_result = json_encode($ir_output,JSON_UNESCAPED_UNICODE);
			
			if($status == 'paid'){
				$mysqli->query("update wp_inax_charge set status='$status',ref_code='$ref_code',pay_date='$date',pay_result='$pay_result' where id='$order_id' and status='unpaid' ");
			}else{
				$mysqli->query("update wp_inax_charge set status='$status',pay_result='$pay_result' where id='$order_id' ");
			}
		}
	}
	
	$cond='';
	if( isset($can_display_result) && isset($_GET['id']) && $_GET['id']!=''){
		$tr_id= filter($_GET['id']);
		$cond = " and id='$tr_id' ";
		
		$client_id 		= 0;
		$sql_charge 	= $mysqli->query("SELECT * FROM wp_inax_charge where client_id='$client_id' and type='topup' $cond ORDER BY id DESC ") or die($mysqli->error);
		$rows_charge 	= $sql_charge->fetch_assoc();
		$smarty->append('charge_rows', $rows_charge);
	}
}
else{
	
	$smarty->assign('buy_charge',true);
	$smarty->assign('title', 'خرید شارژ مستقیم');

	if(isset($_GET['MTN'])){
		$operator = 'MTN';
		$smarty->assign('mtn_active',true);
	}
	elseif(isset($_GET['MCI'])){
		$operator = 'MCI';
		$smarty->assign('mci_active',true);
	}
	elseif(isset($_GET['RTL'])){
		$operator = 'RTL';
		$smarty->assign('rtl_active',true);
	}

	if( isset($_POST['submit']) && ( isset($_GET['MTN']) || isset($_GET['MCI']) || isset($_GET['RTL']) ) ){
		
		check_admin_referer( 'name_of_my_action', 'Token' );//wordpress
		
		if(isset($_POST['mobile']) && $_POST['mobile']!='' ){ $mobile = filter($_POST['mobile'],'number'); } else {	$mobile ='';}
		if(isset($_POST['amount']) && $_POST['amount']!='' ){ $amount = filter($_POST['amount']); } else {	$amount ='';}
		$charge_type = (isset($_POST['charge_type']) && $_POST['charge_type']!='' ) ? filter($_POST['charge_type']) : '';// provider defined in config1.php
		
		if($amount=='custom_amount'){
			$amount = filter($_POST['custom_amount']);
			$amount = str_replace(',','',$amount);
			$custom_amount=true;
			$smarty->assign('custom_amount',true);
		}
		$valid_amount = array(500,1000,2000,5000,10000,20000,30000,40000,50000);
		if($mobile == ""){
			$error_msg = 'شماره موبایل را وارد کنید !';
		}
		if($amount == ""){
			$error_msg = 'مبلغ خالی است !';
		}
		elseif(!$validate->Mobile($mobile)){
			$error_msg = 'شماره موبایل صحیح نیست !';
		}
		elseif(!$validate->Number($amount)){
			$error_msg = 'مبلغ ارسالی صحیح نیست !';
		}
		elseif( !isset($custom_amount) && !in_array($amount, $valid_amount)) {
			$error_msg = 'مبلغ شارژ صحیح نیست !';
		}
		elseif( isset($custom_amount) && ($amount<500 ||  $amount>200000) ){//custom amount
			$error_msg = 'مبلغ شارژ باید مابین 500 الی 200,000 تومان باشد';
		}
		elseif( $charge_type == ""){
			$error_msg = 'لطفا نوع شارژ را انتخاب کنید';
		}
		elseif( $charge_type!= "normal" && $charge_type!= "amazing" && $charge_type!= "mnp" && $charge_type!= "permanent" ){
			$error_msg = 'نوع شارژ صحیح نیست';
		}
		else{
			//exit('try later');
			$date = date('Y-m-d H:i:s');
			$client_id=0;
			
			/*$sql = $wpdb->insert("wp_inax_charge", array(
				"client_id" 	=> $client_id,
				"type" 			=> 'topup',
				"platform" 		=> 'client_area',
				"mobile" 		=> $mobile,
				"product_type" 	=> $operator,
				"amount" 		=> $amount,
				"date" 			=> $date,
			));
			*/
			
			$sql= $mysqli->query("INSERT INTO wp_inax_charge (client_id,type, platform ,mobile, product_type, amount,date) VALUES ('$client_id', 'topup', 'client_area' , '$mobile', '$operator', '$amount', '$date') " );

			$status = 'unpaid';
			$ref_code  = $res_code = '';
			
			if($sql){
				$charge_id	= $mysqli->insert_id;

				$payment_type='online';
				$error_msg = 'خطای نامعلوم';
				$get_permalink = esc_url( get_permalink() );
				$callback = "{$get_permalink}?list&id=$charge_id";
				$param = array(
					'product'		=> 'topup',
					'amount'		=> $amount,
					'mobile'		=> $mobile,
					'operator'		=> $operator,
					'charge_type'	=> $charge_type,
					'order_id'		=> $charge_id.rand(100, 999),
					'callback'		=> $callback,
				);
				$result = RequestJson_Last('invoice',$param,'inax');
				
				//error_log(print_r($param,true));
				//error_log(print_r($result,true));
				
				if( isset($result) && $result!=false ){
					if($result['code']==1){
						$trans_id = $result['trans_id'];
						$url = "https://inax.ir/pay.php?tid={$trans_id}";
						if(headers_sent()){
							//die('<script>window.location.assign("'.$url.'")</script>');
							echo "<script>window.location.href = '$url'; </script>";
						}
						else{
							header("Location: $url");
						}
					}else{
						$error_msg= $result['msg'];
					}
				}else{
					$error_msg = "لطفا کمی بعد دوباره تلاش نمائید";
				}
				$mysqli->query("update wp_inax_charge set status='$status',res_code='$res_code',ref_code='$ref_code',payment_type='$payment_type' WHERE id='$charge_id' ");
			}
		}
	} //-->submit
}

if(isset($error_msg)){$smarty->assign('error_msg',$error_msg);}
if(isset($success_msg)){$smarty->assign('success_msg',$success_msg);}
$smarty->display( INAX_DIR . '/templates/topup.tpl');
?>
