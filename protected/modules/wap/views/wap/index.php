<?php ?>
<div id="sortcontent" class="content-frame">
	<section class="tips" id='tips-sortcontent'>
		<header>
			<h4 id="tips-title"></h4>
		</header>
		<div class="tips-content">
			<p id="tips-announcement"></p>
		</div>
	</section>
	<ul id="sort-recommendlist" class="ul-listview ul-sort-recommend"></ul>
	<ul id="sort-normallist" class="ul-listview ul-sort-normal"></ul>
</div>
<div id="productcontent" class="content-frame">
	<ul id="product-list" class="ul-listview ul-product">

	</ul>

</div>
<footer class="footer-order">
	<button onclick=payback() id="back-btn" class="btn-icon">
		<img src="/wcptf/img/wap/back-purple.png">
	</button>
	<button onclick=callsort() id="sort-btn" class="btn-icon">
		<img src="/wcptf/img/wap/bullets-purple.png">
	</button>
	<button onclick=topay() id="pay-btn" class="btn-icon-text">
		<p class="text-in-btn" id="totalpay">结算 ￥0</p>
		<img class="img-in-btn" src="/wcptf/img/wap/shop-purple.png">
	</button>
</footer>
<div id="wap_data_holder" style="display:none"><?php echo $json_data?></div>

<script type="text/javascript">
var json = eval("(" + $('#wap_data_holder').html() + ")");

var sortdata = json['sortdata'];
var productdata = json['productdata'];
var deliveryareadata = json['deliveryareadata'];
var recommenddata = json['recommenddata'];
var shopinfodata = json['shopinfodata'];

/*[{"sortid":0,"sortname":"鲜榨果汁","sortdesc":"新鲜水果现榨，没有任何添加剂哟","sortimg":"/wcptf/img/wap/fruitjuice.jpg"},
{"sortid":1,"sortname":"水果拼盘","sortdesc":"理想的代餐拼盘，塑身MM最爱","sortimg":"/wcptf/img/wap/fruitdish.jpg"},
{"sortid":2,"sortname":"进口水果","sortdesc":"全是诱人的进口水果","sortimg":"/wcptf/img/wap/importedfruit.jpg"},
{"sortid":3,"sortname":"水果布丁","sortdesc":"新口味，新吃法。赶紧尝试下吧","sortimg":"/wcptf/img/wap/charlotte.jpg"},
{"sortid":4,"sortname":"国产水果","sortdesc":"便宜又实惠，地道的新疆阿克苏","sortimg":"/wcptf/img/wap/localfruit.jpg"},
{"sortid":5,"sortname":"水果面膜","sortdesc":"每天一片，像水果一样水嫩","sortimg":"/wcptf/img/wap/fruitmask.jpg"}
];
var productdata=[
{"productid":0,"sortid":0,"price":10,"productname":"鲜榨橙汁","productleft":0},
{"productid":1,"sortid":0,"price":11,"productname":"鲜榨西瓜汁","productleft":4},
{"productid":2,"sortid":0,"price":12,"productname":"鲜榨葡萄汁","productleft":2},
{"productid":3,"sortid":1,"price":12,"productname":"圣女果火龙果拼盘","productleft":5},
{"productid":4,"sortid":1,"price":11,"productname":"圣女果苹果拼盘","productleft":3},
{"productid":5,"sortid":1,"price":13,"productname":"苹果火龙果拼盘","productleft":1},
{"productid":6,"sortid":2,"price":8,"productname":"西柚（500g）","productleft":0},
{"productid":7,"sortid":2,"price":9,"productname":"新奇士橙（500g）","productleft":3},
{"productid":8,"sortid":2,"price":10,"productname":"榴莲（500g）","productleft":4},
{"productid":9,"sortid":3,"price":7,"productname":"芒果布丁","productleft":1},
{"productid":10,"sortid":3,"price":6,"productname":"草莓布丁","productleft":10},
{"productid":11,"sortid":3,"price":7,"productname":"凤梨布丁","productleft":8},
{"productid":12,"sortid":4,"price":4,"productname":"黄岩蜜桔（500g）","productleft":8},
{"productid":13,"sortid":4,"price":5,"productname":"云南红提（500g）","productleft":9},
{"productid":14,"sortid":4,"price":6,"productname":"新疆阿克苏（500g）","productleft":3},
{"productid":15,"sortid":5,"price":12,"productname":"蜂蜜黄瓜面膜（10片）","productleft":2},
{"productid":16,"sortid":5,"price":14,"productname":"蜂蜜奇异果面膜（10片）","productleft":3},
{"productid":17,"sortid":5,"price":13,"productname":"蜂蜜苹果面膜（10片）","productleft":3}
];
var deliveryareadata=[
{"areaid":0,"areaname":"教学楼","areadesc":"仙一仙二和东部院系楼","areastatus":true},
{"areaid":1,"areaname":"图书馆","areadesc":"图书馆及沈小平楼","areastatus":true},
{"areaid":2,"areaname":"宿舍1-5","areadesc":"宿舍1栋至5栋","areastatus":false}
];
var recommenddata=[
{"recommendid":0,"recommendtype":"recsort","recommendtag":"推荐","recommendimg":"/wcptf/img/wap/fruitjuice.jpg","objectid":0},
{"recommendid":1,"recommendtype":"recsort","recommendtag":"热卖","recommendimg":"/wcptf/img/wap/fruitdish.jpg","objectid":1},
{"recommendid":2,"recommendtype":"recsort","recommendtag":"新品","recommendimg":"/wcptf/img/wap/importedfruit.jpg","objectid":2},
];

var shopinfodata= {"announcement":"今明两天购满100起八折，抓紧哦！","shopstatus":"innormal","begintime":"08:00","endtime":"21:00","severtime":"22:00","isdeliveryfree":true,"sendingfee":20,"deliveryfee":3,"expecttime":40};
*/
firstinit();
showsortcontent();

</script>