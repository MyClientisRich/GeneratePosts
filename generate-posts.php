<?php
/**
 * Plugin Name: Generate Posts
 * Plugin URI:  http://www.myclientisrich.com
 * Text Domain: generate-posts
 * Domain Path: /languages
 * Description: Generate posts or page for developement. Including categories and tags.
 * Author:      My Client is Rich
 * Author URI:  http://www.myclientisrich.com
 * Donate URI:  hhttp://www.myclientisrich.com
 * Version:     1.0
 */


function content_GP() {
	wp_enqueue_script("jquery");
	wp_enqueue_script( "adminjs", plugin_dir_url(__FILE__)."/admin.js");

	include(dirname(__FILE__)."/admin.php");
}

function my_plugin_menu_gp() {
	add_menu_page('Generate Posts by My Client is Rich', 'Generate Posts', 'read', 'generate-posts', 'content_GP', 'dashicons-admin-page', 6247);
}
add_action('admin_menu', 'my_plugin_menu_gp');

function create_posts($nb_posts = 1, $type = "post", $annee_min = 2000, $annee_max = 2013, $tags = "", $categs = "", $etat = "publish") {

	if($type == "post") {
		$tags = explode(",", $tags);
		if(empty($categs[0])) {
			$categs = "";
		}
	} else {
		$categs = "";
		$tags = "";
	}

	for($i=1;$i<=$nb_posts;$i++) {

		$content =  file_get_contents("http://loripsum.net/api/6/medium/headers/decorate/link/ul/ol/dl/bq/quote");
		$excerpt = file_get_contents("http://loripsum.net/api/1/small/plaintext");
		
		$json = json_decode(file_get_contents("http://baconipsum.com/api/?type=all-meat&sentences=1&start-with-lorem=0"));
		
		$max_title = rand(50,80);
		$title = substr($json[0], 0, $max_title);

		$jour = rand(1,28);
		$mois = rand(1,12);

		if($annee_max < $annee_min) {
			$annee_max = $annee_min;
		}
		$annee = rand($annee_min,$annee_max);

		$heure = rand(0,23);
		$min = rand(0,59);
		$sec = rand(0,59);

		$date = $annee."-".$mois."-".$jour." ".$heure.":".$min.":".$sec;
		$gmdate = gmdate("Y-m-d H:i:s", strtotime($date));


		$post = array(
			  'post_content'   => $content, // The full text of the post.
			  'post_name'      => $type."-test-".$i, // The name (slug) for your post
			  'post_title'     => $title, // The title of your post.
			  'post_status'    => $etat,
			  'post_type'      => $type,
			  'post_excerpt'   => $excerpt, // For all your post excerpt needs.
			  'post_date'      => $date, // The time post was made.
			  'post_date_gmt'  => $gmdate, // The time post was made, in GMT.
			  'post_category'  => $categs,
			  'tags_input'     => $tags
		);

		$retour = wp_insert_post($post, false);

		if($retour == 0) {
			?>
			<div id="message" class="error">
				<p>
					Erreur lors de la génération du post <?=$i?>
				</p>
			</div>

			<?php
		} else {
			?>
			<div id="message" class="updated">
				<p>
					Success (<?=$type?> <?=$i?>)<br>
					<?=$type?> <?=$retour?> "<?=$title?>" <a href="/wp-admin/post.php?post=<?=$retour?>&action=edit" class="button button-primary">Modifier</a> <a href="<?=get_permalink($retour)?>" class="button button-primary">Voir</a>
				</p>
			</div>

			<?php
		}
	}
}
?>