new Vue({
    el: '#form-validation',
    data: {},
    methods: {
        validateFormElements: function (event) {
            let element = event.target;
            if(element.tagName === 'FORM')
            {
                if(!isFormValidation(element))
                    event.preventDefault();
            }
        },
        validateFormElement: function (event) {
            let element = event.target;
            let elementDataSet = element.dataset;
            if(element.tagName !== 'FORM' && elementDataSet.validate === 'true')
            {
                validation(element) ?
                    setValidIndicator(element) :
                    setInvalidIndicator(element);
            }
        }
    }
});

(function() {
    'use strict';

    /*----------------------------------------
        Detect Mobile
    ----------------------------------------*/
    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    // for megamenu purpose
    $(document).on('click', '.probootstrap-megamenu .dropdown-menu', function(e) {
        e.stopPropagation()
    });

    /*----------------------------------------
        Menu Hover
    ----------------------------------------*/
    var menuHover = function() {
        if (!isMobile.any()) {
            $('.probootstrap-navbar .navbar-nav li.dropdown').hover(function() {
                $(this).find('> .dropdown-menu').stop(true, true).delay(200).fadeIn(500).addClass('animated-fast fadeInUp');
            }, function() {
                $(this).find('> .dropdown-menu').stop(true, true).fadeOut(200).removeClass('animated-fast fadeInUp')
            });
        }
    }
    /*----------------------------------------
        Feature Showcase
    ----------------------------------------*/
    var showcase = function() {

        $('.probootstrap-showcase-nav ul li a').on('click', function(e){

            var $this = $(this),
                index = $this.closest('li').index();

            $this.closest('.probootstrap-feature-showcase').find('.probootstrap-showcase-nav ul li').removeClass('active');
            $this.closest('li').addClass('active');

            $this.closest('.probootstrap-feature-showcase').find('.probootstrap-images-list li').removeClass('active');
            $this.closest('.probootstrap-feature-showcase').find('.probootstrap-images-list li').eq(index).addClass('active');

            e.preventDefault();

        });

    };

    var contentWayPoint = function() {
        var i = 0;
        $('.probootstrap-animate').waypoint( function( direction ) {

            if( direction === 'down' && !$(this.element).hasClass('probootstrap-animated') ) {

                i++;

                $(this.element).addClass('item-animate');
                setTimeout(function(){

                    $('body .probootstrap-animate.item-animate').each(function(k){
                        var el = $(this);
                        setTimeout( function () {
                            var effect = el.data('animate-effect');
                            if ( effect === 'fadeIn') {
                                el.addClass('fadeIn probootstrap-animated');
                            } else if ( effect === 'fadeInLeft') {
                                el.addClass('fadeInLeft probootstrap-animated');
                            } else if ( effect === 'fadeInRight') {
                                el.addClass('fadeInRight probootstrap-animated');
                            } else {
                                el.addClass('fadeInUp probootstrap-animated');
                            }
                            el.removeClass('item-animate');
                        },  k * 30, 'easeInOutExpo' );
                    });

                }, 100);

            }

        } , { offset: '85%' } );
    };
    jQuery(function($){
        menuHover();
        showcase();
        contentWayPoint();
    });
})();