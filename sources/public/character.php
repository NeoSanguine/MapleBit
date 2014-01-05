<?php
if(isset($_GET['n'])) {
	$getchar = $mysqli->real_escape_string($_GET['n']);
	$getchar = preg_replace("/[^A-Za-z0-9_]/", '', $getchar); # Escape and Strip
	$checkchar = $mysqli->query("SELECT * from characters WHERE name = '".$getchar."'");
	$countchar = $checkchar->num_rows;
	if($countchar == 1) {
		$c = $checkchar->fetch_assoc();
		$backcolor="";
		$rootfolder = "";
		require_once("assets/img/GD/coordinates.php");
		require_once("assets/img/GD/cache_character.php");	
		createChar($c['name'], $rootfolder);
		$cachechar = $mysqli->query("SELECT hash, name FROM ".$prefix."gdcache WHERE name='".$c['name']."'")->fetch_assoc();

		echo "<h2 class=\"text-left\">Character Info</h2><hr/>";
		echo "
		<div class=\"row\">
		<div class=\"col-md-6 col-md-offset-3\">
			<div class=\"well\">
				<h3 class=\"text-center\"> " . $c['name'] . "</h3>
				<hr/>
				<img src=\"".$siteurl."assets/img/GD/Characters/".$cachechar['hash'].".png\" alt=\"".$cachechar['name']."\" class=\"avatar img-responsive\" style=\"margin: 0 auto;\">
				<hr/>
				<b>Job:</b> " . $c['job'] . "<br/>
				<b>Level:</b> " . $c['level'] . "<br/>
				<b>EXP:</b> " . $c['exp'] . "<br/>
				<b>Rebirths:</b> Coming Soon
			</div>
		</div>
		</div>";
	} else {
		echo "<div class=\"alert alert-danger\">This character doesn't exist!</div>";
		redirect_wait5("?base=main");
	}
} else {
	echo "<div class=\"alert alert-danger\">This character doesn't exist!</div>";
	redirect_wait5("?base=main");
}
?>