<?php 
			$comment_table = '<div class="panel panel-default">';
			$comment_table .= '<div class="panel-heading">';
			$comment_table .= 'Door '. $row['username'];
			
				if ($this->member->get_user_class() >= UC_ADMINISTRATOR)
				{				
					$comment_table .= '<a class="pull-right btn btn-danger btn-xs" href=deletecomment.php?id=$row[id]><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>&nbsp;&nbsp';
				}
				
			$comment_table .= " op " . $row["added"] . " " . ($this->member->get_user_class() >= UC_MODERATOR || $this->session->userdata('user_id') == $row["user"] ? "<a class='pull-right btn btn-default btn-xs' href=comment.php?action=edit&amp;cid=$row[id]><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>" : "") . "";
			$comment_table .= '</div>';
			$comment_table .= '<div class="panel-body">';
			$body = stripslashes($row["text"]);
			$comment_table .= $body;
			$comment_table .= '</div>';
			$comment_table .= '</div>';
			
			echo $comment_table ;
?>