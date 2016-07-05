$(document).on("click", "*[data-ajax]", function(){
  if(isSwitchingPage) return false;
  switchPage(this);
  return false;
});

function switchPage(el){
  pageURL = $(el).attr("data-ajax");
  switchToPage(pageURL);
}
function switchToPage(pageURL, pushState){
  isSwitchingPage = true;
  //hide content then load content
  var container = "#content-wrapper";
  $(container).css("z-index", "-1").animate({"opacity": "0"}, 400, function(){ $(this).css({"display": "none"}); loadPage(pageURL, pushState)});
}

function loadPage(pageURL, pushState){
  if(typeof(pushState)=="undefined") pushState = true;
  
  //launch async ajax request and display result
  $.ajax({
    type: "POST",
    url: "index.php",
    async: true,
    data: "page="+ pageURL,
    dataType: "text",
    error: function(data){
      isSwitchingPage = false;
      alert("An error occured. Please try again.");
    },
    success: function(data){
      $("#content-wrapper").html(data);
      
      pageName = pageURL;
      if(pageURL.indexOf("&", 0)!=-1) pageName = pageURL.substring(0,pageURL.indexOf("&", 0));
      
      window.scroll(0, 1); //for ios
      $("#content-wrapper").scrollTop(0);
      $("#content-wrapper").css({"display": "block"}).animate({"opacity": "1"}, "slow", function(){ isSwitchingPage = false; });
        
      if(pushState && typeof(window.history.pushState) != "undefined"){
        document.title = pageName[0].toUpperCase() + pageName.substring(1);
        res = window.history.pushState(pageURL, document.title, "?page="+pageURL);
      }
    }
  }); 
}