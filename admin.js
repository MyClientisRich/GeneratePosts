(function($){$(document).ready(function(){
	$categs = $(".categs");

	$("select#type").change(function(event){
		if($(this).val() != "post") {
			$categs.hide();
		} else {
			$categs.show();
		}
	});
});})(jQuery);
		