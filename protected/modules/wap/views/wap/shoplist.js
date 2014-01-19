var shoplist=null;

function firstinit(){
	getshoplist();
}
function getshoplist(){
	$.ajax({
        type:'POST',
        dataType: 'json',
        url:  AJAXFORDATA,
        data:{sid:sellerid},
        success:function(data){
            if(data.error=='0'){
            	if(mydatasource==null){
            		mydatasource=data;
            	}else{
            		datasourcetemp=data;
					mydatasource.sortdata=needsort?datasourcetemp.sortdata:mydatasource.sortdata;
					mydatasource.productdata=needproduct?datasourcetemp.productdata:mydatasource.productdata;
					mydatasource.deliveryareadata=needdeliveryarea?datasourcetemp.deliveryareadata:mydatasource.deliveryareadata;
					mydatasource.recommenddata=needrecommend?datasourcetemp.recommenddata:mydatasource.recommenddata;
					mydatasource.shopinfodata=needshopinfo?datasourcetemp.shopinfodata:mydatasource.shopinfodata;
            	} 
            	if(mydatasource.sortdata==null||mydatasource.productdata==null||mydatasource.deliveryareadata==null||mydatasource.shopinfodata==null){
            		var restartdataload=function (){ 
						dataload(mydatasource.sortdata==null,mydatasource.productdata==null,mydatasource.deliveryareadata==null,needrecommend,mydatasource.shopinfodata==null);
					};
					$(currentcontent).hide();
		           	callerror(WRONGDATA,restartdataload); 
            	}else{
            		datarefresh(); 
            	}
            }else{
            	var restartshopload=function (){ 
					getshoplist();
				};
				$(currentcontent).hide();
	           	callerror(WRONGDATA,restartshopload); 
            }
        },
        error:function(XMLHttpRequest,textStatus,errorThrown){  
        	var restartdataload=function (){ 
				dataload(needsort,needproduct,needdeliveryarea,needrecommend,needshopinfo);
			};
			$(currentcontent).hide();
           	callerror(WRONGDATA,restartdataload); 
        }  
    });   
}