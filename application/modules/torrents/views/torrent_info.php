<style>
.category-detail {
	border-radius: 5px;
    padding: 4px 15px;
    background: #303030;
	margin-bottom: 20px;
	

}

.category-detail .list li:first-child{
    border-top: none;
    box-shadow: none;
}

.category-detail .list li {
    border-top: 1px solid #464646;
    box-shadow: 0 -1px 0 #1d1d1d;
}

.category-detail .list li strong {
    display: inline-block;
    width: 90px;
    font-size: 12px;
    line-height: 30px;
    color: #fff;
    font-weight: 700;
}

.category-detail .list li span {
    display: inline-block;
    /*width: 180px;*/
    font-size: 12px;
    line-height: 30px;
    color: #adadad;
    position: relative;
    padding-left: 13px;
}
</style>

<div class="category-detail">
<div class="row">
	<div class="col-xs-4">
		<ul class="list">
        <li><strong>Category</strong><span><?php echo $row->cat_name ?></span></li>
        <li><strong>Total size</strong><span><?php echo byte_format($row->size, 2) ?></span></li>
        <li><strong>Total files</strong><span><?php echo $row->numfiles ?> files</span></li>
    </ul>
	</div>
	<div class="col-xs-4">
    <ul class="list">
        <li><strong>Downloads</strong><span><?php echo $row->times_completed ?></span> </li>
        <li><strong>Last checked</strong><span><?php echo timespan(human_to_unix($row->last_action), time(), 1) ?> ago</span></li>
        <li><strong>Date uploaded</strong><span><?php echo timespan(human_to_unix($row->added), time(), 1) ?> ago</span></li>

    </ul>	
	</div>
	<div class="col-xs-4">
    <ul class="list">

        <li><strong>Seeders</strong><span class="text-success"><?php echo $row->seeders ?></span></li>
        <li><strong>Leechers</strong><span class="text-danger"><?php echo $row->leechers ?></span></li>
		<li><strong>Uploaded By</strong><span><?php echo $this->member->get_username($row->owner);?></span></li>
    </ul>	
	</div>



</div>
</div>





