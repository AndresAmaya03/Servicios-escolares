<?php
ini_set('display_errors','On');
ini_set('error_reporting',E_ALL);
?>

<div class="container is-fluid mb-6">
	<h1 class="title">Expediente</h1>
	<h2 class="subtitle">Generar inventario general de archivo de tramite</h2>
</div>
<div class="container pb-6 pt-6">
	<form action="./php/save_table.php" method="POST" >
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Generar inventario general</button>
		</p>
	</form>
</div>
<div class="container pb-6 pt-6">
	<form action="./php/save_cejilla.php" method="POST" >
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Generar cejillas</button>
		</p>
	</form>
</div>