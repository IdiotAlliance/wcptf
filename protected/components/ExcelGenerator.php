<?php
class ExcelGenerator{
	
	public static function generateOrderExcelForMember($data){
		
// 		/** Error reporting */
// 		error_reporting(E_ALL);
		
// 		/** Include path **/
// 		set_include_path('../extensions/phpexcel/Classes/');
		
		 
		// Create new PHPExcel object
		echo date('H:i:s') . "Create new PHPExcel object\n";
		$objPHPExcel = new PHPExcel();
		 
		// Set properties
		echo date('H:i:s') . "Set properties\n";
		$objPHPExcel->getProperties()->setCreator("微积分");
		$objPHPExcel->getProperties()->setLastModifiedBy("微积分");
		$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
		$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
		$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
		$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
		$objPHPExcel->getProperties()->setCategory("Test result file");
		 
		// Add some data
		echo date('H:i:s') . "Add some data\n";
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Hello');
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 'world!');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Hello');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'world!');
		 
		// Rename sheet
		echo date('H:i:s') . "Rename sheet\n";
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		 
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		 
		// Save Excel 2007 file
		echo date('H:i:s') . "Write to Excel2007 format\n";
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
		
		// Echo done
		echo date('H:i:s') . "Done writing file.\r\n";
		
	}
}