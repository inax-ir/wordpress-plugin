<?php
function operator_fa($operator){
	$operator_fa='';
	switch ($operator) {
		case 'MTN':		$operator_fa = 'ایرانسل';break;
		case 'MTN!':	$operator_fa = 'شگفت انگیز ایرانسل';break;
		case 'MTN#':	$operator_fa = 'خط دایمی ایرانسل';break;
		case 'WiMax':	$operator_fa = 'وایمکس ایرانسل';break;
		case 'MCI':		$operator_fa = 'همراه اول';break;
		case 'RTL':		$operator_fa = 'رایتل';break;
		case 'RTL!':	$operator_fa = 'شورانگیز رایتل';break;
		default : 		$operator_fa = ""; break;
	}
	return $operator_fa;
}

if( isset($_GET['list']) ){
	$smarty->assign('internet_list',true);
	$smarty->assign('title', 'بسته های اینترنتی');
	
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
			$refcode	= $ir_output['refcode'];
			$status 	= $ir_output['status'];
			//print_r($ir_output);
			
			$can_display_result = true;
			
			$date 	= date('Y-m-d H:i:s');
			$pay_result = json_encode($ir_output,JSON_UNESCAPED_UNICODE);
			
			if($status == 'paid'){
				$mysqli->query("update wp_inax_charge set status='$status',ref_code='$refcode',pay_date='$date',pay_result='$pay_result' where id='$order_id' and status='unpaid' ");
			}else{
				$mysqli->query("update wp_inax_charge set status='$status',pay_result='$pay_result' where id='$order_id' ");
			}
		}
	}
	
	$cond='';
	if( isset($can_display_result) && isset($_GET['id']) && $_GET['id']!='' ){
		$tr_id= filter($_GET['id']);
		$cond = " and id='$tr_id' ";
		
		$client_id 	= 0;
		$sql_charge = $mysqli->query("SELECT * FROM wp_inax_charge where client_id='$client_id' and type='internet' $cond ORDER BY id DESC ") or die($mysqli->error);
		$internet_rows = $sql_charge->fetch_assoc();
		$smarty->append('internet_rows', $internet_rows);
	}
}
else{
	$smarty->assign('title', 'خرید بسته اینترنت');
	
	$product_find = false;
	
	if(isset($_GET['MTN']) || isset($_GET['MCI']) || isset($_GET['RTL'])){
		//$smarty->assign('select_package',true);
		
		/*if(isset($_GET['MTN'])){
			$provider= 'novinways';
		}else{
			$provider= 'elkapos';
		}*/
		
		if(isset($_GET['MTN']) ){
			$operator = 'MTN';
		}
		elseif(isset($_GET['MCI'])){
			$operator = 'MCI';
		}
		elseif(isset($_GET['RTL'])){
			$operator = 'RTL';
		}
		$smarty->assign('operator',$operator);
		//$smarty->assign('total_count',10);
		
		if( (isset($_GET['MTN']) || isset($_GET['MCI']) || isset($_GET['RTL']) ) && !isset($_GET['sim']) ){//درخواست نوع سیم کارت
			$smarty->assign('request_sim_type',true);
		}
		elseif( (isset($_GET['MTN']) || isset($_GET['MCI']) || isset($_GET['RTL'])) && isset($_GET['sim']) && ($_GET['sim']=='credit' || $_GET['sim']=='permanent' ) ){
			$smarty->assign('package_list',true);
			
			$sim_type = $_GET['sim'];
			$smarty->assign('sim_type',$sim_type);
			$operator_fa 	= operator_fa($operator);
			
			$result = RequestJson_Last('get_products',array(), 'inax');
			if( isset($result) && $result!=false ){
				if($result['code']==1){
					$pro = $result['products'];
					//$json = json_decode($pro,true);
					if( !isset($pro['internet']) ){
						$error_msg = "خطا در دریافت بسته های اینترنتی... لطفا دوباره تلاش کنید.";
					}else{
						$internet_package = $pro['internet'];
						//$internet_package 	= $products['products']['InternetPackage'];
				
						if( !isset($internet_package[$operator]) ){
							$error_msg = " برای اپراتور {$operator_fa} بسته های اینترنتی یافت نشد .";
						}else{
							if(!isset($internet_package[$operator][$sim_type])){
								$sim_type_fa 	= sim_type_fa($sim_type);
								$error_msg = "برای سیم کارت {$sim_type_fa} {$operator_fa} بسته اینترنتی یافت نشد";
							}else{
								$package = $internet_package[$operator][$sim_type];
								
								//$int_types_list = array('hourly','daily','weekly','monthly','yearly','amazing','TDLTE');
								$int_types_list = array('hourly'=>'ساعتی','daily'=>'روزانه','weekly'=>'هفتگی','monthly'=>'ماهیانه','yearly'=>'سالیانه','amazing'=>'شگفت انگیز','TDLTE'=>'اینترنت ثابت TD-LTE');
								
								//$smarty->debugging = true;
								//print_r($package);
								
								foreach ($int_types_list as $type_en => $type_fa){
									if( isset($package[$type_en]) ){
										$have_package['type_en'] = $type_en;
										$have_package['type_fa'] = $type_fa;
										
										$have_package['lists2']=array();//جلوگیری از تکرار روزانه در ماهانه ها
										
										foreach ($package[$type_en] as $pid => $pack){
											$id 		= $pack['id'];
											$name 		= $pack['name'];
											$amount 	= $pack['amount'];
											
											$pack_list2 = array('id'=>$id,'amount'=>$amount, 'name'=>$name);
											$have_package['lists2'][] = $pack_list2;
										}
										//print_r($have_package);
										$smarty->append('have_package',$have_package);
									}
								}
								$smarty->append('internet_package',$package);
								//print_r($package);
							}
						}
					}
					//print_r($pro);
					//exit;
					
				}else{
					$error_msg= $result['msg'];
				}
			}else{
				$error_msg = "لطفا کمی بعد دوباره تلاش نمائید";
			}
			//}
		}
		
		//مشاهده جزئیات محصول انتخاب شده
		if( isset($_GET['pid']) && $_GET['pid']!='' && (isset($_GET['MTN']) || isset($_GET['MCI']) || isset($_GET['RTL'])) && isset($_GET['sim']) && ($_GET['sim']=='credit' || $_GET['sim']=='permanent' ) && isset($_GET['i']) && ($_GET['i']=='hourly' || $_GET['i']=='daily' || $_GET['i']=='weekly' || $_GET['i']=='monthly' || $_GET['i']=='yearly' || $_GET['i']=='amazing' || $_GET['i']=='TDLTE' ) ){
			$pid		= filter($_GET['pid']);
			$sim_type 	= filter($_GET['sim']);
			$in_type 	= filter($_GET['i']);
			if(isset($_GET['MTN']) ){ $operator = 'MTN';	} elseif(isset($_GET['MCI'])){ $operator = 'MCI';	} elseif(isset($_GET['RTL'])){ $operator = 'RTL';	}
			
			$smarty->assign('package_list',false);
			$smarty->assign('enter_mobile',true);
			
			/*if(isset($_GET['MTN'])){
				$provider= 'novinways';
			}else{
				$provider= 'elkapos';
			}*/
			
			$result = RequestJson_Last('get_products',array(), 'inax');
			if( isset($result) && $result!=false ){
				if($result['code']==1){
					$pro = $result['products'];
					if( !isset($pro['internet']) ){
						$error_msg = "خطا در دریافت بسته های اینترنتی... لطفا دوباره تلاش کنید.";
					}else{
						$internet_package = $pro['internet'];
						if( !isset($internet_package[$operator][$sim_type][$in_type][$pid]) ){
							$error_msg = " محصول مورد نظر یافت نشد";
						}else{
							$rrr = $internet_package[$operator][$sim_type][$in_type][$pid];
							$product_amount = $rrr['amount'];
							$product_name 	= $rrr['name'];
							$product_id 	= $rrr['id'];
							
							$smarty->assign('product_id',$product_id);
							$smarty->assign('product_name',$product_name);	
							$smarty->assign('product_amount',$product_amount);
							$smarty->assign('buy_internet',true);
							
							$smarty->assign('internet_type',$in_type);
							$smarty->assign('sim_type',$sim_type);
							$smarty->assign('product_find',true);
						}
					}
				}else{
					$error_msg= $result['msg'];
				}
			}else{
				$error_msg = "لطفا کمی بعد دوباره تلاش نمائید";
			}
		}
	}else{
		$smarty->assign('select_operator',true);
	}


	//ارسال فرم خرید
	if( isset($_POST['submit']) &&  (isset($_GET['MTN']) || isset($_GET['MCI']) || isset($_GET['RTL'])) &&  isset($_GET['pid']) && $_GET['pid']!='' && isset($_GET['sim']) && ($_GET['sim']=='credit' || $_GET['sim']=='permanent' ) && isset($_GET['i']) && ($_GET['i']=='hourly' || $_GET['i']=='daily' || $_GET['i']=='weekly' || $_GET['i']=='monthly' || $_GET['i']=='yearly' || $_GET['i']=='amazing' || $_GET['i']=='TDLTE' ) ){
		
		check_admin_referer( 'name_of_my_action', 'Token' );//wordpress
		
		$pid 		= filter($_GET['pid']);
		$sim_type 	= filter($_GET['sim']);
		$in_type 	= filter($_GET['i']);
		
		/*if(isset($_GET['MTN'])){
			$provider= 'novinways';
		}else{
			$provider= 'elkapos';
		}*/
		
		//$error_msg = 'این بخش در حال بروز رسانی می باشد';
		
		if(isset($_GET['MTN']) ){ $operator = 'MTN';	} elseif(isset($_GET['MCI'])){ $operator = 'MCI';	} elseif(isset($_GET['RTL'])){ $operator = 'RTL';	}
		
		if(isset($_POST['mobile']) && $_POST['mobile']!='' ){ $mobile = filter($_POST['mobile'],'number'); } else {	$mobile ='';		}
		if(isset($_POST['amount']) && $_POST['amount']!='' ){ $amount = filter($_POST['amount']); } else {	$amount ='';		}
		if(isset($_POST['description']) && $_POST['description']!='' ){ $description = filter($_POST['description']); } else {	$description ='';	}
		if(isset($_POST['failed_trans_id']) && $_POST['failed_trans_id']!='' ){ $failed_trans_id = filter($_POST['failed_trans_id']); } else {	$failed_trans_id ='';	}
		
		$operator_fa 	= operator_fa($operator);
		
		$mobile = convert_fa_to_en($mobile);
		
		//بررسی در شماره های مسدود شده
		/*$baned_mobile_rows 	= $mysqli->query("SELECT id FROM baned_mobile WHERE mobile='$mobile' ")->fetch_assoc();
		if(isset($baned_mobile_rows['id'])){
			$baned_mobile=true;
		}*/
		
		if($change_hours){//تغییر ساعات رسمی کشور
			$error_msg 	= 'به علت تغییر در ساعات رسمی کشور، درگاه های بانکی فعال نمی باشد، لطفا ساعتی بعد مراجعه نمائید.';
		}elseif($mobile == ""){
			$error_msg = 'شماره موبایل را وارد کنید !';
		}
		elseif( isset($is_admin) && $description == ""){
			$error_msg = 'توضیحات را وارد نمائید';
		}
		elseif(!$validate->Mobile($mobile)){
			$error_msg = 'شماره موبایل صحیح نیست !';
			//|| $mobile=='09218413696'
		}/*elseif($mobile=='09039484146' || $mobile=='09019172185' ){//تلاش برای دئریافت بسته با هک - 09019172185
			$error_msg = 'امکان خرید بسته برای این شماره وجود ندارد';
		}*/
		elseif ( isset($baned_mobile) ){
			$error_msg = 'امکان خرید بسته برای این شماره وجود ندارد';
		}
		else{
			$result = RequestJson_Last('get_products',array(), 'inax');
			if( isset($result) && $result!=false ){
				if($result['code']==1){
					$pro = $result['products'];
					if( !isset($pro['internet']) ){
						$error_msg = "خطا در دریافت بسته های اینترنتی... لطفا دوباره تلاش کنید.";
					}else{
						$internet_package = $pro['internet'];
						//print_r($internet_package);
						
						if( !isset($internet_package[$operator][$sim_type][$in_type][$pid]) ){
							$error_msg = " محصول مورد نظر یافت نشد";
						}else{
							$rrr = $internet_package[$operator][$sim_type][$in_type][$pid];
							//print_r($rrr);
							$amount 		= $rrr['amount'];
							$product_name 	= $rrr['name'];
							$product_id 	= $rrr['id'];
							//exit;
							
							$date = time();
							$client_id=0;
							
							$sql= $mysqli->query("INSERT INTO wp_inax_charge (client_id, type, platform ,mobile, product_type, amount,date) VALUES ('$client_id', 'internet', 'client_area' , '$mobile', '$operator', '$amount', '$date') " );
							$status = 'unpaid';
							$ref_code  = $res_code = '';
							
							if($sql){
								$charge_id	= $mysqli->insert_id;
								
								$payment_type='online';
									
								$error_msg = 'خطای نامعلوم';

								$get_permalink = esc_url( get_permalink() );
								$callback = "{$get_permalink}?list&id=$charge_id";
								$param = array(
									'product'		=> 'internet',
									'amount'		=> $amount,
									'internet_type'	=> $in_type,
									'sim_type'		=> $sim_type,
									'product_id'	=> $product_id,
									'mobile'		=> $mobile,
									'operator'		=> $operator,
									'order_id'		=> $charge_id,
									'callback'		=> $callback,
								);
								//print_r($param);
								$result = RequestJson_Last('invoice',$param, 'inax');
								
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
					}
				}else{
					$error_msg= $result['msg'];
				}
			}else{
				$error_msg = "لطفا کمی بعد دوباره تلاش نمائید";
			}
		}
	} //-->submit
	
	if(isset($_GET['id'])){
		$smarty->assign('internet_result',true);
		$smarty->assign('internet_mtn',null);
		$smarty->assign('internet_mci',null);
		$smarty->assign('internet_rtl',null);
		
		$tran_id = filter($_GET['id'],'get_int');
		$trans_rows 	= $mysqli->query("SELECT * FROM transaction WHERE id='$tran_id' and client_id='$client_id' and product='internet' and type='$reseller_type' ")->fetch_assoc();
		if(isset($trans_rows['id'])){
			$status = $trans_rows['status'];
			if($status == 'paid'){
				$mobile 	= $trans_rows['mobile'];
				$refcode 	= $trans_rows['refcode'];
				$amount 	= $trans_rows['amount'];
				$pay_time 	= jdate('Y/m/d ساعت H:i:s', strtotime($trans_rows['pay_date']) );
				$success_msg = "تراکنش با موفقیت پرداخت گردید. <br/>";
				/*شناسه قبض: {$bill_id} <br/>
				شناسه پرداخت: {$pay_id} <br/>
				رسید بانکی تراکنش: {$refcode} <br/>
				شماره پیگیری پرداخت قبض: {$ref_code} <br/>
				تاریخ واریز: {$pay_time}";*/
				
				//if($operator == 'MTN'){$operator_fa ='ایرانسل'; }elseif($operator == 'MCI'){$operator_fa ='همراه اول'; }elseif($operator == 'RTL'){$operator_fa ='رایتل'; }
								
				$pay_result['message'] 		= $success_msg;
				$pay_result['mobile'] 		= $mobile;
				//$pay_result['operator_fa']	= $operator_fa;
				$pay_result['amount'] 		= $amount;
				$pay_result['refcode'] 		= $refcode;
				$smarty->append('pay_result',$pay_result);
			}else{
				$error_msg = 'تراکنش پرداخت نشده است !';
			}
		}else{
			$error_msg = 'شناسه خرید اشتباه است !';
		}
	}
}

if(isset($error_msg)){$smarty->assign('error_msg',$error_msg);}
if(isset($success_msg)){$smarty->assign('success_msg',$success_msg);}
$smarty->display( dirname( __FILE__ ) . '/templates/internet.tpl');
?>