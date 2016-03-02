window.onload = function reloadOnNeed () {
    var dateCreation = new Date(document.lastModified)
    var dateActuelle = new Date();
    console.log("last update " + (dateActuelle.getTime() - dateCreation.getTime())/60000 + " minutes ago");
    if(dateActuelle.getTime() - dateCreation.getTime() > 60000*2) {
        $.ajax({
            url: 'htmlGenerator.php',
            type: 'GET',
            dataType: "json",
        }).done(function(){
            window.location.reload(true); 
        });
    }
}