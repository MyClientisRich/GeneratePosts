<?php
if(isset($_POST["create"])) {
	create_posts($_POST["nb"], $_POST["type"], $_POST["annee_min"], $_POST["annee_max"], $_POST["tags"], $_POST["categs"], $_POST["etat"]);
}
?>

<div class="wrap">
	<h2>Generate posts</h2>
	
	<?php

	if(get_option("blog_public") == 1) {
		?>
		<div id="message" class="error">
			<p>
				Attention ! Vous n'avez pas bloqué l'indexation de vos contenus, les pages et articles générés risquent d'être indexés par les moteurs de recherche.
			</p>
		</div>
		<?php
	}
	?>

	<form action="" method="post">
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<label for="nb">
							Nombre d'article à générer :
						</label>
					</th>
					<td>
						<input type="text" name="nb" id="nb" value="1">
					</td>
				</tr>
				<tr>
					<th>
						<label for="etat">
							Etat des posts :
						</label>
					</th>
					<td>
						<select name="etat" id="etat">
							<option value="publish">Publier</option>
							<option value="draft">Brouillon</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>
						<label for="type">
							Type de contenu à générer :
						</label>
					</th>
					<td>
						<select name="type" id="type">
							<option value="post">Post</option>
							<option value="page">Page</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>
						<label for="annee_min">
							Dates comprises entre :
						</label>
					</th>
					<td>
						<select name="annee_min" id="annee_min">
							<?php for( $i=2000 ; $i < date("Y") ;$i++) { ?>
								<option value="<?=$i?>"><?=$i?></option>
							<?php } ?>
						</select>
						et
						<select name="annee_max" id="annee_max">
							<?php for($i = date("Y")-1 ;$i>1999;$i--) { ?>
								<option value="<?=$i?>"><?=$i?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr class="categs">
					<th>
						<label for="categs">Catégories :</label>
					</th>
					<td>
						<select multiple name="categs[]" id="categs">
							<option value="">-- Aucune --</option>
							<?php
							$args = array(
								'type'                     => 'post',
								'child_of'                 => 0,
								'parent'                   => '',
								'orderby'                  => 'name',
								'order'                    => 'ASC',
								'hide_empty'               => false,
								'hierarchical'             => 1,
								'exclude'                  => '',
								'include'                  => '',
								'number'                   => '',
								'taxonomy'                 => 'category',
								'pad_counts'               => false 

							); 
							$categories = get_categories( $args );

							foreach ($categories as $key => $categ) {
							?>
								<option value="<?=$categ->cat_ID?>"><?=$categ->cat_name?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr class="categs">
					<th>
						<label for="tags">Tags</label>
					</th>
					<td>
						<input type="text" name="tags" id="tags">
						<span class="help">Tags, séparés par des "," (virgules).</span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<button type="submit" class="button button-primary" name="create">Générer</button>
	</form>

	<div class="footer">
		Un plugin de <a href="http://www.myclientisrich.com">My Client is Rich</a>.

		<br><br>

		Ressources utilisées : <a href="http://loripsum.net" target="_blank">loripsum.net</a>, <a href="http://baconipsum.com" target="_blank">baconipsum.com</a>
	</div>
</div>