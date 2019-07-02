requirejs.config({
    baseUrl: 'src/js/',
    paths: {
      jquery: '//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min',
      jquery_ui: '//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min',
      bootstrap: 'bootstrap.min',
      app: '../../public/v1.0/js/master',
      angular: [
        '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min',
        'angular.min'
      ],
      angular_animate: '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min',
      angular_material: '//ajax.googleapis.com/ajax/libs/angular_material/1.1.4/angular-material.min',
      angular_aria: '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min',
      angular_messages: '//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min',
      jquery_cookie: 'jquery.cookie',
      cookie_accepter: 'jquery.cookieaccept',
      fancybox: 'fancybox/jquery.fancybox',
      fancybox_buttons: 'fancybox/helpers/jquery.fancybox-buttons',
      slick: 'slick/slick.min',
      pageOpener: 'pageOpener',
      user: 'user',
      angapp: 'app',
    },
    shim: {
      app: ['jquery', 'jquery_ui', 'fancybox', 'jquery_cookie', 'cookie_accepter', 'slick'],
      fancybox_buttons: ['fancybox'],
      fancybox: ['jquery'],
      angapp: ['angular', 'angular_material', 'angular_animate', 'angular_aria', 'angular_messages'],
      angular_animate: ['angular'],
      angular_aria: ['angular'],
      angular_messages: ['angular'],
      angular_material: ['angular'],
      user: ['jquery'],
      pageOpener: ['jquery']
    }
});


requirejs(['user']);
requirejs(['app']);
requirejs(['pageOpener']);
requirejs(['angapp'], function(){
});

// Start loading the main app file. Put all of
// your application logic in there.
/*
requirejs(['jquery', 'jquery_ui'], function(){
  requirejs(['bootstrap','jquery_cookie', 'cookie_accepter', 'slick']);
  requirejs(['angular'], function(){
    requirejs(['angular_animate', 'angular_aria', 'angular_messages', 'angular_material'], function(){
      requirejs(['fancybox'], function(){
        requirejs(['fancybox_buttons']);
        requirejs(['user']);
        requirejs(['app/master']);
        requirejs(['angapp']);
      });
    });
  });
});
*/
