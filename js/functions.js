//compteur() supprimer() supprimer.php
// ideoytb, masquerafficher utilisateurs

var tempsTransition = 800;
var chatbox = $('#chatbox');
var height = chatbox[0].scrollHeight;
let nbCarac = 250;
let tempsEntre2messages = 2000;
let tempsDinactiviteMax = 600;
let dateDernierMessage = Date.now() - tempsEntre2messages;
let deconnecte = false;
let tempsSouris = Date.now();
let tempsClavier = Date.now();
var zoneTexte = document.querySelector('#usermsg');
var compteurHTML = document.getElementById('compteur');
var divUsers = document.getElementById('users');
var divUsersmsg = document.getElementById('usermsg');
var divChatbox = document.getElementById('chatbox');
let audio = new Audio("son/bruit.mp3");
let bruit = true;
let nuit = false;
let connexion = true;
let lastid = 0;
let afficher = true;
var derniereActivite = Date.now();

function convertMillisecondsToSeconds(i) {
    return i * 1000
}

function masquerAfficherUtilisateurs() {
    if (afficher) {
        $("#users").animate({maxHeight: "0px"}, tempsTransition);
        afficher = false;
        $("#btnMasquerAfficher").text("+");
    } else {
        let taille = $(document).width();
        if (taille >= 1000) {
            $("#users").animate({maxHeight: "42.5em"}, tempsTransition);
        }else{
            $("#users").animate({maxHeight: "8em"}, tempsTransition);
        }
        afficher = true;
        $("#btnMasquerAfficher").text("-");
    }
}

function modeNuit() {
    $('body').animate({backgroundColor: '#202938', color: "white"}, tempsTransition);
    $('#chatbox').animate({backgroundColor: '#274053', borderBottom: 'black'}, tempsTransition);
    $('#usermsg').animate({backgroundColor: "#274053", borderColor: 'black', color: "white"}, tempsTransition);
    $('#users').animate({backgroundColor: "#274053", borderColor: "black"}, tempsTransition);
    $('#modal1').animate({backgroundColor: "#274053"}, tempsTransition);
    $("#chatbox").toggleClass("ombre", tempsTransition);
    $("#users").toggleClass("ombre", tempsTransition);
    $("#usermsg").toggleClass("ombre", tempsTransition);

    $("#chatbox").toggleClass("border", tempsTransition);
    $("#users").toggleClass("border", tempsTransition);
    $("#usermsg").toggleClass("border", tempsTransition);

}

function modeJour() {
    $('#chatbox').animate({'boxShadowX': "1em", 'boxShadowY': "5em"});

    $('body').animate({backgroundColor: '#ABABAB', color: "black"}, tempsTransition);
    $('#chatbox').animate({backgroundColor: 'F8F8F8', borderColor: 'black'}, tempsTransition);
    $('#usermsg').animate({backgroundColor: "F8F8F8", borderColor: 'black', color: "black"}, tempsTransition);
    $('#users').animate({backgroundColor: "#F8F8F8", borderColor: "black"}, tempsTransition);
    $('#modal1').animate({backgroundColor: "white"}, tempsTransition);
    $("#chatbox").toggleClass("ombre", tempsTransition);
    $("#users").toggleClass("ombre", tempsTransition);
    $("#usermsg").toggleClass("ombre", tempsTransition);

    $("#chatbox").toggleClass("border", tempsTransition);
    $("#users").toggleClass("border", tempsTransition);
    $("#usermsg").toggleClass("border", tempsTransition);

}

function supprimer() {
    $.post("supprimer.php", {supprimer: "yes"});
}

function adapterDate(d) {
    hint = d.getHours();
    if (hint < 10) {
        hstring = "0" + String(hint);
    } else {
        hstring = String(hint);
    }
    mint = d.getMinutes();
    if (mint < 10) {
        mstring = "0" + String(mint);
    } else {
        mstring = String(mint);
    }
    sint = d.getSeconds();
    if (sint < 10) {
        sstring = "0" + String(sint);
    } else {
        sstring = String(sint);
    }
    var date = hstring + ":" + mstring + ":" + sstring;
    return date;
}

function compteur() {
    var compteur = nbCarac - zoneTexte.value.length;
    compteurHTML.innerHTML = compteur;

    if (compteur < 0) {
        compteurHTML.classList.add("red");
    }
    else if (compteur >= 0) {
        compteurHTML.classList.remove("red");
    }

    if (zoneTexte.value == "/clear") {
        supprimer();
    }

    tempsClavier = Date.now();
}


function insererPseudo(pseudo) {
    if (zoneTexte.value.length == 0 || zoneTexte.value[zoneTexte.value.length - 1] == " ") {
        zoneTexte.value = zoneTexte.value + "@" + pseudo + " ";
    }
    else {
        zoneTexte.value = zoneTexte.value + " @" + pseudo + " ";
    }
    document.getElementById('usermsg').focus();
}

function insererSmiley(smiley) {
    if (zoneTexte.value.length == 0 || zoneTexte.value[zoneTexte.value.length - 1] == " ") {
        zoneTexte.value = zoneTexte.value + smiley + " ";
    }
    else {
        zoneTexte.value = zoneTexte.value + " " + smiley + " ";
    }
}


function isInactive() {
    if (Date.now() - tempsSouris > tempsDinactiviteMax && Date.now() - tempsClavier > tempsDinactiviteMax) {
        return true;
    }
    else {
        return false;
    }
}

function stripslashes(str) {
    return str.replace(/\\(.)/mg, "$1");
}

function noscroll() {
    var newscrollHeight = $("#chatbox").attr("scrollHeight");
    divChatbox.scrollTo(0, newscrollHeight);
    newscrollHeight = $("#users").attr("scrollHeight");
    divUsers.scrollTo(0, newscrollHeight);
}

function focusOnMsg() {
    document.getElementById('usermsg').focus();
}

function popin() {
    let popin = document.createElement("div");
    let titre = document.createElement("h3");
    let texte = document.createTextNode("vous avez été deconnecté en raison d'un temps d'inactivité trop élevé");
    titre.appendChild(texte);
    popin.id = "popin";
    popin.appendChild(titre);
    $(document.body).empty();
    $(document.body).append(popin);
}

function miseEnFormeMessage(date, expediteur, text) {
    if (expediteur == null) {
        var message = text;
    } else {
        var message = "<div class='msgln'>(" + date + ") <b><div class='linkuser' onclick='insererPseudo(\"" + expediteur + "\")'>" + expediteur + "</div></b>: " + stripslashes(text) + "<br></div>" + "\r\n";
    }
    return message;
}

function animationScroll() {
    var wtf = $('#chatbox');
    var height2 = wtf[0].scrollHeight;
    $("#chatbox").animate({scrollTop: height2}, 'slow');
}

function recupDernierMessage(data, i) {
    var d = new Date(data.messages[i].date * 1000);
    var date = adapterDate(d);
    var message = miseEnFormeMessage(date, data.messages[i].expediteur, data.messages[i].text);
    html = html + message;
    if (connexion === true) {
        $("#chatbox").html(html);
        connexion = false;
    } else {
    }

}

function objectLength(obj) {
    var result = 0;
    for(var prop in obj) {
        if (obj.hasOwnProperty(prop)) {
            // or Object.prototype.hasOwnProperty.call(obj, prop)
            result++;
        }
    }
    return result;
}


function loadLog() {
    if (isInactive() && deconnecte == false) {
        $.post("php/deconnexion.php", {deconnexion: true});
        divUsersmsg.disabled = true;
        divChatbox.addEventListener('scroll', noscroll);
        divUsers.addEventListener('scroll', noscroll);
        deconnecte = true;
        popin();
        $(window).unbind("mousemove");
    }
    else if (deconnecte == true) {
        divUsersmsg.disabled = true;
    }
    else {
        $.getJSON("conversation.php", function (data) {
            let nbmessage = objectLength(data);
            if (connexion == true) {
                let html = "";
                if (nbmessage >= 40) {
                    for (var i = 0; i < 40; i++) {
                        var d = new Date(data[i].date * 1000);
                        var date = adapterDate(d);
                        var message = miseEnFormeMessage(date, data[i].expediteur, data[i].text);
                        html = html + message;
                        $("#chatbox").html(html);
                    }
                }
                else {
                    for (var i = 0; i < nbmessage; i++) {
                        var d = new Date(data[i].date * 1000);
                        var date = adapterDate(d);
                        var message = miseEnFormeMessage(date, data[i].expediteur, data[i].text);
                        html = html + message;
                        $("#chatbox").html(html);
                    }
                }
                connexion = false;
                lastid = data[nbmessage-1].id;
            }
            else if (nbmessage !== 0) {
                if (lastid !== data[nbmessage-1].id) {
                    if (nbmessage >= 40) {
                        console.log(1);
                        console.log(40-(data[39].id-lastid));
                        for (var i = 40-(data[39].id-lastid); i < 40; i++) {
                            var d = new Date(data[i].date * 1000);
                            var date = adapterDate(d);
                            var message = miseEnFormeMessage(date, data[i].expediteur, data[i].text);
                            $("#chatbox").html($("#chatbox").html() + message);
                        }
                        lastid = data[39].id;
                        animationScroll();
                    }
                    else {
                        for (var i = nbmessage-(data[nbmessage-1].id-lastid); i < nbmessage; i++) {
                            var d = new Date(data[i].date * 1000);
                            var date = adapterDate(d);
                            var message = miseEnFormeMessage(date, data[i].expediteur, data[i].text);
                            $("#chatbox").html($("#chatbox").html() + message);
                        }
                        lastid = data[nbmessage-1].id
                        animationScroll();
                    }
                }
            }
        });

        $.getJSON("users.php", function (data) {
            var items = [];
            for (let i in data) {
                console.log(data);
                items.push("<div class='utilisateurs'>" + data[i].pseudo + "<br></div>");
            }
            var html = '';
            for (let i in items) {
                html = html + items[i];
            }
            $("#users").html(html);
        });
    }
}

function envoyerMessage() {
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
}

function lastActivity(){
    if(tempsClavier>=tempsSouris){
        return tempsClavier;
    }
    else{
        return tempsSouris;
    }
}


function jeSuisActif() {
    if (isInactive()) {

    } else {
        var d = lastActivity();
        if(derniereActivite == d){

        }
        else{
            derniereActivite = lastActivity();
            $.post("actif.php", {actif: "yes"});
            deconnecte = false;
        }
    }
}