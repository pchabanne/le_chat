var firstScript = document.getElementsByTagName('script')[0];
var js = document.createElement('script');
js.src = 'js/functions.js';

js.onload = function () {

    tempsDinactiviteMax = convertMillisecondsToSeconds(tempsDinactiviteMax);

    console.log(tempsDinactiviteMax);
    var elem = document.querySelector('.modal');
    var instance = M.Modal.init(elem);

    $(function () {
        $('#bruit').draggable();
        $('#nuit').draggable();
    });

    $(window).mousemove(function () {
        tempsSouris = Date.now();
    });


    $('#bruit').click(function () {
        if (bruit) {
            bruit = false;
            document.getElementById("bruit").src = "images/nonote.png";
        }
        else {
            bruit = true;
            document.getElementById("bruit").src = "images/note.png";
        }
        focusOnMsg();
    });

    $('#nuit').click(function () {
        if (nuit) {
            nuit = false;
            modeJour();
        }
        else {
            nuit = true;
            modeNuit();
        }
        focusOnMsg();
    });

    divUsersmsg.onload = focusOnMsg();

    zoneTexte.addEventListener('keyup', compteur);

    $(document).ready(function () {
        $("#exit").click(function () {
            var exit = confirm("Êtes-vous sûr de vouloir partir?");
            if (exit == true) {
                window.location = 'index.php?logout=true';
            }
        });

    });

    $("#submitmsg").click(function () {
        var clientmsg = $("#usermsg").val();
        if (dateDernierMessage + tempsEntre2messages > Date.now()) {
            return false;
        }
        else if (clientmsg == "" || clientmsg == NaN) {
            return false
        }
        else if (clientmsg.length > nbCarac) {
            return false;
        }
        else if (isInactive()) {
        }
        else if (deconnecte) {
        }
        else {
            dateDernierMessage = Date.now();
            $.post("post.php", {text: clientmsg}, function () {
               setTimeout(loadLog(), 50);

            });
            $("#usermsg").val("");
            if (bruit) {
                audio.play();
            }
            return false;
        }
    });

    $(document).ready(function (e) {
        $("#formupload").on('change',(function(e) {
            $.ajax({
                url: "upload.php", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,
                success: function (data) {
                    if(data == "Erreur: mauvaise extension (jpeg, jpg et png seulement sont autorisés) ou fichier trop volumineux (2Mo environ maximum)"){
                        alert(data);
                    }
                }});
                document.getElementById('upload').value = null;
        }));
    });

    compteur();
    loadLog();
    setTimeout(animationScroll, 50);


    setInterval(loadLog, 2000);
    setInterval(jeSuisActif, 4000);

    $("#btnMasquerAfficher").on("click",function(){
        masquerAfficherUtilisateurs();
    });


    $('.smiley').on("click", function () {
        instance.close();
        setTimeout(focusOnMsg, 300);
        insererSmiley($(this).attr('value'));
    })
};
firstScript.parentNode.insertBefore(js, firstScript);