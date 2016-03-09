setInterval(function () {
  $.ajax({
    url: './inc/getData.php',
    type: 'get',
    success: function(output) {
      if(output=='0') {
        $("body").load(document.URL + ' #conteneur', function(){
          console.log("page refreshed !");
          document.location.reload(true);
        });
      }
      else
        console.log("no need to refresh");
    }
  });}, 10000);