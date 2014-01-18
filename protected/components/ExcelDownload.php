<?php

class ExcelDownload {

    public static function downloadExcelByArray($filename, $title, $data){
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";  
        header("Content-Type: application/$file_type;charset=utf-8");

        header("Content-Disposition: attachment; filename=".$filename.".$file_ending");
        header("Pragma: no-cache"); 
        echo($title."\n");
        // 输出内容
        echo "<table>";
        $len  = count($data);
        for ( $i = 0; $i < $len; $i++ ) {
        	echo "<tr>";
            $tempLen = count($data[$i]);
            for ($j = 0; $j < $tempLen; $j++){
                echo "<td style='vnd.ms-excel.numberformat:@'>".$data[$i][$j]."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
}

?>