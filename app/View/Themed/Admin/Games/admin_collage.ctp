<?php
	echo $this->Html->css(array('../plugins/galereya/css/jquery.galereya'));
	echo $this->Html->script(array('../plugins/galereya/js/jquery.galereya.min'));
?>
<div class="row">
	<div class="col-md-12">
		<div id="gallery"><?php
			$cnt = 0;
			if(isset($collage) && !empty($collage)){
				foreach($collage as $collages){
					foreach($collages as $image){
						if (!empty($image[0]) && file_exists('files/img/medium/' . $image[0])) {
							$cnt++;
	            			echo $this->Html->image('../files/img/medium/'.$image[0], 
			                                        array(
			                                        	'data-fullsrc'  => '../../../files/img/large/' . $image[0],
													 	'data-desc'		=> isset($image[1])? $image[1]: '',
														'width'			=> 100));
						}
					}
				}
			}
		?>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<script>
	var cnt = <?php echo $cnt; ?>;
	$(document).ready(function(){	
		$('#gallery').galereya();
		$('#gallery').height(45 * cnt);
	});
</script>