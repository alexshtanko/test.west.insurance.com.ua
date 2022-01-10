jQuery(document).ready(function(){
  jQuery('.wpcf7-form').attr('id','ajax-contact-form');
  jQuery('.wpcf7-form').attr('enctype','multipart/form-data');
 });

jQuery(function() {
  document.getElementById('ajax-contact-form').addEventListener('submit', function(evt){
    var http = new XMLHttpRequest(), v = this;
    var th = jQuery(this);
    evt.preventDefault();
    http.open("POST", "/bitrix.php", true);
    http.onreadystatechange = function() {
      if (http.readyState == 4 && http.status == 200) {
        if (http.responseText.indexOf(v.nameFFF.value) == 0) {
          th.trigger("reset");
        }
        else{
          th.trigger("reset");
        }
      }
    }
    http.onerror = function() {
      alert('Помилка, попробуйте знову');
    }
    http.send(new FormData(v));
  }, false);
});
