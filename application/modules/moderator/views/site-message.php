<?php
print"<table class='table table-bordered'>";
print"<tr><th colspan=2>Onderhoudstekst</th></tr>";

print"<tr><td>Onderhoud tekst aanpassen.<br>";
print "<form method=post action='". base_url('moderator/site_message') ."'>";
print "<input type=hidden name=action value=onderhoud_tekst>";
print "<textarea class='form-control' rows='10' name=service_text>" . htmlspecialchars($SV['text']) . "</textarea>";
print "<br>\n";
print "<input class='btn btn-default' type=submit value='Onderhoudstekst opslaan'>";
print "</form>";

if ($SV['active'] == 'yes')
	{
	print "<form method=post action=''>";
	print "<input type=hidden name=action value=onderhoud_uit>";
	print "<input class='btn btn-danger' type=submit value='Onderhoud uitzetten, staat momenteel aan.'>";
	print "</form>";
	}
else
	{
	print "<form method=post action=''>";
	print "<input type=hidden name=action value=onderhoud_aan>";
	print "<input class='btn btn-success' type=submit value='Onderhoud aanzetten, staat momenteel uit.'>";
	print "</form>";
	}
print"</td></tr></table>";

?>