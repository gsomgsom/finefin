<?php
		include "../library/PHPExcel/Classes/PHPExcel.php";
		$userData = User::getUserInfo();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("FineFin.RU (beta)")
			->setLastModifiedBy($userData['name'])
			->setTitle("Операции")
			->setSubject("Операции")
			->setDescription("Выгрузка списка операций FineFin.RU.")
			->setKeywords("finefin бухгалтерия операции")
			->setCategory("Домашняя бухгалтерия");
		$objPHPExcel->getActiveSheet()->setTitle('Операции');
		$worksheet = $objPHPExcel->getActiveSheet();

		$dataArray = array(array('Дата', 'Операция', 'Сумма', 'Кошелёк', 'Описание'));

		foreach($this->operationsData as $dataEntry) {
			$dataArray[]=array(
				date('d.m.Y', strtotime($dataEntry['dt'])),
				Money::getOperationText($dataEntry['op_type']),
				sprintf("%.2f", $dataEntry['sum']),
				$dataEntry['account_name'],
				$dataEntry['description'],
			);
		}

		$worksheet->fromArray($dataArray, NULL, 'A1');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$objWriter->setDelimiter(';');
		$objWriter->setEnclosure('');

		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

/*
		$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
		$rendererLibraryPath = '../library/domPDF';

		if (!PHPExcel_Settings::setPdfRenderer(
			$rendererName,
			$rendererLibraryPath
		)) {
			die(
			'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
			EOL .
			'at the top of this script as appropriate for your directory structure'
			);
		}

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');

		//$file_path = 'temp/'.Funcs::randString().'.xlsx';
		$file_path = 'temp/'.Funcs::randString().'.pdf';
*/
		$file_path = 'temp/'.Funcs::randString().'.csv';
		$objWriter->save($file_path);

		if (!file_exists($file_path)) {
	    	header ("HTTP/1.0 404 Not Found");
			exit;
		}
		$fsize = filesize($file_path);
		$ftime = date("D, d M Y H:i:s T", filemtime($file_path));
		$fo = fopen($file_path, "rb");
		if (!$fo) {
			header ("HTTP/1.0 403 Forbidden");
			exit;
		}

		$content = fread($fo, filesize($file_path));
		$fsize = strlen($content);

		$content = iconv('utf-8', 'cp1251', $content);

		fclose($fo);

		header("HTTP/1.1 200 OK");
		header("Content-Disposition: attachment; filename=".basename($file_path));
		header("Last-Modified: ".$ftime);
		header("Content-Length: ".$fsize);
		header("Content-type: application/octet-stream");

		echo $content;

		unlink($file_path);

		die();
