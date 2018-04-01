<?php 


	if ($this->get_user_class() >= UC_GOD)
		{
		$this->staffunctions(UC_GOD);
		}




	if ($this->get_user_class() >= UC_BEHEERDER)
		{
		$this->staffunctions(UC_BEHEERDER);
		}

	
	

	if ($this->get_user_class() >= UC_ADMINISTRATOR)
		{
		$this->staffunctions(UC_ADMINISTRATOR);
		}


	
	if ($this->get_user_class() >= UC_MODERATOR)
		{
		$this->staffunctions(UC_MODERATOR);
		}

?>

