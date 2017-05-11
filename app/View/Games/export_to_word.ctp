<?php
App::import('Vendor', 'PHPWord', array('file' => 'PHPWord.php'));
$PHPWord = new PHPWord();

$section = $PHPWord->createSection();

$styleFont = array('size' => 12, 'name' => 'Calibri');
$styleParagraph = array('align' => 'center', 'spaceAfter' => 100, 'valign' => 'center');

$styleTable = array('borderSize' => 2, 'borderColor' => 'FFFFFF', 'cellMargin' => 100);
$styleCell 	= array('align' => 'center', 'valign' => 'center');
$PHPWord->addTableStyle('tableStyle', $styleTable);

$firstTitle = true;
foreach($step_games as $key => $games) {
	
	if(isset($games[$key]['children'])) {
		foreach($games[$key]['children'] as $game) {
			if($game['Configuration']['type'] != 12 && $game['Configuration']['id'] != 224 && $game['Configuration']['id'] != 275) {
				
				if($firstTitle) {
					if($game['Configuration']['title'] != '**NH**') {
						$section->addText($game['Configuration']['title'],
								array('color' => '0080ff', 'bold' => true, 'size' => 16, 'name' => 'Calibri'),
								array('align' => 'center'));
					}
					$firstTitle = false;
					
				} else {
					if($game['Configuration']['title'] != '**NH**') {
						$section->addText($game['Configuration']['title'],
								array('color' => '0080ff', 'bold' => true, 'size' => 16, 'name' => 'Calibri'),
								array('align' => 'center', 'spaceBefore' => 500));
					}
				}

				if(isset($game['children'])) {

					if(in_array($game['Configuration']['id'], array(71, 76, 83, 84, 193, 199, 203))) {
						$inspirationi = $section->addTable('tableStyle');
						$inspirationi->addRow(0);

						$inspirationt = $section->addTable('tableStyle');
						$inspirationt->addRow(0);
						
						if(count($game['children']) == 1) {
							$inspirationi->addCell(3000)->addText('');
							$inspirationt->addCell(3000)->addText('');
						}

						foreach($game['children'] as $key => $item) {
							if($item['Configuration']['status'] && $item['Configuration']['type'] == 1) {
								if($game['Configuration']['title'] == '**NH**') {
									$section->addText($item['Configuration']['sub_txt'],
											array('color' => '0080ff', 'size' => 14, 'name' => 'Calibri'));
								}
								$answer = '../webroot/img/export.jpg';
								if(!empty($item['Game'][0]['Game']['answer'])) {
									$answer = '../webroot/files/img/medium/' . $item['Game'][0]['Game']['answer'];
								}
								$inspirationi->addCell(3000)->addImage($answer, array('width' => 200, 'height' => 200));
									
								if(isset($item['children'])) {
									foreach($item['children'] as $child) {
										$answer = '';
										$styleCell['bgColor'] = '17B3E8';
										if(!empty($child['Game'])) {
											$answer = '4' . $child['Game'][0]['Game']['answer'];
										}
										$inspirationt->addCell(3000, $styleCell)
													 ->addText($answer, $styleFont, $styleParagraph);
									}
								}
							}
						}

					} elseif(in_array($game['Configuration']['id'], array(75))) {
						foreach($game['children'] as $key => $item) {
							if($item['Configuration']['status'] && $item['Configuration']['type'] == 5) {
								$label = '';
								$answer = '';
								if(isset($item['Dependent'][0])) {
									if($item['Dependent'][0]['type'] == 7) {
										$label = $item['Dependent'][0]['answer'] . ': ';
									}
								}
								if(!empty($item['Game'])) {
									$answer	= $item['Game'][0]['Game']['answer'];
								}
								$section->addText($label . $answer, $styleFont, $styleParagraph);
							}
						}
						
					} elseif(in_array($game['Configuration']['id'], array(74, 77))) {
						foreach($game['children'] as $key => $item) {
							$valuesi = $section->addTable('tableStyle');
							$valuesi->addRow(0);

							if($item['Configuration']['status'] && $item['Configuration']['type'] == 6) {
								$answer = '../webroot/img/export.jpg';
								if(isset($item['Dependent'][0])) {
									if(!empty($item['Dependent'][0]['answer'])) {
										$answer = '../webroot/files/img/medium/' . $item['Dependent'][0]['answer'];
									}
								}
								$valuesi->addCell(600)->addImage($answer, array('width' => 100, 'height' => 100));
								
								if(isset($item['children'])) {
									foreach($item['children'] as $child) {
										$answer = '';
										$styleCell['bgColor'] = '0567A5';
										if(!empty($child['Game'])) {
											$answer = $child['Game'][0]['Game']['answer'];
										}
										$valuesi->addCell(3000, $styleCell)
												->addText($answer, $styleFont, $styleParagraph);
									}
								}
							}
						}
					/* My Vision - Picturing a Future */
					} elseif(in_array($game['Configuration']['id'], array(209))) {
						foreach($game['children'] as $key => $item) {
							if($item['Configuration']['status'] && $item['Configuration']['type'] == 2) {
								$answer = '';
								if(!empty($item['Game'])) {
									$answer	= $item['Game'][0]['Game']['answer'];
								}
								$section->addText($item['Configuration']['title'] . ' ' . $answer, $styleFont, $styleParagraph);
							}
						}
					/* The Why of Your Future */
					} elseif(in_array($game['Configuration']['id'], array(78, 279, 175))) {
						foreach($game['children'] as $key => $item) {
							if($item['Configuration']['status'] && $item['Configuration']['type'] == 5) {
								if($game['Configuration']['title'] == '**NH**') {
									$section->addText($item['Configuration']['sub_txt'],
											array('color' => '0080ff', 'size' => 14, 'name' => 'Calibri'));
								}
								
								$answer = '';
								if(!empty($item['Game'])) {
									$answer	= $item['Game'][0]['Game']['answer'];
								}
								$section->addText($answer, $styleFont, $styleParagraph);
							}
						}
					/* Building My Future Self : Distill - Values */
					} elseif(in_array($game['Configuration']['id'], array(99, 241))) {
						foreach($game['children'] as $key => $item) {
							if($item['Configuration']['status'] && $item['Configuration']['type'] == 14) {
								if(isset($item['children'])) {
									$valuesi = $section->addTable('tableStyle');

									$valuesi->addRow();
									$valuesi->addCell(10000, array('align' => 'center', 'valign' => 'center', 'bgColor' => '17B3E8'))
											->addText($item['Configuration']['title'], $styleFont, $styleParagraph);
									
									$section->addText('', null, array('spaceBefore' => 0, 'spaceAfter' => 0));
									$valuesi = $section->addTable('tableStyle');
									$colCount = 0;
									foreach($item['children'] as $child) {
										if(($colCount++ % 3) == 0) {
											$valuesi->addRow();
										}
										$answer = '';
										if(!empty($child['Game'])) {
											$answer = $child['Game'][0]['Game']['answer'];
										}
										$valuesi->addCell(3000, array('align' => 'center', 'valign' => 'center', 'bgColor' => '0567A5'))
												->addText($answer, $styleFont, $styleParagraph);
									}
									$section->addText('', null, array('spaceBefore' => 0, 'spaceAfter' => 0));
								}
							}
						}
					/* Designing Pathways to Embrace Values */
					} elseif(in_array($game['Configuration']['id'], array(217, 253))) {
						foreach($game['children'] as $key => $item) {
							if($item['Configuration']['status'] && $item['Configuration']['type'] == 3) {
								if(isset($item['children'])) {
									$valuesi = $section->addTable('tableStyle');
									$valuesi->addRow();
									$valuesi->addCell(10000, array('align' => 'center', 'valign' => 'center', 'bgColor' => '17B3E8'))
											->addText($item['Configuration']['title'], $styleFont, $styleParagraph);
									
									$section->addText('');
									$valuesi = $section->addTable('tableStyle');
									foreach($item['children'] as $child) {
										$valuesi->addRow();
										$valuesi->addCell(3000, array('align' => 'center', 'valign' => 'center', 'bgColor' => 'F68E20'))
												->addText($child['Configuration']['title'], $styleFont, $styleParagraph);
										$colCount = 0;
										foreach($child['Game'] as $ans) {
											if($colCount++ > 0) {
												$valuesi->addRow();
												$valuesi->addCell(3000)->addText('');
											}
											$valuesi->addCell(3000, array('align' => 'center', 'valign' => 'center', 'bgColor' => '0567A5'))
													->addText($ans['Game']['answer'], $styleFont, $styleParagraph);
										}
									}
								}
							}
						}
					/* Designing Pathways to Embrace Values */
					} elseif(in_array($game['Configuration']['id'], array(226))) {
						$valuesh = $section->addTable('tableStyle');
						$valuesi = $section->addTable('tableStyle');
						$valuest = $section->addTable('tableStyle');
						
						$valuesh->addRow();$valuesi->addRow();$valuest->addRow();

						foreach($game['children'] as $item) {
							if($item['Configuration']['status'] && $item['Configuration']['type'] == 9) {
								$valuesh->addCell(3000, array('align' => 'center', 'valign' => 'center', 'bgColor' => 'F68E20'))
										->addText($item['Configuration']['title'], $styleFont, $styleParagraph);
								$image  = '../webroot/img/profile.png';
								$answer = '';
								if(!empty($item['Game'])) {
									$ally = $this->requestAction(array('controller' => 'allies', 'action' => 'ally_detail', $item['Game'][0]['Game']['answer']));
									$image  = '../webroot/files/img/medium/' . $ally['User']['slug'];
									$answer = $ally['User']['name'];
								}
								$valuesi->addCell(600)->addImage($image, array('width' => 120, 'height' => 120));
								$valuest->addCell(3000, array('align' => 'center', 'valign' => 'center', 'bgColor' => '17B3E8'))
										->addText($answer, $styleFont, $styleParagraph);
							}
						}
					} elseif(in_array($game['Configuration']['id'], array(228))) {
						foreach($game['children'] as $item) {
							$valuesi = $section->addTable('tableStyle');
							$valuesi->addRow();
							$valuesi->addCell(10000, array('align' => 'center', 'valign' => 'center', 'bgColor' => 'F68E20'))
									->addText($item['Configuration']['title'], $styleFont, $styleParagraph);
							
							$section->addText('', null, array('spaceBefore' => 0, 'spaceAfter' => 0));

							foreach($item['children'] as $child) {
								if(isset($child['Dependent'])) {
									foreach($child['Dependent'] as $dependent) {
										$goal = $this->requestAction(array('controller' => 'challenges', 'action' => 'goal', $dependent['id']));
										if(!empty($goal)) {
											$valuesi = $section->addTable('tableStyle');
											$valuesi->addRow();
											$valuesi->addCell(3000, array('align' => 'center', 'valign' => 'center', 'bgColor' => '17B3E8'))
													->addText($goal['Challenge']['name'], $styleFont, $styleParagraph);
											$valuesi->addCell(3000, array('align' => 'center', 'valign' => 'center', 'bgColor' => '17B3E8'))
													->addText('Created: ' . $goal['Challenge']['created_on'], $styleFont, $styleParagraph);
											if($goal['Challenge']['status'] == 'Completed') {
												$valuesi->addCell(3000, array('align' => 'center', 'valign' => 'center', 'bgColor' => 'F68E20'))
														->addText($goal['Challenge']['status'], $styleFont, $styleParagraph);
											} else {
												$valuesi->addCell(3000, array('align' => 'center', 'valign' => 'center', 'bgColor' => '17B3E8'))
														->addText('Complete by: ' . $goal['Challenge']['complete_by'], $styleFont, $styleParagraph);
											}
											$section->addText('', null, array('spaceBefore' => 0, 'spaceAfter' => 0));
											
											$styleParagraph['align'] = 'left';
											$valuesi = $section->addTable('tableStyle');
											$valuesi->addRow();
											$image  = '../webroot/img/profile.png';
											if($goal['Challenge']['challenge_from_id'] != $goal['Challenge']['user_id']) {
												$image  = '../webroot/files/img/medium/' . $goal['ChallengeFrom']['slug'];
											}
											$valuesi->addCell(600)->addImage($image, array('width' => 120, 'height' => 120));
											$valuesi->addCell(10000)->addText($goal['Challenge']['description'], $styleFont, $styleParagraph);
											
											$valuesi->addRow();
											$valuesi->addCell(600, array('valign' => 'top', 'bgColor' => 'F68E20'))
													->addText('Summary notes: ', $styleFont, $styleParagraph);
											$valuesi->addCell(10000)->addText($goal['Challenge']['feedback'], $styleFont, $styleParagraph);
											
											$section->addText('', null, array('spaceBefore' => 0, 'spaceAfter' => 0));
											$styleParagraph['align'] = 'center';
										}
									}
								}
							}
						}
					} elseif (in_array($game['Configuration']['id'], array(177, 174))) {
						foreach($game['children'] as $key => $item) {
							if($item['Configuration']['status'] && $item['Configuration']['type'] == 7) {
								if($game['Configuration']['title'] == '**NH**') {
									$section->addText($item['Configuration']['sub_txt'], 
											array('color' => '0080ff', 'size' => 14, 'name' => 'Calibri'));
								}
								$answer = '';
								if(!empty($item['Game'])) {
									$answer	= $item['Game'][0]['Game']['answer'];
								}
								$section->addText($answer, $styleFont, $styleParagraph);
							}
						}
					} elseif (in_array($game['Configuration']['id'], array(169))) {
						foreach($game['children'] as $key => $item) {
							if($item['Configuration']['status'] && $item['Configuration']['type'] == 20) {
								if($game['Configuration']['title'] == '**NH**') {
									$section->addText($item['Configuration']['sub_txt'],
											array('color' => '0080ff', 'size' => 14, 'name' => 'Calibri'));
								}
								$valuesi = $section->addTable('tableStyle');
								foreach($item['children'] as $child) {
									$valuesi->addRow();
									$valuesi->addCell(1000)->addText($child['Configuration']['title'], $styleFont, $styleParagraph);
									$answer = '';
									if(!empty($child['Game'])) {
										$answer	= $child['Game'][0]['Game']['answer'];
									}
									$valuesi->addCell(1000, array('align' => 'center', 'valign' => 'center', 'bgColor' => 'F68E20'))
									->addText($answer, $styleFont, $styleParagraph);
								}
							}
						}
					}
				}
			}
		}
	}
}
$file = 'exported-images-and-texts.docx';
header("Content-Type: application/vnd.ms-word");
//header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment;filename="' . $file . '"');
header('Cache-Control: max-age=0');
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('php://output');
exit;