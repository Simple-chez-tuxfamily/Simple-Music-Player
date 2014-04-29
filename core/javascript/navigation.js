/*
 * Navigation ajax
 */
$(function() {
  $(document).on('click', '.ajax', function() {
    $.ajax({
      url: $(this).attr('href') + '&no_header',
      cache: true,
      success: function(page) {
        $('#content').toggle('drop', 'left', function() {
          $('#content').empty();
          $('#content').append(page);
          window.scrollTo(0, 0);
          $('#content').fadeIn(1000);
        });
      },
      error: function() {
        afficher_message('impossible de charger cette page.', 10, 0);
      }
    });
    return false;
  });
});