<style type="text/css">
	body{
		width: 100%;
		height: 100%;
		font-size: 100%;
		text-align: center;
		overflow: auto;
		margin: 0;
	}
	img{
		max-width: 100%;
		max-height: 100%;
	}
	.nav_bar{
		position: fixed;
		width: 100%;
	}
	.header_bar{
		height: 50px;
		top: 0;
		left: 0;
		right: 0;
		background-color: #f00;
	}
	.footer_bar{
		height: 40px;
		right: 0;
		left: 0;
		bottom: 0;
		background-color: rgba(0,0,0,0.8);
	}
	.aqi_body{
		width: 100%;
		height: 100%;
		padding-top: 50px;
		padding-bottom: 40px;
	}
	.aqi_body .aqiframe_container{
		position: relative;
		left: 0;
		top: 0;
		width: 100%;
	}
	.aqi_body .aqiframe_container .frame{
		position: absolute;
		left: 100%;
		right: 0;
		width: 100%;
		display: none;
	}
	.aqi_body .aqiframe_container .frame.active{
		left: 0;
		display: block;
	}
</style>
<div id="aqi_header" class="nav_bar header_bar">
</div>
<div id="aqi_body" class="aqi_body">
	<div class="aqiframe_container">
		<div class="frame frame_index active">
			<div class="promotion_container">
				<div class="promotion_item">
					<img src="" />
					<div class="promotion_item_desc"></div>
				</div>
			</div>
			<div class="products_container"></div>
		</div>
		<div class="frame frame_info"></div>
		<div class="frame frame_order"></div>
		<div class="frame frame_myorder"></div>
	</div>
</div>
<div id="aqi_footer" class="nav_bar footer_bar"></div>