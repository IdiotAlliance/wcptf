<?php ?>
<div id="mybody">
<div id="sortcontent"  class="content-frame">
	<section class="tips" id='tips-sortcontent'><header><h4 id="tips-title-sort"></h4></header><div class="tips-content"><p id="tips-announcement-sort"></p></div></section>
	<ul id="sort-recommendlist" class="ul-listview ul-sort-recommend"></ul>
	<ul id="sort-normallist" class="ul-listview ul-sort-normal"></ul>
</div>
<div id="productcontent" class="content-frame" style="display: none;">
	<ul id="product-list" class="ul-listview ul-product">
        
    </ul>

		 
</div>
<div id="paycontent" class="content-frame" style="display: none;" >
    <ul id="order-list" class="ul-listview ul-product">
    </ul>
    <section class="tips" id='tips-ordercontent'><header><h4 id="tips-title-order">外送须知</h4></header><div class="tips-content"><p id="tips-announcement-order"></p></div></section>
   	<section id="personalinfo">
        <header><h4>收货信息（*必填）</h4></header>
        <div id="personalinfo-content" >
        <label class="mylabel-main">姓名:*</label><label class="mylabel-tips"></label>
        <input type="text" placeholder="请输入姓名" data-maxinput="10" data-nonull="true" onblur="checkinput(this)" id="name" value="">
        <label class="mylabel-main">联系电话:*</label><label class="mylabel-tips"></label>
        <input id="number" placeholder="请输入联系电话" data-maxinput="20" data-nonull="true" onblur="checkinput(this)" type="tel" value="">
        <label class="mylabel-main">请选择收货片区:*</label><label class="mylabel-tips"></label>
        <select id="select-area" onchange="checkselect(this)">
        </select>
        <label class="mylabel-desc"></label>
        <label class="mylabel-main">详细收货地点:*</label><label class="mylabel-tips"></label>
        <textarea type="text" placeholder="请输入详细收货地址，如：仙1-202" data-maxinput="40" data-nonull="true" onblur="checkinput(this)" id="areadesc" value=""></textarea>
        <label class="mylabel-main">备注:</label><label class="mylabel-tips"></label>
        <textarea type="text"  placeholder="请输入备注，如：xxx不要放生菜" data-maxinput="40" data-nonull="false" onblur="checkinput(this)" id="tips" value=""></textarea>
        </div>
    </section>
    <button class="btn-icon-text" onclick=submit() id="submit-btn">
	    <p class="text-in-btn"id="submit">提交订单</p>
	    <img class="img-in-btn" src="/weChat/img/wap/check-purple.png">
	</button>
</div>
<footer class="footer-order">
    <button onclick = payback() id="back-btn" class="btn-icon" ><img src="/weChat/img/wap/back-purple.png"></button>
    <button onclick = callsort() id="sort-btn" class="btn-icon"><img src="/weChat/img/wap/bullets-purple.png"></button>
    <button onclick = topay() id="pay-btn" class="btn-icon-text"><p class="text-in-btn"id="totalpay">结算 ￥0</p><img class="img-in-btn" src="/weChat/img/wap/shop-purple.png"></button>
</footer>  
<div class="toast" id="mytoast" style="display: none;"></div>
<div class="waiting" style="display:none;">正在载入…</div>
<div class="success" style="display:none;">
	<section class="tips" id='tips-ordersuccess'><header><h4 id="tips-title-ordersuccess">恭喜您，下单成功！</h4></header><div class="tips-content"><p id="tips-orderdesc-ordersuccess">订单：</p></div></section>
	<button class="btn-icon-text" onclick=reloadcontent() id="reload-btn">
	    <p class="text-in-btn">网络异常，点击刷新</p>
	    <img class="img-in-btn" src="/weChat/img/wap/refresh-purple.png">
	</button>
    <button class="btn-icon-text" onclick=newstart() id="newstart-btn">
	    <p class="text-in-btn">继续下单</p>
	    <img class="img-in-btn" src="/weChat/img/wap/carat-r-purple.png">
	</button>
</div>
<div id="wap_data_holder" style="display:none"><?php echo $json_data?></div>
</div>

<script type="text/javascript">
var json = eval("(" + $('#wap_data_holder').html() + ")");

var sortdata = json['sortdata'];
var productdata = json['productdata'];
var deliveryareadata = json['deliveryareadata'];
var recommenddata = json['recommenddata'];
var shopinfodata = json['shopinfodata'];

firstinit();

</script>