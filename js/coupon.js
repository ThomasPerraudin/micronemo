$(document).ready(function(){
  $("#coupon-submit").click(function(){ saveCoupon(); });
});

function saveCoupon(){
  if(!validateForm()) return false;
  $("#coupon-submit").hide(0);
  $.ajax({
    type: "POST",
    url: "index.php",
    async: true,
    data: $("#coupon-form").serialize(),
    dataType: "text",
    error: function(data){
      alert("An error occured. Please try again.");
      $("#coupon-submit").show(0); 
    },
    success: function(data){
      if(data=="ok"){
        switchToPage("ok", false);
      }else if(data=="ok-no"){
        switchToPage("ok-no", false);
      }else{
        alert("An error occured. Please try again. ("+ data +")");
        $("#coupon-submit").show(0);
      }
    }
  }); 
}

function validateForm(){
  var bOK = true;
  var msg = "";
  
  var name = $("#coupon-form :input[name='name']").val();
  var morning = $("#coupon-form :input[name='morning']:checked").val();
  var afternoon = $("#coupon-form :input[name='afternoon']:checked").val();
  var evening = $("#coupon-form :input[name='evening']:checked").val();
  
  if(bOK && name==""){
    bOK = false;
    msg = "Please enter your name";
  }
  if(bOK && typeof(morning)=="undefined"){
    bOK = false;
    msg = "Please tick yes or no for the Morning";
  }
  if(bOK && typeof(afternoon)=="undefined"){
    bOK = false;
    msg = "Please tick yes or no for the Afternoon";
  }
  if(bOK && typeof(evening)=="undefined"){
    bOK = false;
    msg = "Please tick yes or no for the Evening";
  }
  
  if(!bOK) alert(msg);
  return bOK;
}
