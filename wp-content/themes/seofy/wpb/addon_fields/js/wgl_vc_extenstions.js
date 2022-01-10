(function( $ ) {

	/* Radio Image Select */
	$(".wgl-radio-image label").on("click", function() {
		$(this).addClass('selected').siblings().removeClass("selected");
		var current_img = $(this).find("img").attr("src"),
		current_val = $(this).find("input").val();
	    $(this).closest('.edit_form_line').find(".radio-image").val(current_val);
	});
	/* \Radio Image Select */

	/* Custom Checkbox */
	$('.vc_ui-panel-content-container').off().on("click", ".wgl_checkbox_label", function(){
		var $self = $(this),
		$checkbox = $self.siblings(".wgl_checkbox");

		$self.toggleClass("checked");

		if(!$self.hasClass("checked")) {
			$checkbox.removeAttr("checked").val("");
		} else {
			$checkbox.attr("checked","checked").val($self.data("value"));
		}

		$checkbox.trigger("change");
	});
	/* \Custom Checkbox */

})( jQuery );