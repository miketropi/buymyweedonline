jQuery(window).scroll(function(){
    if (jQuery(this).scrollTop() > 50 && jQuery(window).width() > 980) {
       //jQuery('#masthead').addClass('fixedHeaderOnScroll');
	   jQuery('#site-navigation').addClass('fixedHeaderOnScroll');
    } else {
       //jQuery('#masthead').removeClass('fixedHeaderOnScroll');
	   jQuery('#site-navigation').removeClass('fixedHeaderOnScroll');
    }
});

function openStrain(evt, strainName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(strainName).style.display = "block";
  evt.currentTarget.className += " active";
}

// jQuery( document.body ).on( 'updated_wc_div', do_magic );
// jQuery( document.body ).on( 'updated_cart_totals', do_magic );

// function do_magic() {
//      location.reload( true );
//     console.log("Hello world!");
   
// }

   $(document).ready(function() {
      function myFunction() {
        var dots1 = $("#dots1");
        var moreText1 = $("#more1");
        var btnText1 = $("#myBtn1");

        if (dots1.css("display") === "none") {
          dots1.css("display", "inline");
          btnText1.html("Read more");
          moreText1.css("display", "none");
        } else {
          dots1.css("display", "none");
          btnText1.html("Read less");
          moreText1.css("display", "inline");
        }
      }

      $("#myBtn1").click(myFunction);
    });

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}


 jQuery( document ).ready( function( $ ) {
        $( '#menu-mobile-main-menu #menu-item-3981554 .sub-menu' ).addClass( 'toggled-on' );
        $( '#menu-mobile-main-menu #menu-item-3981554.menu-item-has-children' ).addClass( 'sfHover' );
     	$( '#menu-mobile-main-menu #menu-item-3981560 .sub-menu' ).addClass( 'toggled-on' );
        $( '#menu-mobile-main-menu #menu-item-3981560.menu-item-has-children' ).addClass( 'sfHover' );
     	$( '#menu-mobile-main-menu #menu-item-3981565 .sub-menu' ).addClass( 'toggled-on' );
        $( '#menu-mobile-main-menu #menu-item-3981565.menu-item-has-children' ).addClass( 'sfHover' );
    } );
   


const accordionItems = document.querySelectorAll('.accordion-item-post');

accordionItems.forEach(item => {
  const header = item.querySelector('.accordion-header');
  
  header.addEventListener('click', () => {
    item.classList.toggle('active');
  });
});




$(function() {
  $('.chart-thc').easyPieChart({
    size: 100,
    barColor: "#E66D57",
    scaleLength: 0,
    lineWidth: 5,
    trackColor: "#F2B5AA",
    lineCap: "circle",
    animate: 2000,
  });
});
$(function() {
  $('.chart-cbd').easyPieChart({
    size: 100,
    barColor: "#1FABBE",
    scaleLength: 0,
    lineWidth: 5,
    trackColor: "#9AD8E1",
    lineCap: "circle",
    animate: 2000,
  });
}); 






/*function myFlashFunction() {
 var copyText = document.getElementById("myflashInput");
 copyText.select();
 document.execCommand("copy");
 
 var tooltip = document.getElementById("myTooltip");
 tooltip.innerHTML = "Copied: " + copyText.value;
}

function outFunc() {
 var tooltip = document.getElementById("myTooltip");
 tooltip.innerHTML = "Copy to clipboard";
}*/

/*jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop()>0 && jQuery(window).width() > 980)
     {
        jQuery('#masthead').css("margin-top", "0px");
        jQuery('#main-header').css("margin-top", "0px");
     }
    else if (jQuery(window).width() > 980)
     {
       jQuery('#top-header').css("margin-top", "94px");
       jQuery('#main-header').css("margin-top", "93px");
     }
 }); */