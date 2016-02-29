function reloadOnNeed () {
    var dateCreation = new Date(document.lastModified)
    var dateActuelle = new Date();
    var info = document.getElementById ("info");
    info.innerHTML = "last update" + (dateActuelle.getTime() - dateCreation.getTime())/60000 + "minutes ago";
    if(dateActuelle.getTime() - dateCreation.getTime() > 60*3*1000) {
        $.ajax({
            url: "htmlGenerator.php",
            context: document.body,
            success: function(){function(html) {
                        location.reload();
            }}
        });
    }
}
