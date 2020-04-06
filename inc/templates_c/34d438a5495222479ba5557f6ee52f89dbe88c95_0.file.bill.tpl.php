<?php
/* Smarty version 3.1.33, created on 2020-04-05 23:22:03
  from 'D:\xampp\htdocs\wordpress\wp-content\plugins\inax\inc\templates\bill.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5e8a28d3f09b17_97266046',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '34d438a5495222479ba5557f6ee52f89dbe88c95' => 
    array (
      0 => 'D:\\xampp\\htdocs\\wordpress\\wp-content\\plugins\\inax\\inc\\templates\\bill.tpl',
      1 => 1586061075,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5e8a28d3f09b17_97266046 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">	

			<?php if (isset($_smarty_tpl->tpl_vars['pay_bill']->value)) {?>
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 <!--<a class="btn btn-default btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> لیست قبض ها</a>--></div>
				<div class="panel-body">
				
				<div class="alert alert-info">- توسط این بخش می توانید نسبت به پرداخت قبوض آب، برق، گاز، تلفن همراه، تلفن ثابت ثابت، عوارض شهرداری، سازمان مالیات و جریمه راهنمایی و رانندگی اقدام کنید..</div>
				
					<?php if (isset($_smarty_tpl->tpl_vars['error_msg']->value)) {?><div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['error_msg']->value;?>
</div><?php }?>
				
					<div class="table-responsive">
						<table class="table table-striped table-hover table-bordered" >
							<tr>
								<th>شناسه قبض</th>
								<td><input type="tel" name="bill_id" dir="auto" id="bill_id" maxlength="20" class="myform-control" value="<?php if (isset($_POST['bill_id'])) {
echo $_POST['bill_id'];
}?>" size="35" required/></td>
							</tr>
							<tr>
								<th>شناسه پرداخت</th>
								<td><input type="tel" name="pay_id" dir="auto" id="pay_id" maxlength="20" class="myform-control" value="<?php if (isset($_POST['pay_id'])) {
echo $_POST['pay_id'];
}?>" size="35" required/></td>
							</tr>
							<tr>
								<th>شماره موبایل</th>
								<td><input type="tel" name="mobile" dir="auto" id="mobile" maxlength="11" class="myform-control" value="<?php if (isset($_POST['mobile'])) {
echo $_POST['mobile'];
}?>" size="35" required/> (جهت پشتیبانی در صورت بروز مشکل)</td>
							</tr>
							<tr>
								<th></th>
								<td><button class="btn btn-primary btn-sm" type="button" onclick="check_bill();return false;" ><i class="fa fa-check"></i> بررسی اطلاعات</button></td>
							</tr>
						</table>
					</div>
					
					<?php echo '<script'; ?>
>
					//
					<?php echo '</script'; ?>
>
					
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
											<img src="<?php echo $_smarty_tpl->tpl_vars['plugins_img_url']->value;?>
/loader.gif" />
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
														<?php echo $_smarty_tpl->tpl_vars['wordpress_csrf']->value;?>

														
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
			<?php }?>

			<?php if (isset($_smarty_tpl->tpl_vars['bill_result']->value)) {?>
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> نتیجه خرید <!--<a class="btn btn-default btn-xs btn-left" href="./?list"><i class="fa fa-database fa-fw"></i> لیست قبض ها</a>--></div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover text-center" >
						<?php if (isset($_smarty_tpl->tpl_vars['pay_result']->value)) {?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pay_result']->value, 'link', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['link']->value) {
?>
							<tr><th>نتیجه </th><td><?php echo $_smarty_tpl->tpl_vars['link']->value['Status'];?>
</td></tr>
							<tr><th>پیام</th><td><?php echo $_smarty_tpl->tpl_vars['link']->value['Message'];?>
</td></tr>
							<tr><th>پین کد</th><td><?php echo $_smarty_tpl->tpl_vars['link']->value['Pin'];?>
</td></tr>
							<tr><th>شماره سفارش</th><td><?php echo $_smarty_tpl->tpl_vars['link']->value['OrderID'];?>
</td></tr>
							<tr><th>مبلغ</th><td><?php echo number_format($_smarty_tpl->tpl_vars['link']->value['PaymentValue']);?>
</td></tr>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						<?php }?>
						</table>
					</div>
				</div>
			<?php }?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['bill_list']->value)) {?>
				<div class="panel-heading"><i class="fa fa-sitemap fa-fw"></i> <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 <a class="btn btn-primary btn-xs btn-left" href="./">بازگشت <i class="fa fa-arrow-left fa-fw"></i> </a></div>
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
							<?php if (isset($_smarty_tpl->tpl_vars['rows_bill']->value)) {?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rows_bill']->value, 'link', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['link']->value) {
?>
								<tr>
									<td class="text-center"><?php echo $_smarty_tpl->tpl_vars['link']->value['id'];?>
</td>
									<td class="text-center"><?php echo bill_type($_smarty_tpl->tpl_vars['link']->value['bill_type']);?>
</td>
									<td class="text-center"><?php echo $_smarty_tpl->tpl_vars['link']->value['bill_id'];?>
</td>
									<td class="text-center"><?php echo $_smarty_tpl->tpl_vars['link']->value['pay_id'];?>
</td>
									<td class="text-center"><?php echo number_format($_smarty_tpl->tpl_vars['link']->value['amount']);?>
 ریال</td>
									<td class="text-center fa_num"><?php echo jdate_format($_smarty_tpl->tpl_vars['link']->value['date']);?>
</td>
									<td class="text-center fa_num"><?php if ($_smarty_tpl->tpl_vars['link']->value['pay_date'] != 0) {
echo jdate_format($_smarty_tpl->tpl_vars['link']->value['pay_date']);
} else { ?>- - -<?php }?></td>
									<td class="text-center"><?php echo $_smarty_tpl->tpl_vars['link']->value['refcode'];?>
</td>
									<td class="text-center">
										<?php if ($_smarty_tpl->tpl_vars['link']->value['status'] == 'paid') {?><span class="btn-success btn-xs" ><i class="fa fa-check" ></i> پرداخت شده</span>
										<?php } else { ?><span class="btn-danger btn-xs" ><i class="fa fa-close" ></i> پرداخت نشده</span>
										<?php }?>
									</td>
								</tr>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							<?php } else { ?>
								<tr>
									<td colspan="9" class="text-center">موردی جهت نمایش وجود ندارد</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				</div>
			<?php }?>

			</div><!-- /.panel -->
		</div>
	</div>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
