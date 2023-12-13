(function ($) {
 "use strict";

/*--------------------------
preloader
---------------------------- */	
	$(window).on('load',function(){
		var pre_loader = $('#preloader')
	pre_loader.fadeOut('slow',function(){$(this).remove();});
	});	

/*---------------------
 TOP Menu Stick
--------------------- */
var windows = $(window);
var sticky = $('#sticker');

windows.on('scroll', function() {
    var scroll = windows.scrollTop();
    if (scroll < 300) {
        sticky.removeClass('stick');
    }else{
        sticky.addClass('stick');
    }
});
/*----------------------------
 jQuery MeanMenu
------------------------------ */
    var mean_menu = $('nav#dropdown');
    mean_menu.meanmenu();
/*--------------------------
 scrollUp
---------------------------- */
	$.scrollUp({
		scrollText: '<i class="fa fa-angle-up"></i>',
		easingType: 'linear',
		scrollSpeed: 900,
		animation: 'fade'
	});
    
/*--------------------------
 collapse
---------------------------- */
	var panel_test = $('.panel-heading a');
	panel_test.on('click', function(){
		panel_test.removeClass('active');
		$(this).addClass('active');
	});
/*--------------------------
 Parallax
---------------------------- */	
    var parallaxeffect = $(window);
    parallaxeffect.stellar({
        responsive: true,
        positionProperty: 'position',
        horizontalScrolling: false
    });

/*--------------------------
     slider carousel
---------------------------- */
    var intro_carousel = $('.intro-carousel');
    intro_carousel.owlCarousel({
        loop:true,
        nav:true,		
        autoplay:true,
        dots:false,
        smartSpeed: 1000,
        // autoHeight: true,
        // autoWidth:true,
        navText: ["<i class='icon icon-chevron-left'></i>","<i class='icon icon-chevron-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            },
            1500:{
                items:1
            }
        }
    });
 
/*----------------------------
 isotope active
------------------------------ */
	// project start
    $(window).on("load",function() {
        var $container = $('.project-content');
        $container.isotope({
            filter: '*',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });
        $('.project-menu li a').on("click", function() {
            $('.project-menu li a.active').removeClass('active');
            $(this).addClass('active');
            var selector = $(this).attr('data-filter');
            $container.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
            return false;
        });

    });
    //portfolio end
   
// 6ème sens
var veno_box = $('.venobox');
veno_box.venobox();
var lg = $('#lang').val();
console.log(lg);
if(lg === "fr"){
    var noselec = "Qu'avez-vous de précieux?";
    var selec = "sélectionnés";
}
else{
    var noselec = 'What is precious to you?';
    var selec = "selected";
}
$('#profil').hide();
$('#MonProfil').click( function(){
  $('#profil').show();
  $('#profil1').hide();
  $('.formulaire').css({
    'padding-top': '50px'
  });
})

// $(document).ready(function() {
//   $('select').niceSelect();
// });

$(document).ready(function() {
    $('select:not(.ignore)').niceSelect();
    // FastClick.attach(document.body);
    $('.ignore').multiselect({
        nonSelectedText: noselec,
        nSelectedText: selec,
        onChange: function(element, checked) {
            var selected = this.$select.val();
            console.log(element.val());
            if(element.val() == 1) {
                // $('.ignore').find('[value="2"]').hide();
                $(".ignore").multiselect('deselect', 2);
            }
            if(element.val() == 2) {
                // $('.ignore').find('[value="2"]').hide();
                $(".ignore").multiselect('deselect', 1);
            }
        }
    });
    // $('.formMd').multiselect().remove();
});

$('#sendResult').click( function(){
    var id_client = $('.id_client').val();
    $.ajax({
        'url' : base_url + 'profil/sendMail/',
        'type' : 'GET', //the way you want to send data to your URL
        'data' : {'id_client' : id_client},
        'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
            if(data){
                alert('envois effectué');
            }
        }
    });
});

// Formulaire responsives
$('#proForm').hide();
$('#proFormAction').click(function(){
    $('#proForm').show();
    $('#nom').focus();
    // window.location.hash = '#proForm';
});

//catégorie professionnelle => assurables
$('#pro').on('change', function() {
   $.ajax({
        'url' : base_url + lang + '/ajax/assurable/',
        'type' : 'POST', //the way you want to send data to your URL
        'data' : {'id' : this.value},
        'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
            var ajaxModif = $('#lassurable'); //jquery selector (get element by id)
            if(data){
                ajaxModif.html(data);
                $('.ignore').multiselect({
                    nonSelectedText: noselec,
                    nSelectedText: selec,
                    onChange: function(element, checked) {
                        var selected = this.$select.val();
                        console.log(element.val());
                        if(element.val() == 1) {
                            // $('.ignore').find('[value="2"]').hide();
                            $(".ignore").multiselect('deselect', 2);
                        }
                        if(element.val() == 2) {
                            // $('.ignore').find('[value="2"]').hide();
                            $(".ignore").multiselect('deselect', 1);
                        }
                    }
                });
            }
        }
    });
});

//catégorie professionnelle => assurables mobile
$('#pro1').on('change', function() {
   $.ajax({
        'url' : base_url + lang + '/ajax/assurable/',
        'type' : 'POST', //the way you want to send data to your URL
        'data' : {'id' : this.value},
        'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
            var ajaxModif = $('#lassurable1'); //jquery selector (get element by id)
            if(data){
                ajaxModif.html(data);
                $('.ignore').multiselect({
                    nonSelectedText: noselec,
                    nSelectedText: selec,
                    onChange: function(element, checked) {
                        var selected = this.$select.val();
                        console.log(element.val());
                        if(element.val() == 1) {
                            // $('.ignore').find('[value="2"]').hide();
                            $(".ignore").multiselect('deselect', 2);
                        }
                        if(element.val() == 2) {
                            // $('.ignore').find('[value="2"]').hide();
                            $(".ignore").multiselect('deselect', 1);
                        }
                    }
                });
            }
        }
    });
});

/*--------------------------
     slider carousel
---------------------------- */
    var actu_caroussel = $('#actu_caroussel');
    actu_caroussel.owlCarousel({
        loop:true,
        nav:false,       
        autoplay:true,
        dots:false,
        smartSpeed: 500,
        navText: ["<i class='icon icon-chevron-left'></i>","<i class='icon icon-chevron-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
    var actu_caroussel2 = $('#actu_caroussel2');
    actu_caroussel2.owlCarousel({
        loop:true,
        nav:true,       
        autoplay:true,
        dots:false,
        smartSpeed: 500,
        navText: ["<i class='icon icon-chevron-left'></i>","<i class='icon icon-chevron-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });

})(jQuery);