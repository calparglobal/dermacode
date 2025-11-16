<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
jQuery(function($) {
  var header1 = $('.header-1');
  var header2 = $('.header-2');
  var lastScrollTop = 0;

  $(window).scroll(function() {
    var scrollTop = $(this).scrollTop();

    if (scrollTop > lastScrollTop && scrollTop > 400) {
      header1.removeClass('visible');
      header2.addClass('visible');
    } else if (scrollTop < lastScrollTop && scrollTop > 400) {
      header1.addClass('visible');
      header2.removeClass('visible');
    } else if (scrollTop <= 400) {
      header1.addClass('visible');
      header2.removeClass('visible');
    }
    lastScrollTop = scrollTop;
  });
});
</script>
<!-- end Simple Custom CSS and JS -->
