{include file="header.tpl"}

	<div class="row">
		<div class="col-lg-12">

			{if isset($buy_pin) && !isset($mtn_active)  && !isset($mci_active) && !isset($rtl_active) && !isset($bill_active) && !isset($pin_result) }
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> {$title} <!--<a class="btn btn-primary btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> شارژ های خریداری شده</a>--></div>
				<div class="panel-body">
				
					<div class="alert alert-info">برای شارژ مستقیم سیم کارت خود لطفا از بخش زیر نسبت به انتخاب اپراتور اقدام نمائید.</div>
					
					<div class="col-lg-4 col-md-5 text-center">
						<div class="panel panel-default">
							<a href="?MTN">
								<div class="panel-footer" >
									<span class="text-center"><img src="{$plugins_img_url}/mtn.jpg" /></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-lg-4 col-md-5 text-center">
						<div class="panel panel-default">
							<a href="?MCI">
								<div class="panel-footer" >
									<span class="text-center"><img src="{$plugins_img_url}/mci.jpg" /></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-lg-4 col-md-5 text-center">
						<div class="panel panel-default">
							<a href="?RTL">
								<div class="panel-footer" >
									<span class="text-center"><img src="{$plugins_img_url}/rtl.jpg" /></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>

				</div>
			</div>
			{/if}
			

			{if isset($mtn_active)  || isset($mci_active) || isset($rtl_active) }
			<div class="panel panel-{if isset($mtn_active) }yellow{elseif isset($mci_active)}primary{elseif isset($rtl_active)}danger{/if}">	
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> خرید شارژ اعتباری {if isset($mtn_active) }ایرانسل{elseif isset($mci_active)}همراه اول{elseif isset($rtl_active)}رایتل{/if} <!--<a class="btn btn-default btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> شارژ های خریداری شده</a>--></div>
				<div class="panel-body">
				
					<div class="alert alert-info">لطفا از بخش زیر شماره تلفن و مبلغ شارژ را وارد نمائید</div>
					
					{if isset($error_msg) }<div class="alert alert-danger">{$error_msg}</div>{/if}
					<div class="table-responsive">
						
						<form action="?{if isset($mtn_active) }MTN{elseif isset($mci_active)}MCI{elseif isset($rtl_active)}RTL{/if}" method="POST" >
							{$wordpress_csrf}
							
							<table class="table table-striped table-hover text-center" >
								<tr>
									<td></td>
									<td>
										<div class="form-group has-warning input-group">
											<input type="text" maxlength="11" placeholder="شماره تلفن همراه" dir="ltr" class="form-control" name="mobile" value="{if isset($smarty.post.mobile)}{$smarty.post.mobile}{else}{$phonenumber}{/if}" tabindex="1" required/>
											<span class="input-group-addon"><i class="fa fa-phone fa-fw fa-1x"></i></span>
										</div>
									</td>
									<td></td>
								</tr>
								<tr>
									<td>{if isset($mci_active) }<input type="radio" name="amount" value="1000" id="1000" {if isset($smarty.post.amount) && $smarty.post.amount eq '1000' }checked{/if} required/> <label for="1000"> شارژ {if isset($mtn_active) }ایرانسل{elseif isset($mci_active)}همراه اول{elseif isset($rtl_active)}رایتل{/if} <span class="fa_num">1,000</span> تومانی</label>{/if}</td>
									<td><input type="radio" name="amount" value="2000" id="2000" {if isset($smarty.post.amount) && $smarty.post.amount eq '2000' }checked{/if} required/> <label for="2000"> شارژ {if isset($mtn_active) }ایرانسل{elseif isset($mci_active)}همراه اول{elseif isset($rtl_active)}رایتل{/if} <span class="fa_num">2,000</span> تومانی</label></td>
									<td><input type="radio" name="amount" value="5000" id="5000" {if isset($smarty.post.amount) && $smarty.post.amount eq '5000' }checked{/if} required/> <label for="5000"> شارژ {if isset($mtn_active) }ایرانسل{elseif isset($mci_active)}همراه اول{elseif isset($rtl_active)}رایتل{/if} <span class="fa_num">5,000</span> تومانی</label></td>
								</tr>
								<tr>
									<td><input type="radio" name="amount" value="10000" id="10000" {if isset($smarty.post.amount) && $smarty.post.amount eq '10000' }checked{/if} required/> <label for="10000"> شارژ {if isset($mtn_active) }ایرانسل{elseif isset($mci_active)}همراه اول{elseif isset($rtl_active)}رایتل{/if} <span class="fa_num">10,000</span> تومانی</label></td>
									<td><input type="radio" name="amount" value="20000" id="20000" {if isset($smarty.post.amount) && $smarty.post.amount eq '20000' }checked{/if} required/> <label for="20000"> شارژ {if isset($mtn_active) }ایرانسل{elseif isset($mci_active)}همراه اول{elseif isset($rtl_active)}رایتل{/if} <span class="fa_num">20,000</span> تومانی</label></td>
									<td></td>
								</tr>
								<!--<tr>
									<td><input type="radio" name="amount" value="30000" id="30000" {if isset($smarty.post.amount) && $smarty.post.amount eq '30000' }checked{/if} required/> <label for="30000"> شارژ {if isset($mtn_active) }ایرانسل{elseif isset($mci_active)}همراه اول{elseif isset($rtl_active)}رایتل{/if} <span class="fa_num">30,000</span> تومانی</label></td>
									<td><input type="radio" name="amount" value="40000" id="40000" {if isset($smarty.post.amount) && $smarty.post.amount eq '40000' }checked{/if} required/> <label for="40000"> شارژ {if isset($mtn_active) }ایرانسل{elseif isset($mci_active)}همراه اول{elseif isset($rtl_active)}رایتل{/if} <span class="fa_num">40,000</span> تومانی</label></td>
									<td><input type="radio" name="amount" value="50000" id="50000" {if isset($smarty.post.amount) && $smarty.post.amount eq '50000' }checked{/if} required/> <label for="50000"> شارژ {if isset($mtn_active) }ایرانسل{elseif isset($mci_active)}همراه اول{elseif isset($rtl_active)}رایتل{/if} <span class="fa_num">50,000</span> تومانی</label></td>
								</tr>-->

								<tr>
									<td></td>
									<td><button class="btn btn-success form-control" name="submit" type="submit"><i class="fa fa-check"></i> پرداخت و شارژ مستقیم سیم کارت</button></td>
									<td></td>
								</tr>
							</table>
						</form>
						
					</div>
				</div>
			</div>
			{/if}
			
			{if isset($pin_result) }
			<div class="panel panel-yellow">	
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> نتیجه خرید <!--<a class="btn btn-default btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> شارژ های خریداری شده</a>--></div>
				<div class="panel-body">
					
					{if isset($success_msg) }<div class="alert alert-success">{$success_msg}</div>{/if}
					{if isset($error_msg) }<div class="alert alert-danger">{$error_msg}</div>{/if}
				
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" >
						{if isset($pay_result)}
							{foreach from=$pay_result key=key item=link}
							<tr><th>موبایل</th><td>{$link.mobile}</td></tr>
							<tr><th>اپراتور</th><td>{$link.operator_fa}</td></tr>
							<tr><th>مبلغ شارژ</th><td>{$link.amount|number_format} تومان</td></tr>
							<tr><th>کارت ها</th><td>{$link.buyed_output}</td></tr>
							<tr><th>نتیجه </th><td>{$link.message}</td></tr>
							<tr><th>رسید</th><td>{$link.ref_code}</td></tr>
						{/foreach}
						{/if}
						</table>
					</div>
				</div>
			</div>
			{/if}
			
			{if isset($pin_list) }
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> {$title} <a class="btn btn-primary btn-xs btn-left" href="./">بازگشت <i class="fa fa-arrow-left fa-fw"></i> </a></div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover listtable">
							<thead>
								<tr>
									<th class="ths" >موبایل</th>
									<th class="ths" >نوع شارژ</th>
									<th class="ths" >مبلغ</th>
									<th class="ths" >رسید</th>
									<th class="ths" >تاریخ</th>
									<th class="ths" >وضعیت</th>
								</tr>
							</thead>
							<tbody>
							{if isset($pin_rows)}
							{foreach from=$pin_rows key=key item=link}
								<tr>
									<td class="text-center">{$link.mobile}</td>
									<td class="text-center">
									{if $link.product_type eq 'MTN'}<span class="btn-warning btn-xs" >ایرانسل</span>
									{elseif $link.product_type eq 'MCI'}<span class="btn-info btn-xs" >همراه اول</span>
									{elseif $link.product_type eq 'RTL'}<span class="btn-danger btn-xs" >رایتل</span>
									{/if}
									</td>
									<td class="text-center">{$link.amount|number_format} تومان</td>
									<td class="text-center">{$link.ref_code}</td>
									<td class="text-center">{$link.date|jdate_format}</td>
									<td class="text-center">
									{if $link.status eq 'paid'}<span class="btn-success btn-xs" ><i class="fa fa-check" ></i> موفق</span>
									{else}<span class="btn-danger btn-xs" ><i class="fa fa-close" ></i> ناموفق</span>
									{/if}
									</td>
								</tr>
							{/foreach}
							{else}
								<tr>
									<td colspan="6" class="text-center">هیچ شارژی خریداری نشده است.</td>
								</tr>
							{/if}
							</tbody>
						</table>
					</div>
				</div>
			</div>
			{/if}

		</div>
	</div>

{include file="footer.tpl"}