<?php 
if(isset($no_result))
	{
	echo '<div style="background: rgba(255,0,160, 0.2); padding: 20px; margin-bottom: 20px; border: 1px dashed rgba(255,0,160, 1.0);">';
	echo '<h4>we hebben geen torrents gevonden met de zoekopdracht: '. $search .' !</h4>';
	echo '</div>';	
	}

if(isset($results))
	{
	echo '<div style="background: rgba(0,255,160, 0.2); padding: 20px; margin-bottom: 20px; border: 1px dashed rgba(0,255,160, 1.0);">';
	echo '<h4>we hebben '. $count .' torrent gevonden met de zoekopdracht: '. $search .' !</h4>';
	echo '</div>';
	
	echo '<div class="row">'; 

		foreach($results->result_array() as $torrentt)
		{
			if($torrentt['cover_thumb'])
			{
				$cover = '<img class="img-responsive" src="'. base_url('uploads/covers/'. $torrentt['cover_thumb'].'') .'">';
			}else{
				$cover = '<img class="img-responsive" src="http://placehold.it/130x200?text=Geen+cover">';
			}
			echo '<div class="col-xs-3">';
			echo '<a href="'. base_url('torrents/details/'. $torrentt['id'] .'') .'" class="thumbnail">';
			echo $cover;
			echo '</a>';
			//echo $torrentt['name'];
			echo highlight_phrase($torrentt['name'], $search, '<span style="color:#990000;"><strong>', '</strong></span>');
			echo '</div>';	
		}
	echo '</div>';
	}

