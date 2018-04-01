

</div>


</div>
</div>
<footer>
	<div class="footer">
		<div class="container">
			<div class="row">
				<div class="col-xs-6">footer</div>
				<div class="col-xs-6"><span class="pull-right">Pagina geladen in {elapsed_time} seconden</span><br /><span class="pull-right">{memory_usage} Aan geheugen was daarvoor nodig</span></div>
			</div>
		</div>
	</div>
</footer>
</div>
    <script>
        $(function() {
          // Javascript to enable link to tab
          var hash = document.location.hash;
			if (hash) {
            console.log(hash);
            $('.nav-tabs a[href='+hash+']').tab('show');
          }

          // Change hash for page-reload
          $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            window.location.hash = e.target.hash;
          });
        });
    </script>
 </body>
</html>