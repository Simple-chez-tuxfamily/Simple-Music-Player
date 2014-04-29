$(function() {
    $('#playpause').click(function() {
        if (fichier_en_cours != null) playpause();
    });
    $('#suivant').click(function() {
        suivant();
    });
    $('#precedent').click(function() {
        precedent();
    });
    $('#shuffle').click(function() {
        if (hasard == 0) {
            hasard = 1;
            $('#shuffle').toggleClass('actif');
        } else {
            hasard = 0;
            $('#shuffle').toggleClass('actif');
        }
    });
    $('#repeat').click(function() {
        if (encore == 0) {
            encore = 1;
            $('#repeat').toggleClass('actif');
        } else if (encore == 1) {
            encore = 2;
            $('#mode').css('display', 'block');
        } else {
            encore = 0;
            $('#repeat').toggleClass('actif');
            $('#mode').css('display', 'none');
        }
    });
    player_is_ready = false;
    $('#jplayer').jPlayer({
        swfPath: 'theme/jplayer.swf',
        solution: 'flash,html',
        supplied: 'mp3,oga,m4v,wav',
        volume: 1,
        ready: function() {
            player_is_ready = true;
        },
        timeupdate: function(event) {
            timeupdate(event)
        }
    });
    $('#jplayer').bind($.jPlayer.event.progress, function(event) {
        if (event.jPlayer.status.seekPercent === 100) chargement = false;
        else chargement = true;
    });
    animation_marquee();
});

function jouer_son(url) {
    if (click_neutralise == false) {
        if (player_is_ready) {
            $('#slider').slider('option', 'disabled', false);
            $('#playpause').html('b');
            changer_infos_son(url);
            $('#jplayer').jPlayer('setMedia', {
                'mp3': url
            }).jPlayer('play');
        } else afficher_message('Le player n\'est pas prêt!', 10, 0);
    }
}

function seconds2ms(time) {
    time = Math.round(time);
    minutes = Math.floor(time / 60);
    if (minutes < 10) minutes = '0' + minutes;
    secondes = time % 60;
    if (secondes < 10) secondes = '0' + secondes;
    return minutes + ':' + secondes;
}

function timeupdate(event) {
    $('#actuel').html(seconds2ms(event.jPlayer.status.currentTime));
    $('#total').html(seconds2ms(event.jPlayer.status.duration));
    if (sliding_manuel == false) {
        $('#slider').slider({
            value: Math.ceil(event.jPlayer.status.currentTime),
            max: Math.ceil(event.jPlayer.status.duration)
        });
    }
    if (dernier_temps_enregistre > 5 && dernier_temps_enregistre > Math.floor(event.jPlayer.status.currentTime) && chargement == false && event.jPlayer.status.duration > 0) suivant();
    else dernier_temps_enregistre = Math.floor(event.jPlayer.status.currentTime);
}

function playpause() {
    if ($('#jplayer').data().jPlayer.status.paused) {
        $('#playpause').html('b');
        $('#jplayer').jPlayer('play');
    } else {
        $('#playpause').html('a');
        $('#jplayer').jPlayer('pause');
    }
}

function shuffle_et_envoie(page, nom_fichier, id_playlist) {
    ancien_array = page.split(',;,');
    nouvel_array = new Array();
    do {
        id = Math.floor(Math.random() * ancien_array.length);
        nouvel_array.push(ancien_array[id]);
        ancien_array.splice(id, 1);
    } while (ancien_array.length > 0)
    playlist_aleatoire = nouvel_array;
    charge = true;
    if (nom_fichier != null) jouer(fichier_vers_id(nom_fichier))
    else if (id_playlist != null) jouer(id_playlist)
};

function charger_playlist(artist_name, album_name, nom_fichier, id_playlist) {
    if (artist_name === undefined) artist_name = null;
    if (album_name === undefined) album_name = null;
    if (nom_fichier === undefined) nom_fichier = null;
    if (id_playlist === undefined) id_playlist = null;
    if (playlist_actuelle != 'pl' + artist_name + album_name) {
        charge = false;
        player_raz();
        playlist_actuelle = 'pl' + artist_name + album_name;
        if (artist_name != null && album_name == null) {
            $.ajax({
                url: 'core/interact.php?token=[PHP_ADD_TOKEN]&action=playlist&artist_name=' + artist_name,
                cache: true,
                success: function(page) {
                    succes_chargement(page, nom_fichier, id_playlist)
                },
                error: function() {
                    afficher_message('impossible de charger les titres à lire.', 10, 0);
                }
            });
        } else if (artist_name != null && album_name != null) {
            $.ajax({
                url: 'core/interact.php?token=[PHP_ADD_TOKEN]&action=playlist&artist_name=' + artist_name + '&album_name=' + album_name,
                cache: true,
                success: function(page) {
                    succes_chargement(page, nom_fichier, id_playlist)
                },
                error: function() {
                    afficher_message('impossible de charger les titres à lire.', 10, 0);
                }
            });
        } else {
            $.ajax({
                url: 'core/interact.php?token=[PHP_ADD_TOKEN]&action=playlist',
                cache: true,
                success: function(page) {
                    succes_chargement(page, nom_fichier, id_playlist)
                },
                error: function() {
                    afficher_message('impossible de charger les titres à lire.', 10, 0);
                }
            });
        }
    } else {
        if (nom_fichier != null) jouer(fichier_vers_id(nom_fichier))
        else if (id_playlist != null) jouer(id_playlist)
    }
}

function succes_chargement(page, nom_fichier, id_playlist) {
    page = page.substring(0, page.length - 3)
    playlist = page.split(',;,');
    shuffle_et_envoie(page, nom_fichier, id_playlist);
}

function suivant() {
    dernier_temps_enregistre = 0;
    if (hasard == 0) playlist_a_utiliser = playlist;
    else playlist_a_utiliser = playlist_aleatoire;
    id_actuel = playlist_a_utiliser.indexOf(fichier_en_cours);
    if (encore == 2) jouer(id_actuel);
    else if (playlist_a_utiliser[id_actuel + 1] != undefined) jouer(id_actuel + 1);
    else if (encore == 1) jouer(0);
    else player_raz();
}

function precedent() {
    if (hasard == 0) playlist_a_utiliser = playlist;
    else playlist_a_utiliser = playlist_aleatoire;
    id_actuel = playlist_a_utiliser.indexOf(fichier_en_cours);
    if (encore == 2) jouer(id_actuel);
    else if (id_actuel > 0) jouer(id_actuel - 1);
    else if (encore == 1) jouer(playlist_a_utiliser.length - 1);
    else player_raz();
}

function jouer(id) {
    if (hasard == 0) fichier_en_cours = playlist[id];
    else fichier_en_cours = playlist_aleatoire[id];
    jouer_son(fichier_en_cours);
}

function player_raz() {
    fichier_en_cours = null;
    $('#slider').slider('option', 'disabled', true);
    $('#infos_lecture').html('En attente de l\'utilisateur...');
    animation_marquee();
    $('#actuel').html('--:--');
    $('#total').html('--:--');
}

function fichier_vers_id(nom_fichier) {
    if (hasard == 0) return playlist.indexOf('data/[PHP_ADD_USERNAME]/songs/' + nom_fichier);
    else return playlist_aleatoire.indexOf('data/[PHP_ADD_USERNAME]/songs/' + nom_fichier);
}

function changer_infos_son(url) {
    $.ajax({
        url: 'core/interact.php?token=[PHP_ADD_TOKEN]&action=infosson&url=' + url,
        cache: true,
        success: function(page) {
            $('#infos_lecture').html('Lecture de ' + page);
            animation_marquee();
        },
        error: function() {
            afficher_message('impossible de charger les informations sur la chanson.', 10, 0);
        }
    });
}