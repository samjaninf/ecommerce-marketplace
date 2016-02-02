jQuery(document).ready(function() {
  jQuery('.coffee-signup').keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
