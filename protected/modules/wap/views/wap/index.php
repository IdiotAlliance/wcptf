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
        <label for="name">姓名:*</label>
        <input type="text" placeholder="请输入姓名" id="name" value="">
        <label for="number">联系电话:*</label>
        <input id="number" placeholder="请输入联系电话" type="tel" value="">
        <label for="select-area" class="select">请选择收货片区:*</label>
        <select id="select-area">
            
        </select>
        <label for="text-basic">详细收货地点:*</label>
        <textarea type="text" placeholder="请输入详细收货地址，如：仙1-202" name="text-basic" id="areadesc" value=""></textarea>
        <label for="text-basic">备注:</label>
        <textarea type="text"  placeholder="请输入备注，如：xxx不要放生菜" name="text-basic" id="tips" value=""></textarea>
        </div>
    </section>
    <button class="btn-icon-text" onclick=submit() id="submit-btn">
	    <p class="text-in-btn"id="submit">提交订单</p>
	    <img class="img-in-btn" src="_assets/img/check-purple.png">
	</button>

    </div>
<footer class="footer-order">
    <button onclick = payback() id="back-btn" class="btn-icon" ><img src="_assets/img/back-purple.png"></button>
    <button onclick = callsort() id="sort-btn" class="btn-icon"><img src="_assets/img/bullets-purple.png"></button>
    <button onclick = topay() id="pay-btn" class="btn-icon-text"><p class="text-in-btn"id="totalpay">结算 ￥0</p><img class="img-in-btn" src="_assets/img/shop-purple.png"></button>
</footer>  
<div class="toast" id="mytoast" style="display: none;"></div>
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
showsortcontent();

</script>