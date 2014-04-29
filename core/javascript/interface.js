$(function() {
  setInterval(redimensionnement_automatique(), 2000);
  $('#suppression').click(function() {
    click_neutralise = true;
    $('#suppression').hide();
    $('#suppression2').show();
    $('.supprzone').show();
  });
  $('#suppression2').click(function() {
    if (confirm('Êtes-vous sûr(e) de vouloir supprimer les morceaux sélectionnés?')) {
      var sons_a_supprimer = '';
      $('input:checked').each(function() {
        sons_a_supprimer = sons_a_supprimer + $(this).attr('name').replace('i', '') + ',';
      });
      window.location.href = 'core/interact.php?token=[PHP_ADD_TOKEN]&action=supprimer&ids=' + sons_a_supprimer;
    } else {
      click_neutralise = false;
      $('#suppression').show();
      $('#suppression2').hide();
      $('.supprzone').hide();
    }
  });
  $('#slider').slider({
    range: 'min',
    value: 0,
    min: 0,
    max: 240,
    disabled: true,
    start: function(e, ui) {
      sliding_manuel = true;
    },
    stop: function(e, ui) {
      dernier_temps_enregistre = 0;
      $('#jplayer').jPlayer('play', ui.value);
      sliding_manuel = false;
    }
  });
});

function redimensionnement_automatique() {
  $('#player').css('top', parseInt($('nav').css('height').replace('px', '')) + 70 + 'px');
}

function animation_marquee() {
  $('#infos_lecture').marquee({
    duration: 10000,
    gap: 300,
    direction: 'left',
    duplicated: true,
    pauseOnHover: true
  });
}