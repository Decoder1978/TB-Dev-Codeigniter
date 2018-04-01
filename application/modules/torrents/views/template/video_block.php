<?php $videoLink ="http://www.youtube.com/watch?v=yRuVYkA8i1o";   ?>
<?php
    parse_str( parse_url( $videoLink, PHP_URL_QUERY ), $my_array_of_vars );
    $youtube_ID = $my_array_of_vars['v'];    
?> 
<a class="video" data-toggle="modal" data-target="#myModal" rel="<?php echo $youtube_ID;?>">
    <img src="" />
</a>

<div class="modal fade video-lightbox" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script> 
    jQuery(document).ready(function ($) {
        var $midlayer = $('.modal-body');     
        $('#myModal').on('show.bs.modal', function (e) {
            var $video = $('a.video');
            var vid = $video.attr('rel');
            var iframe = '<iframe />';  
            var url = "//youtube.com/embed/"+vid+"?autoplay=1&autohide=1&modestbranding=1&rel=0&hd=1";
            var width_f = '100%';
            var height_f = 400;
            var frameborder = 0;
            jQuery(iframe, {
                name: 'videoframe',
                id: 'videoframe',
                src: url,
                width:  width_f,
                height: height_f,
                frameborder: 0,
                class: 'youtube-player embed-responsive-item allowfullscreen',
                type: 'text/html',
                allowfullscreen: true
            }).appendTo($midlayer);   
        });

        $('#myModal').on('hide.bs.modal', function (e) {
            $('div.modal-body').html('');
        }); 
    });
</script>