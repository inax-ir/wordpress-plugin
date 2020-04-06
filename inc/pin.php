<?php
if( isset($_GET['list']) ){
	$smarty->assign('pin_list',true);
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
			$buy_info 	= $ir_output['buy_info'];
			//print_r($ir_output);
			
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
	if(  isset($can_display_result) && isset($_GET['id']) && $_GET['id']!='' ){
		$tr_id= filter($_GET['id']);
		$cond = " and id='$tr_id' ";
		
		$client_id 		= 0;
		$sql_pin = $mysqli->query("SELECT * FROM wp_inax_charge where client_id='$client_id' and type='pin' $cond ORDER BY id DESC ") or die($mysqli->error);
		$rows_pin 	= $sql_pin->fetch_assoc();
		$smarty->append('pin_rows', $rows_pin);

	}
}
else{
	$smarty->assign('buy_pin',true);
	$smarty->assign('title', 'خرید کارت شارژ');
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
		
		if(isset($_POST['mobile']) && $_POST['mobile']!='' ){ $mobile = filter($_POST['mobile'],'number'); } else {	$mobile ='';		}
		if(isset($_POST['amount']) && $_POST['amount']!='' ){ $amount = filter($_POST['amount']); } else {	$amount ='';		}
		
		$valid_amount = array(1000,2000,5000,10000,20000);
		
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
		elseif( !in_array($amount, $valid_amount)) {
			$error_msg = 'مبلغ شارژ صحیح نیست !';
		}
		else{
			//exit('try later');
			$date = time();
			$client_id=0;
			
			$count=1;
			$sql= $mysqli->query("INSERT INTO wp_inax_charge (client_id,type, platform ,mobile, product_type, amount,date) VALUES ('$client_id', 'pin', 'client_area' , '$mobile', '$operator', '$amount', '$date') " );
			$status = 'unpaid';
			$ref_code  = $res_code = '';
			
			if($sql){
				$charge_id	= $mysqli->insert_id;
				$payment_type='online';
				
				$error_msg = 'خطای نامعلوم';
				
				$get_permalink = esc_url( get_permalink() );
				$callback = "{$get_permalink}?list&id=$charge_id";
				$param = array(
					'product'		=> 'pin',
					'amount'		=> $amount,
					'mobile'		=> $mobile,
					'count'			=> $count,
					'operator'		=> $operator,
					'order_id'		=> $charge_id,
					'callback'		=> $callback,
				);
				$result = RequestJson_Last('invoice',$param,'inax');
				
				if( isset($result)  && $result!=false ){
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
$smarty->display( dirname( __FILE__ ) . '/templates/pin.tpl');
?>