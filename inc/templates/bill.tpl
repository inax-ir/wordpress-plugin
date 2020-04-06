{include file="header.tpl"}

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">	

			{if isset($pay_bill)  }
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> {$title} <!--<a class="btn btn-default btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> لیست قبض ها</a>--></div>
				<div class="panel-body">
				
				<div class="alert alert-info">- توسط این بخش می توانید نسبت به پرداخت قبوض آب، برق، گاز، تلفن همراه، تلفن ثابت ثابت، عوارض شهرداری، سازمان مالیات و جریمه راهنمایی و رانندگی اقدام کنید..</div>
				
					{if isset($error_msg) }<div class="alert alert-danger">{$error_msg}</div>{/if}
				
					<div class="table-responsive">
						<table class="table table-striped table-hover table-bordered" >
							<tr>
								<th>شناسه قبض</th>
								<td><input type="tel" name="bill_id" dir="auto" id="bill_id" maxlength="20" class="myform-control" value="{if isset($smarty.post.bill_id)}{$smarty.post.bill_id}{/if}" size="35" required/></td>
							</tr>
							<tr>
								<th>شناسه پرداخت</th>
								<td><input type="tel" name="pay_id" dir="auto" id="pay_id" maxlength="20" class="myform-control" value="{if isset($smarty.post.pay_id)}{$smarty.post.pay_id}{/if}" size="35" required/></td>
							</tr>
							<tr>
								<th>شماره موبایل</th>
								<td><input type="tel" name="mobile" dir="auto" id="mobile" maxlength="11" class="myform-control" value="{if isset($smarty.post.mobile)}{$smarty.post.mobile}{/if}" size="35" required/> (جهت پشتیبانی در صورت بروز مشکل)</td>
							</tr>
							<tr>
								<th></th>
								<td><button class="btn btn-primary btn-sm" type="button" onclick="check_bill();return false;" ><i class="fa fa-check"></i> بررسی اطلاعات</button></td>
							</tr>
						</table>
					</div>
					{literal}
					<script>
					//
					</script>
					{/literal}
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title" id="myModalLabel">بررسی اطلاعات</h4>
								</div>
								<div class="modal-body">
									<div class="table-responsive">
										<div id="modal_loading" style="text-align:center;padding:20px 0px 20px 0px;">
											در حال بررسی اطلاعات ...<br/>
											<img src="{$plugins_img_url}/loader.gif" />
										</div>
										<table id="modal_result" class="table table-bordered " style="display:none;">
											<tr id="tr1" style="display:none">
												<th class="myth" >نوع قبض</th>
												<td><span class="display_bill_type" ></span>
											</td>
											</tr>
											<tr id="tr2" style="display:none">
												<th class="myth" >مبلغ</th>
												<td><span class="display_bill_amount" ></span></td>
											</tr>
											<tr id="tr5" style="display:none">
												<th class="myth" >نحوه پرداخت</th>
												<td><span class="display_pay_type" ></span></td>
											</tr>
											<tr id="error" style="display:none">
												<th class="myth" > خطا</th>
												<td><span class="display_error_msg" ></span></td>
											</tr>
											<tr id="tr3" style="display:none">
												<th class="myth" ></th>
												<td>
													<form action="./" method="POST" >
														{$wordpress_csrf}
														
														<input type="hidden" class='bill_dbid' name="bill_dbid" value="">
														
														<button class="btn btn-success btn-sm" name="pay_submit" type="submit"><i class="fa fa-check"></i> پرداخت</button>
													</form>
												</td>
											</tr>
										</table>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div>
				</div>
			{/if}

			{if isset($bill_result) }
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> نتیجه خرید <!--<a class="btn btn-default btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> لیست قبض ها</a>--></div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover text-center" >
						{if isset($pay_result)}
							{foreach from=$pay_result key=key item=link}
							<tr><th>نتیجه </th><td>{$link.Status}</td></tr>
							<tr><th>پیام</th><td>{$link.Message}</td></tr>
							<tr><th>پین کد</th><td>{$link.Pin}</td></tr>
							<tr><th>شماره سفارش</th><td>{$link.OrderID}</td></tr>
							<tr><th>مبلغ</th><td>{$link.PaymentValue|number_format}</td></tr>
						{/foreach}
						{/if}
						</table>
					</div>
				</div>
			{/if}
			
			{if isset($bill_list) }
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> {$title} <a class="btn btn-primary btn-xs btn-left" href="./">بازگشت <i class="fa fa-arrow-left fa-fw"></i> </a></div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover listtable">
							<thead>
								<tr>
									<th class="ths" >شناسه تراکنش</th>
									<th class="ths" >نوع قبض</th>
									<th class="ths" >شناسه قبض</th>
									<th class="ths" >شناسه پرداخت</th>
									<th class="ths" >مبلغ</th>
									<th class="ths" >تاریخ ایجاد</th>
									<th class="ths" >تاریخ پرداخت</th>
									<th class="ths" >شماره پیگیری</th>
									<th class="ths" >وضعیت</th>
								</tr>
							</thead>
							<tbody>
							{if isset($rows_bill)}
							{foreach from=$rows_bill key=key item=link}
								<tr>
									<td class="text-center">{$link.id}</td>
									<td class="text-center">{$link.bill_type|bill_type}</td>
									<td class="text-center">{$link.bill_id}</td>
									<td class="text-center">{$link.pay_id}</td>
									<td class="text-center">{$link.amount|number_format} ریال</td>
									<td class="text-center fa_num">{$link.date|jdate_format}</td>
									<td class="text-center fa_num">{if $link.pay_date neq 0}{$link.pay_date|jdate_format}{else}- - -{/if}</td>
									<td class="text-center">{$link.refcode}</td>
									<td class="text-center">
										{if $link.status eq 'paid'}<span class="btn-success btn-xs" ><i class="fa fa-check" ></i> پرداخت شده</span>
										{else}<span class="btn-danger btn-xs" ><i class="fa fa-close" ></i> پرداخت نشده</span>
										{/if}
									</td>
								</tr>
							{/foreach}
							{else}
								<tr>
									<td colspan="9" class="text-center">موردی جهت نمایش وجود ندارد</td>
								</tr>
							{/if}
							</tbody>
						</table>
					</div>
				</div>
			{/if}

			</div><!-- /.panel -->
		</div>
	</div>

{include file="footer.tpl"}