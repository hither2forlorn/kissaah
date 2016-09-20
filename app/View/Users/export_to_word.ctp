<?php
App::import('Vendor','PHPWord',array('file' => 'PHPWord.php'));
$PHPWord = new PHPWord();

$section = $PHPWord->createSection();

//Styles
$styleCell 		= array('valign' => 'center', 'spaceAfter' => 0, 'spaceBefore' => 0, 'spacing' => 0);
$styleTable 	= array('borderSize' => 1, 'borderColor' => '555555', 'spaceBefore' => 0,'cellMarginLeft' => 40, 'cellMarginRight' => 50);
$fontStyle 		= array('bold' => true, 'valign' => 'center');
$styleText 		= array('align' => 'center', 'spaceAfter' => 0, 'spaceBefore' => 0, 'spacing' => 0, 'color' => '000000');
$normalFont 	= array('valign' => 'center', 'color' => '000000');
$TitleStyle		= array('color' => '0080ff');//Style For Title
$Narration_textStyle = array('color' => 'ff8000');//Style For Narration Text
//End Styles
	
$PHPWord->addTableStyle('TableStyle', $styleTable);
$section->addText('Kissaah: Your Quick Tasks', $TitleStyle);

foreach($data as $type => $notes) {
	$table = $section->addTable('TableStyle');

	$table->addRow(0);
	$table->addCell(5000, $styleCell)->addText($type);
	$table->addCell(2000, $styleCell)->addText('Complete By');

	foreach($notes as $note){
		$table->addRow(0);
		$table->addCell(5000, $styleCell)->addText(isset($note['text'])? $note['text']: '');
		$table->addCell(2000, $styleCell)->addText(isset($note['complete_by'])? $note['complete_by']: '', $fontStyle, $styleText);
	}

}

$file = 'Kissaah_Your_Quick_Tasks.docx';

// headers
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

// writer
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('php://output');
exit;
?>  	