#!/usr/bin/php5
<?php
	require '/var/www/weChat/protected/components/Constants.php';
	date_default_timezone_set("Asia/Shanghai");
	
	$db_name = 'wcptf_dev';
	$host    = 'localhost';
	$uname   = 'wcadmin';
	$pword   = '123';
	$daily_srv = 6.66; // daily service fee
	$bal_threshold = 100;
	$index   = 0;

	$CREATE_BILL   = "INSERT INTO bills (flowid, seller_id, type, reference, income, payment, balance) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')";
	$UPDATE_BAL    = "UPDATE users SET balance='%s' WHERE id='%s'";
	$CREATE_MQ     = "INSERT INTO msg_queue (seller_id, msg_id, type) VALUES('%s', '%s', '%s')";
	$CREATE_SYSMSG = "INSERT INTO systemmsgs (type, seller_id) VALUES ('%s', '%s')";

	$con1 = mysql_connect($host, $uname, $pword);
	//$con2 = mysql_connect($host, $uname, $pword);
	if(!$con1){
		echo "could not create db connection";
	}else{
		mysql_select_db($db_name, $con1);
		// reset instore every day at 2:00 am
		mysql_query("UPDATE products SET products.daily_instore=products.instore WHERE products.deleted<>1;");
		echo Date("Y-m-d H:i:s", time())." Updated all user instore\n";

		// create daily bills for each user
		$result = mysql_query("SELECT users.id AS uid, store.id AS sid, users.balance AS balance FROM users JOIN store ON 
							   store.seller_id=users.id WHERE store.deleted<>1 AND users.balance > 0");
		$date = date("Ymd",time());
		while($row = mysql_fetch_array($result)){
			$flowid   = $date.(floor(time() % 86400000) + $index);
			$balances = mysql_query("SELECT balance FROM users WHERE id=".$row['uid']);
			$bal = 0;
			while ($balance = mysql_fetch_array($balances)) {
				$bal = $balance['balance'];
				break;
			}
			$bal = $bal - $daily_srv;
			$insert = sprintf($CREATE_BILL, $flowid, $row['uid'], Constants::BILL_TYPE_NORMAL, 
							  $row['sid'], 0, $daily_srv, $bal);
			$update = sprintf($UPDATE_BAL, $bal, $row['uid']);
			mysql_query($insert);
			echo Date("Y-m-d H:i:s", time())." Created daily bill for user [".$row['uid']."]\n";
			mysql_query($update);
			echo Date("Y-m-d H:i:s", time())." Updated balance for user [".$row['uid']."]\n";
			$index ++;
		}
		//mysql_close($con2);

		// send system messages to whose balance < 50
		$result = mysql_query("SELECT id, balance FROM users WHERE balance < ".$bal_threshold);
		while ($row = mysql_fetch_array($result)) {
			$insert = null;
			if($row['balance'] >= 50)
				$insert = sprintf($CREATE_SYSMSG, Constants::MSG_SYSTEM_100, $row['id']);
			else if($row['balance'] >= 10)
				$insert = sprintf($CREATE_SYSMSG, Constants::MSG_SYSTEM_50, $row['id']);
			else
				$insert = sprintf($CREATE_SYSMSG, Constants::MSG_SYSTEM_10, $row['id']);
			if(mysql_query($insert)){
				$newid = mysql_insert_id();
				$insert = sprintf($CREATE_MQ, $row['id'], $newid, Constants::MSG_SYSTEM);
				mysql_query($insert);
				echo Date("Y-m-d H:i:s", time())." Sent system messge to user [".$row['id']."]\n";
			}
		}
		mysql_close($con1);
	}
?>
