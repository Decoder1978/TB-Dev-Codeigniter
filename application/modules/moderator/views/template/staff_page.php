<?php 

	$eigenaar 	= $this->db->where('class', 7)->get('users')->num_rows();
	$beheerder 	= $this->db->where('class', 6)->get('users')->num_rows();
	$admin 		= $this->db->where('class', 5)->get('users')->num_rows();
	$mod 		= $this->db->where('class', 4)->get('users')->num_rows();
	$uppie 		= $this->db->where('class', 3)->get('users')->num_rows();

	


if($eigenaar > 0)
{
echo begin_frame("$eigenaar - ". $this->member->get_user_class_name(UC_GOD) ."","primary");
$this->member->stafftable(UC_GOD);
echo end_frame();
}

if($eigenaar > 0)
{
echo begin_frame("$beheerder - ". $this->member->get_user_class_name(UC_BEHEERDER) ."","primary");
$this->member->stafftable(UC_BEHEERDER);
echo end_frame();
}

/*if($admin > 0)
{
tabel_top("$admin - ". get_user_class_name(UC_ADMINISTRATOR) ."");
begin_frame();
stafftable(UC_ADMINISTRATOR);
end_frame();
}

if($mod > 0)
{
tabel_top("$mod - ". get_user_class_name(UC_MODERATOR) ."");
begin_frame();
stafftable(UC_MODERATOR);
end_frame();
}

if($uppie > 0)
{
tabel_top("$uppie - ". get_user_class_name(UC_UPLOADER) ."");
begin_frame();
stafftable(UC_UPLOADER);
end_frame();
}*/