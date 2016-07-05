//Make checkboxes with class checkboxRadio behave like radio buttons
$(document).on("click", "input:checkbox.checkboxRadio", function(){
  $("input:checkbox[name='"+ $(this).attr("name") +"']").prop("checked",false);
  $(this).prop("checked",true);
});