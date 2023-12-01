<?php
/**
 * The template for displaying the footer.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

	</div>
</div>

<?php
/**
 * generate_before_footer hook.
 *
 * @since 0.1
 */
do_action( 'generate_before_footer' );
?>

<div <?php generate_do_element_classes( 'footer' ); ?>>
	<?php
	/**
	 * generate_before_footer_content hook.
	 *
	 * @since 0.1
	 */
	do_action( 'generate_before_footer_content' );

	/**
	 * generate_footer hook.
	 *
	 * @since 1.3.42
	 *
	 * @hooked generate_construct_footer_widgets - 5
	 * @hooked generate_construct_footer - 10
	 */
	do_action( 'generate_footer' );

	/**
	 * generate_after_footer_content hook.
	 *
	 * @since 0.1
	 */
	do_action( 'generate_after_footer_content' );
	?>
</div>

<?php
/**
 * generate_after_footer hook.
 *
 * @since 2.1
 */
do_action( 'generate_after_footer' );

wp_footer();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />    
<script> 
const accordionItems = document.querySelectorAll('.accordion-item-post');

accordionItems.forEach(item => {
  const header = item.querySelector('.accordion-header');
  
  header.addEventListener('click', () => {
    item.classList.toggle('active');
  });
});

</script>
    
<script>
    	var availability = document.querySelector("meta[property='og:availability']").getAttribute("content");
        console.log(availability);
    </script>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<script>
 
 (function () {
    function onTidioChatApiReady() {
        var checkoutSteps = [
            'https://buymyweedonline.cc/checkout/',
        ];
        var checkoutFinished = [
            'https://buymyweedonline.cc/checkout/order-received/',
        ];
        function executeTidioChatApiTrack() {
            tidioChatApi.track('Abandoned Cart');
        }

        function checkUrl(e) {
            var t = 'tidioStartUrlVisited',
                i = getCookie(t),
                o = e.replace(/\/$/, '');
            if (-1 < checkoutSteps.indexOf(e) || -1 < checkoutSteps.indexOf(o))
                return setCookie(t, '1', '10'), !0;
            i &&
                1 == +i &&
                -1 === checkoutFinished.indexOf(e) &&
                -1 === checkoutFinished.indexOf(o) &&
                executeTidioChatApiTrack(),
                setCookie(t, '', -1);
        }

        function setCookie(e, t, i) {
            var o = new Date();
            o.setTime(o.getTime() + 24 * i * 60 * 60 * 1e3);
            var n = 'expires=' + o.toUTCString();
            document.cookie = e + '=' + t + ';' + n + ';path=/';
        }

        function getCookie(e) {
            for (
                var t = e + '=', i = decodeURIComponent(document.cookie).split(';'), o = 0;
                o < i.length;
                o += 1
            ) {
                for (var n = i[o]; ' ' == n.charAt(0); ) n = n.substring(1);
                if (0 == n.indexOf(t)) return n.substring(t.length, n.length);
            }
            return '';
        }
        var i, o;
        checkUrl(document.location.href),
            (i = window.history),
            (o = i.pushState),
            (i.pushState = function (e) {
                'function' == typeof i.onpushstate &&
                    i.onpushstate({
                        state: e,
                    });
                var t = o.apply(i, arguments);
                return checkUrl(document.location.href), t;
            });
    }
    if (window.tidioChatApi) {
        window.tidioChatApi.on('ready', onTidioChatApiReady);
    } else {
        document.addEventListener('tidioChat-ready', onTidioChatApiReady);
    }
})(); 
        
</script>
</body>
</html>