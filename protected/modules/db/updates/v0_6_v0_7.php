<?php
	//old database
	const DB_HOST = '192.168.1.107';
	const DB_USER = 'wcadmin';
	const DB_PASS = '123';
	const DB_DATABASENAME = 'test_dev';
	//new database
	const DB_NEW_HOST = '192.168.1.107';
	const DB_NEW_USER = 'wcadmin';
	const DB_NEW_PASS = '123';
	const DB_NEW_DATABASENAME = 'test_new';
	//显示utf-8
	echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /></head>";
	//mysql_connect  
	$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("connect failed" . mysql_error());  
	mysql_select_db(DB_DATABASENAME, $conn);
	mysql_query("set names 'utf8'");
	// insert_data("sss", "sss","sss", $conn);

	// clear tables first
	mysql_query("DELETE FROM pictures WHERE seller_id=8");
	mysql_query("DELETE FROM members WHERE seller_id=8");
	mysql_query("DELETE FROM users WHERE id=8");
	
	// 0.users表
	$table1="users";
	$table2="users";
	$fields1=array("id", "email", "password", "type", "register_time", "email_verified", "verify_code", "wechat_id", "wechat_url", "wechat_bound", "token");	
	$fields2=array("id", "email", "password", "type", "register_time", "email_verified", "verify_code", "wechat_id", "wechat_url", "wechat_bound", "token");
	query_insert_data($table1, $table2, $fields1, $fields2, $conn);
	
	// 1.pictures表
	$table1="pictures";
	$table2="pictures";
	$fields1=array("id", "seller_id", "description", "pic_url", "name", "deleted");	
	$fields2=array("id", "seller_id", "description", "pic_url", "name", "deleted");
	query_insert_data($table1, $table2, $fields1, $fields2, $conn);
	
	// 2.store表
	$table1="users";
	$table2="store";
	$fields1=array("seller_type", "store_name", "store_address", "logo", "phone", "status", "broadcast", "stime", "etime", "start_price", 
	"takeaway_fee", "threshold", "estimated_time");
	$fields2=array("type", "name", "address", "logo", "phone", "status", "broadcast", "stime", "etime", "start_price", 
	"takeaway_fee", "threshold", "estimated_time");
	$defaults=array("id"=>1);
	query_insert_data_with_defaults($table1, $table2, $fields1, $fields2, $defaults, $conn);

	// 3.members表
	$table1="members";
	$table2="members";
	$fields1=array("id", "seller_id", "openid", "fakeid", "credits", "ctime", "wxid", "wxnickname", "unsubscribed", "latest_comment", "deleted", "wapkey");
	$fields2=array("id", "seller_id", "openid", "fakeid", "credits", "ctime", "wxid", "wxnickname", "unsubscribed", "latest_comment", "deleted", "wapkey");
	query_insert_data($table1, $table2, $fields1, $fields2, $conn);
	
	// 4.product_type表
	$table1="product_type";
	$table2="product_type";
	$fields1=array("id", "daily_status", "type_name", "type_description", "product_num", "pic_url", "insufficient", "deleted");
	$fields2=array("id", "daily_status", "type_name", "type_description", "product_num", "pic_url", "insufficient", "deleted");
	$defaults=array("store_id"=>1);
	query_insert_data_with_defaults($table1, $table2, $fields1, $fields2, $defaults, $conn);

	// 5.districts表
	$table1="districts";
	$table2="districts";
	$fields1=array("id", "name", "description", "daily_status", "deleted");
	$fields2=array("id", "name", "description", "daily_status", "deleted");
	$defaults=array("store_id"=>1);
	query_insert_data_with_defaults($table1, $table2, $fields1, $fields2, $defaults, $conn);

	// 6.posters表
	$table1="posters";
	$table2="posters";
	$fields1=array("id", "name", "phone", "description", "daily_status", "deleted");
	$fields2=array("id", "name", "phone", "description", "daily_status", "deleted");
	$defaults=array("store_id"=>1);
	query_insert_data_with_defaults($table1, $table2, $fields1, $fields2, $defaults, $conn);

	// 7.member_token表
	$table1="member_token";
	$table2="member_token";
	$fields1=array("id", "seller_id", "openid", "token");
	$fields2=array("id", "seller_id", "openid", "token");
	query_insert_data($table1, $table2, $fields1, $fields2, $conn);

	// 8.hot_products
	$table1="hot_products";
	$table2="hot_products";
	$fields1=array("desc", "pic_id", "pic_url", "product_id", "onindex");
	$fields2=array("description", "pic_id", "pic_url", "product_id", "onindex");
	$defaults=array("store_id"=>1);
	query_insert_data_with_defaults($table1, $table2, $fields1, $fields2, $defaults, $conn);

	// 9.products
	$table1="products";
	$table2="products";
	$fields1=array("id", "type_id", "pname", "price", "credit", "description", 
				   "stime", "etime", "status", "instore", "daily_instore", "insufficient", "richtext", "cover", "deleted");
	$fields2=array("id", "type_id", "pname", "price", "credit", "description", 
				   "stime", "etime", "status", "instore", "daily_instore", "insufficient", "richtext", "cover", "deleted");
	$defaults=array('store_id'=>1);
	query_insert_data_with_defaults($table1, $table2, $fields1, $fields2, $defaults, $conn);

	// 10.Orders 表
	$table1="orders";
	$table2="orders";
	// 插入域 旧字段和新的字段一一对应
	$fields1= array("id", "member_id", "ctime","status", "address",
	"description", "duetime" , "total", "type", "phone", "order_no", "poster_id", "area_id", "order_name");
	$fields2= array("id", "member_id", "ctime","status", "address",
	"description", "duetime" , "total", "type", "phone", "order_no", "poster_id", "area_id", "order_name");
	// query_insert_data($table1, $table2, $fields1, $fields2, $conn);
	// 多表合一，键值
	$tableArray = array("posters", "districts");
	$oldKey = array("poster_id", "area_id");
	$newFields = array();
	$oldFields = array();
	$newField1 = array("poster_name", "poster_phone");
	array_push($newFields, $newField1);
	$oldField1= array("name","phone");
	array_push($oldFields, $oldField1);
	$newField2 = array("area_name", "area_description");
	array_push($newFields, $newField2);
	$oldField2 = array("name", "description");
	array_push($oldFields, $oldField2);
	$defaults=array("store_id"=>1);
	queryTables_insert_data_with_defaults($table1, $table2, $fields1, $fields2, $tableArray, $oldKey, $oldFields, $newFields, $defaults, $conn);
	
	// 更新域 保持唯一id
	$table1="orders";
	$table2="orders";
	$id1="id";
	$field1="ctime";
	$id2="id";
	$field2="duetime";
	query_update_data($table1, $table2, $id1, $field1, $id2, $field2, $conn);

	// 11.order_items表
	$table1="order_items";
	$table2="order_items";
	// 插入域 旧字段和新的字段一一对应
	$fields1= array("id", "order_id", "product_id", "number","price", "status");
	$fields2= array("id", "order_id", "product_id", "number","price", "status");
	query_insert_data($table1, $table2, $fields1, $fields2, $conn);

	// 12.wechatmsgs表
	$table1="wechatmsgs";
	$table2="wechatmsgs";
	$fields1=array("id", "seller_id", "openid", "rawid", "rawmsg", "msgtype", "createtime");
	$fields2=array("id", "seller_id", "openid", "rawid", "rawmsg", "msgtype", "createtime");
	query_insert_data($table1, $table2, $fields1, $fields2, $conn);

		
	function query_insert_data($table1, $table2, $fields1, $fields2, $conn){
		query_insert_data_with_defaults($table1, $table2, $fields1, $fields2, null, $conn);
	}
	
	/**
	 * sql = "select * from table"
	 * this function is designed to get old data from last or outdate database &
	 * use these data insert into new database
	 * @pramas: $table1 old table $fields1 old fileds
	 * $table2 new table $fileds2 new fileds
	 */
	function query_insert_data_with_defaults($table1, $table2, $fields1, $fields2, $defaults=null, $conn){
		$sql="select * from %s";
		$sql = sprintf($sql, $table1);
		//echo $sql;
		$result = mysql_query($sql, $conn);
		mysql_select_db(DB_NEW_DATABASENAME, $conn);
		mysql_query("set names 'utf8'");
		while($row = mysql_fetch_array($result))
		{
			$item = array();
			foreach ($fields1 as $field) {
				array_push($item, $row[$field]);
				// $output = $output.$row[$field];
			}
			echo insert_data_with_defaults($table2, $fields2, $item, $defaults, $conn);
		}
		mysql_select_db(DB_DATABASENAME, $conn);
	}

	/**
	 *sql = "select * from table"
	 *this function is designed to get old data from last or outdate database &
	 *use these data insert into new database
	 *prama: $table1 old table $fields1 old fileds 旧表主表
	 * $table2 new table $fileds2 new fileds 新表
	 * $tableArray 其他表 $oldKey 其他表对应的外键 
	 * $oldFields 其他表对应要插入的字段， $newFields 其他表对应要插入的字段新表的字段名
	 */
	function queryTables_insert_data($table1, $table2, $fields1, $fields2, $tableArray, $oldKey, $oldFields, $newFields, $conn){
		queryTables_insert_data_with_defaults($table1, $table2, $fields1, $fields2, $tableArray, $oldKey, $oldFields, $newFields, null, $conn);
	}

	function queryTables_insert_data_with_defaults($table1, $table2, $fields1, $fields2, $tableArray, $oldKey, $oldFields, $newFields, $defaults=null, $conn){
		$sql="select * from %s";
		$sql = sprintf($sql, $table1);
		//echo $sql;
		$result = mysql_query($sql, $conn);
		while($row = mysql_fetch_array($result))
		{
			$itemValue = array();
			foreach ($fields1 as $field) {
				array_push($itemValue, $row[$field]);

				// $output = $output.$row[$field];
			}
			//将旧表的其他表数据取出，键值一定已经存在于原表数据中
			$len = count($tableArray);
			for ($i=0; $i<$len; $i++) {
				$sql="select * from %s where";
				$sql = sprintf($sql, $tableArray[$i]);
				$sql = $sql." id ='".$row[$oldKey[$i]]."'";
				echo($sql);
				echo "<br/>";
				$resultTemp = mysql_query($sql, $conn);
				while($rowTemp = mysql_fetch_array($resultTemp))
				{
					foreach ($oldFields[$i] as $field) {
						array_push($itemValue, $rowTemp[$field]);
						// $output = $output.$row[$field];
					}
				}
			}
			//合并新表字段
			$item = array();
			foreach ($fields2 as $field) {
				array_push($item, $field);
			}
			foreach ($newFields as $newField) {
				foreach ($newField as $field) {
					array_push($item, $field);
				}
			}
			mysql_select_db(DB_NEW_DATABASENAME, $conn);
			mysql_query("set names 'utf8'");
			echo insert_data_with_defaults($table2, $item, $itemValue, $defaults, $conn);

			mysql_select_db(DB_DATABASENAME, $conn);
		}
		mysql_select_db(DB_DATABASENAME, $conn);
	}

	/**
	 *this function is designed to get old data from last or outdate database &
	 *use these data update new database
	 *prama: $table1 old table $fields1 old fileds
	 *$table2 new table $fileds2 new fileds
	 *$id1 , $id2 is key to find
	 *$field1, $field2 is value to update
	 */
	function query_update_data($table1, $table2, $id1, $field1, $id2, $filed2, $conn){
		$sql="select ".$id1.",".$field1." from %s";
		$sql = sprintf($sql, $table1);
		//echo $sql;
		$result = mysql_query($sql, $conn);
		mysql_select_db(DB_NEW_DATABASENAME, $conn);
		mysql_query("set names 'utf8'");
		while($row = mysql_fetch_array($result))
		{
			echo update_data($table2, $row[$id1], $row[$field1], $id2, $filed2, $conn);
		}
		mysql_select_db(DB_DATABASENAME, $conn);
	}

	/**
	 * "INSERT INTO Table (FirstName, LastName, Age) VALUES ('Peter', 'Griffin', '35')"
	 */
	function insert_data($table, $fileds, $values, $conn){
		insert_data_with_defaults($table, $fields, $values, null, $conn);
	}

	
	function insert_data_with_defaults($table, $fields, $values, $defaults=null, $conn){
		$sql = "insert into %s";
		$sql = sprintf($sql, $table);
		$i = 0;
		$len = count($values);
		//过滤掉空字段
		$newFileds = array();
		$newValues = array();
		for ($i=0; $i<$len; $i++) {
			if($values[$i]!=null){
				array_push($newFileds, $fields[$i]);
				array_push($newValues, $values[$i]);
			}
		}
		if($defaults){
			while (current($defaults)) {
			  	array_push($newFileds, key($defaults));
			  	array_push($newValues, $defaults[key($defaults)]);
			  	next($defaults);
			}
		}
		// 生成sql语句
		$sql = $sql."(";
		$sql = $sql.implode(",", $newFileds);
		$sql = $sql.") VALUES ('";
		$sql = $sql.implode("','", $newValues);
		$sql = $sql."')";
		echo $sql;
		echo "<br />";
		echo mysql_query($sql, $conn);
	}

	/**
	 * UPDATE table_name SET column_name = new_value WHERE column_name = some_value
	 */
	function update_data($table, $valueId, $valueFiled ,$id, $filed, $conn){
		$sql = "update %s SET";
		$sql = sprintf($sql, $table);
		$sql = $sql." ".$filed."='".$valueFiled."' where ".$id."='".$valueId."'";
		echo $sql;
		echo "<br />";
		mysql_query($sql, $conn);
	}

	function empty_database(){

	}

	mysql_close($conn);
?>
