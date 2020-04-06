{include file="header.tpl"}

	<div class="row">
		<div class="col-lg-12">

			{if (isset($select_operator) && !isset($internet_result)) }
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> {$title} <!--{*if isset($logged_in) && $logged_in*}<a class="btn btn-primary btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> گزارش خرید بسته های اینترنتی</a>{*/if*}--></div>
				<div class="panel-body">
				
					<div class="alert alert-info">لطفا از بخش زیر، اپراتور تلفن همراهی که قصد خرید بسته اینترنت برای آن را دارید انتخاب نمائید</div>
						
					<div class="col-lg-4 col-md-5 text-center">
						<div class="panel panel-default">
							<a href="?MTN">
								<div class="panel-footer" >
									<span class="text-center"><img src="{$plugins_img_url}/mtn_internet.jpg" /></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					
					<div class="col-lg-4 col-md-5 text-center">
						<div class="panel panel-default">
							<a href="?MCI">
								<div class="panel-footer" >
									<span class="text-center"><img src="{$plugins_img_url}/mci_internet.jpg" /></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					
					<div class="col-lg-4 col-md-5 text-center">
						<div class="panel panel-default">
							<a href="?RTL">
								<div class="panel-footer" >
									<span class="text-center"><img src="{$plugins_img_url}/rtl_internet.jpg" /></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					
				</div>
			</div>
			{/if}
			
			{if isset($request_sim_type) && $request_sim_type }
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> {$title} <!--{*if isset($logged_in) && $logged_in*}<a class="btn btn-primary btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> گزارش خرید بسته های اینترنتی</a>{*/if*}--></div>
				<div class="panel-body">
				
					<div class="alert alert-info">لطفا نوع سیم کارت تلفن همراهی که قصد خرید بسته اینترنت برای آن را دارید انتخاب نمائید:</div>
						
					<div class="col-lg-6 col-md-6 text-center">
						<div class="panel panel-default">
							<a href="?{$operator}&sim=credit">
								<div class="panel-footer" >
									<span class="text-center"><img src="{$plugins_img_url}/sim_type_credit.jpg" /></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 text-center">
						<div class="panel panel-default">
							<a href="?{$operator}&sim=permanent">
								<div class="panel-footer" >
									<span class="text-center"><img src="{$plugins_img_url}/sim_type_permanent.jpg" /></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			{/if}
			
			{if isset($package_list) && $package_list }
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> {$title} <!--{*if isset($logged_in) && $logged_in*}<a class="btn btn-primary btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> گزارش خرید بسته های اینترنتی</a>{*/if*}--></div>
				<div class="panel-body">
				
					{if isset($success_msg) }<div class="alert alert-success">{$success_msg}</div>{/if}
					{if isset($error_msg) }<div class="alert alert-danger">{$error_msg}</div>{/if}
				
					{if !isset($error_msg) }
					<div class="alert alert-info">لطفا نوع بسته اینترنت را انتخاب نمائید</div>
						
					{if isset($have_package)}
					{foreach from=$have_package key=key item=link}
					
					<div class="panel-group" id="accordion">
						<div class="panel panel-warning service_status">
							<a class="{if $link@first }{else}collapsed{/if}" data-toggle="collapse" data-parent="#accordion" href="#collapse_{$link.type_en}">
								<div class="panel-heading">
									<h4 class="panel-title" style="font-size: 13px !important;font-family: iransans_medium;">
										<i class="fa fa-leaf fa-fw" style="vertical-align: -3px;font-size: 16px;"></i> {$link.type_fa} <i class="fa fa-chevron-down fa-fw" style="float:left;"></i>
									</h4>
								</div>
							</a>
							<div id="collapse_{$link.type_en}" style="{if $link@first }{else}height:0px;{/if}" class="panel-collapse collapse {if $link@first }in{/if}" style="height: 0px;">
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover listtable" style="border-collapse: separate;border:1px solid #BCBCBC;border-radius:7px !important;">
											<thead>
												<tr>
													<td colspan="3" class="text-right fa_num">تعداد بسته های موجود {$link.lists2|count} </span></td>
												</tr>
												<tr>
													<th class="ths" >ردیف</th>
													<th class="ths" >نام بسته</th>
													<th class="ths">قیمت</th>
													<th class="ths">دکمه خرید</th>
												</tr>
											</thead>
											<tbody>

											{if isset($link.lists2 )}
											{foreach from=$link.lists2 key=key2 item=link2}
											
												{*$link.lists2|print_r*}
												{*$link2@key*}
												{*$key2*}
											
												<tr>
													<td class="text-center fa_num" style="padding: 13px 3px 11px 3px !important;">  {$link2@iteration }</td>
													<td class="text-center fa_num" style="padding: 13px 3px 11px 3px !important;">  {$link2.name}</td>
													<td class="text-center fa_num text-warning" style="padding: 13px 3px 11px 3px !important;"> {$link2.amount|number_format} تومان</td>
													<td class="text-center fa_num" style="padding: 13px 3px 11px 3px !important;"><a href="?{$operator}&sim={$sim_type}&i={$link.type_en}&pid={$link2.id}" style="color:white;" class="btn btn-warning btn-sm" >خرید آنلاین</a></td>
												</tr>
											{/foreach}
											{else}
												<tr>
													<td colspan="3" class="text-center">بسته ای یافت نشد</td>
												</tr>
											{/if}
											
											
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div style="clear:both"></div>
						</div>
					</div>
					{/foreach}
					{/if}
					{/if}
					 
				</div>
			</div>
			{/if}

			{if  isset($enter_mobile) }
			<div class="panel panel-{if $operator eq 'MTN' }yellow{elseif $operator eq 'MCI' }primary{elseif $operator eq 'RTL' }danger{/if}">	
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> خرید بسته اینترنت {if $operator eq 'MTN' }ایرانسل{elseif $operator eq 'MCI' }همراه اول{elseif $operator eq 'RTL' }رایتل{/if} <!--{*if isset($logged_in) && $logged_in*}<a class="btn btn-default btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> گزارش خرید بسته های اینترنتی</a>{*/if*}--></div>
				<div class="panel-body">
				
				{if isset($pay_code)}
				<script src="{$plugins_url}/js/clients/fakeLoader.js"></script>
				<link href="{$plugins_url}/css/clients/fakeLoader.css" rel="stylesheet">

					<style>
					.dot1{
						{if $gateway eq 'mellat' || $gateway eq 'city'}
							background-color: #ee4a52 !important;
						{elseif $gateway eq 'saman' || $gateway eq 'parsian'}
							background-color: #6ea8ff !important;
						{elseif $gateway eq 'pasargad'}
							background-color: #efc316 !important;
						{elseif $gateway eq 'melli'}
							background-color: #a1dd8d !important;
						{/if}
					}
					.dot2 {
						{if $gateway eq 'mellat' || $gateway eq 'city'}
							background-color: #c92f37 !important;
						{elseif $gateway eq 'saman' || $gateway eq 'parsian'}
							background-color: #428bca !important;
						{elseif $gateway eq 'pasargad'}
							background-color: #efc316 !important;
						{elseif $gateway eq 'melli'}
							background-color: #7fba6b !important;
						{/if}
					}
					</style>
					<div class="fakeloader"></div>
					<script>
						$(document).ready(function(){
							$(".fakeloader").fakeLoader({
								spinner:"spinner3"
							});
						});
					</script>
					{$pay_code}
				{else}
					
					{if isset($error_msg) }<div class="alert alert-danger">{$error_msg}</div>{/if}
					
					{if isset($product_find) }
					<div class="alert alert-info">لطفا در فیلد زیر شماره تلفنی که قصد دارید بسته اینترنتی را برای آن خریداری نمائید را وارد کنید:</div>
					<div class="table-responsive">
						
						<form action="?{$operator}&sim={$sim_type}&i={$internet_type}&pid={$product_id}" method="POST" >
							{$wordpress_csrf}
							
							<table class="table table-striped table-hover text-center" >
								<tr>
									<td></td>
									<td>
										خرید بسته {$product_name}
									</td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td>
										مبلغ بسته {$product_amount|number_format} تومان
									</td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<div class="form-group has-warning input-group">
											<input type="text" maxlength="11" placeholder="شماره تلفن همراه" dir="ltr" class="form-control" autocomplete="off" name="mobile" value="{if isset($smarty.post.mobile)}{$smarty.post.mobile}{elseif isset($mobile)}{$mobile}{else}{/if}" tabindex="1" required/>
											<span class="input-group-addon"><i class="fa fa-phone fa-fw fa-1x"></i></span>
										</div>
									</td>
									<td></td>
								</tr>
								{if isset($is_admin) }
								<tr>
									<td>شماره تراکنش ناموفق</td>
									<td>
										<input type="text" maxlength="11" dir="ltr" class="form-control" name="failed_trans_id" value="{if isset($smarty.post.failed_trans_id)}{$smarty.post.failed_trans_id}{/if}" />
									</td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<textarea  class="form-control" placeholder="توضیحات در درابطه با علت خرید" name="description" >{if isset($smarty.post.description)}{$smarty.post.description}{/if}</textarea>
									</td>
									<td></td>
								</tr>
								{/if}
								<tr>
									<td></td>
									<td><button class="btn btn-success form-control" name="submit" type="submit"><i class="fa fa-check"></i> پرداخت و فعالسازی بسته اینترنتی</button></td>
									<td></td>
								</tr>
							</table>
						</form>
					</div>
					{/if}
				{/if}
				</div>
			</div>
			{/if}
			
			{if isset($internet_result) }
			<div class="panel panel-yellow">	
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> نتیجه خرید <!--{*if isset($logged_in) && $logged_in*}<a class="btn btn-default btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> گزارش خرید بسته های اینترنتی</a>{*/if*}--></div>
				<div class="panel-body">
					
					{if isset($success_msg) }<div class="alert alert-success">{$success_msg}</div>{/if}
					{if isset($error_msg) }<div class="alert alert-danger">{$error_msg}</div>{/if}
				
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" >
						{if isset($pay_result)}
							{foreach from=$pay_result key=key item=link}
							<tr><th>موبایل</th><td>{$link.mobile}</td></tr>
							<tr><th>مبلغ</th><td>{$link.amount|number_format} تومان</td></tr>
							<tr><th>نتیجه </th><td>{$link.message}</td></tr>
							<tr><th>رسید</th><td>{$link.refcode}</td></tr>
						{/foreach}
						{/if}
						</table>
					</div>
				</div>
			</div>
			{/if}
			
			{if isset($internet_list) }
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> {$title} <a class="btn btn-primary btn-xs btn-left" href="./">بازگشت <i class="fa fa-arrow-left fa-fw"></i> </a></div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover listtable">
							<thead>
								<tr>
									<th class="ths" >شناسه تراکنش</th>
									<th class="ths" >موبایل</th>
									<th class="ths" >اپراتور</th>
									<th class="ths" >مبلغ</th>
									<th class="ths" >رسید</th>
									<th class="ths" >تاریخ</th>
									<th class="ths" >وضعیت</th>
								</tr>
							</thead>
							<tbody>
							{if isset($internet_rows)}
							{foreach from=$internet_rows key=key item=link}
								<tr>
									<td class="text-center"><a href="?id={$link.id}" target="_blank">{$link.id}</a></td>
									<td class="text-center">{$link.mobile}</td>
									<td class="text-center">
									{if $link.product_type eq 'MTN'}<span class="btn-warning btn-xs" >ایرانسل</span>
									{elseif $link.product_type eq 'MCI'}<span class="btn-info btn-xs" >همراه اول</span>
									{elseif $link.product_type eq 'RTL'}<span class="btn-danger btn-xs" >رایتل</span>
									{else}{$link.product_type}
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
									<td colspan="8" class="text-center">هیچ بسته اینترنتی خریداری نشده است.</td>
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