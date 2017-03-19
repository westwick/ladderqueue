
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('schedule', require('./components/Schedule.vue'));

const app = new Vue({
    el: '#app'
});

$(function() {

    $(document).foundation();

    $('.nav-toggle').click(function(e) {
        e.preventDefault();
        // get child subnav
        var subnav = $(this).siblings('.subnav');
        // hide any other subnavs
        $('.subnav').not(subnav).hide();
        //toggle the selected subnav
        subnav.toggle();
        e.stopPropagation();
    });

    $('html').click(function() {
        $('.subnav').hide();
    });

    // stop propagations!
    $('.subnav').click(function(e){
        e.stopPropagation();
    });
});
