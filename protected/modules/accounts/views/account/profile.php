<style type="text/css">
	#profile_main_container{
		display: block;
		position: absolute;
		width: 890px;
		min-height: 500px;
		left: 50%;
		margin-left: -450px;
		top: 50%;
		margin-top: -350px;
		background-color: #fff;
		border-radius: 1px;
		box-shadow: 0px 0px 10px #808080;
		padding-left: 10px;
	}
	#profile_nav_bar{
		position: relative;
		height: 40px;
		padding-left: 15px;
	}
	.profile_nav_item{
		text-align: center;
		height: 40px;
		width: 280px;
		display: inline-block;
		line-height: 40px;
	}
	.profile_nav_item:hover{
		cursor: pointer;
		border-bottom: 2px solid #aaa;
	}
	.profile_nav_item.active{
		border-bottom: 2px solid #222;
	}
	.profile_tab{
		display: none;
		position: absolute;
		height: 450px;
		left: 0;
		top: 50px;
		border-bottom-left-radius: 1px;
		border-bottom-right-radius: 1px;
		overflow: auto;
		padding-left: 25px;
		width: 850px;
		padding-right: 25px;
	}
	.profile_tab.active{
		display: block;
	}
	.profile_tab_title{
		padding-left: 10px;
		width: 840px;
		height: 35px;
		line-height: 35px;
		font-size: 16px;
		font-weight: bold;
		background-color: #d3e8db;
		color: #fff;
	}
</style>

<div id="profile_main_container">
	<div id="profile_nav_bar">
		<div class="profile_nav_item active">基本信息</div>
		<div class="profile_nav_item">系统消息</div>
		<div class="profile_nav_item">账单</div>
	</div>

	<div id="profile_tab1" class="profile_tab active">
		<div class="profile_tab_title">我的账户</div>
		<div>
			<table>
				<tr>
					<td>账户名称</td>
					<td><?php echo ''?></td>
				</tr>
				<tr>
					<td>账户余额</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2">您目前有<span><?php echo ''?></span>家店铺</td>
				</tr>
				<tr>
					<td colspan="2">您本月订单总额<span><?php echo ''?></span>元</td>
				</tr>
			</table>
		</div>
		<div class="profile_tab_title">我的插件</div>
		<div>

		</div>
	</div>
	<div id="profile_tab2" class="profile_tab">

	</div>
	<div id="profile_tab3" class="profile_tab">

	</div>
</div>

<script type="text/javascript">
	
</script>