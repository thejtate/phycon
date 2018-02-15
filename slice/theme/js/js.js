(function ($) {

  if (typeof Drupal != 'undefined') {
    Drupal.behaviors.phyCon = {
      attach: function (context, settings) {
        init();
      },

      completedCallback: function () {
        // Do nothing. But it's here in case other modules/themes want to override it.
      }
    }
  }

  $(function () {
    if (typeof Drupal == 'undefined') {
      init();
    }
  });

  $(window).load(function () {
    initElmsAnimation();
  });

  function init() {
    initScrollR();
    initFlexslider();
    initTabs();
    initShowModal();
    initReadMore();
    initMobileNav();
    initNewsOpen();
    initElementsAnimation();
  }

  function initScrollR() {

    if(document.documentElement.classList.contains('tablet') || document.documentElement.classList.contains('mobile')) {
      return;
    }

    var s = skrollr.init({
      render: function (data) {

      },
      forceHeight: false,
      smoothScrolling: false
    });
  }

  function initElementsAnimation() {
    var $elms = $('.el-with-animation');
    var animationEnd = [];

    $(window).on('resize scroll', checkScroll);

    checkScroll();

    function checkScroll() {
      if (animationEnd.length === $elms.length) return;

      for (var i = 0; i < $elms.length; i++) {
        var $currentEl = $elms.eq(i);

        if (!$currentEl.hasClass('animating-end') && $(window).height() + $(window).scrollTop() > $currentEl.offset().top + $currentEl.height() / 2 + 50) {
          animate($currentEl);
        }
      }
    }

    function animate(el) {
      el.addClass('animating-end');
      animationEnd.push(1);
    }
  }

  function initNewsOpen() {
    var $wrapper = $('.style-items'),
      $items = $wrapper.find('.item'),
      $btn = $items.find('.btn-text'),
      $close = $items.find('.close');

    if($.browser.msie) {
      $('body').addClass('msie')
    }

    for (var i = 0; i < $items.length; i++) {

      if ($items.eq(i).find('img').length == 0) {
        $items.eq(i).addClass('without-img');
      }
    }

    $btn.on('click touch', function (e) {
      e.preventDefault();

      var $item = $(this).closest('.item'),
        $text = $item.find('.text');

      $items.removeClass('active');

      setTimeout(function () {
        $items.removeClass('item-open');
        $item.addClass('item-open');
        $item.addClass('item-open');
        $item.addClass('active');
      }, 200);



      $('.outer-wrapper').addClass('active')
    });

    $close.on('click touch', function (e) {
      e.preventDefault();
      $items.removeClass('active');

      setTimeout(function () {
        $items.removeClass('item-open');
      }, 500);

      $('.outer-wrapper').removeClass('active')
    })
  }

  function initMobileNav() {
    var btn = document.querySelector('.btn-nav');

    if (!btn) return;

    btn.addEventListener('click', function (e) {
      e.preventDefault();

      document.body.classList.toggle('mobile-nav');
    });

    var expandedList = document.querySelectorAll('.nav li.expanded > a');

    if (!expandedList.length) return;

    for (var i = 0; i < expandedList.length; i++) {

      expandedList[i].addEventListener('click', function (e) {

        if ($('.tablet').length || ('.mobile').length) {
          e.preventDefault();

          this.parentNode.classList.toggle('active-lvl');
        }
      });
    }
  }

  function initReadMore() {
    var wrapper = document.querySelector('.section-items');

    if (!wrapper) return;

    var items = wrapper.querySelectorAll('.item');

    for (var y = 0; y < items.length; y++) {

      items[y].addEventListener('click', function (e) {
        var target = e.target;

        if (this.querySelector('.hidden-field') && checkClass(target, 'btn')) {
          e.preventDefault();

          readMoreHandler(this);
        }
      });
    }

    function checkClass(el, elClass) {
      if (el.classList.contains(elClass) || el.parentNode.classList.contains(elClass)) {
        return true;
      }
    }

    function readMoreHandler(self) {
      var btn = self.querySelector('.btn');
      var hiddenField = self.querySelector('.hidden-field');

      btn.classList.toggle('active');
      hiddenField.classList.toggle('visible-field');

      if (btn.classList.contains('active')) {
        btn.innerText = 'Read less';
      } else {
        btn.innerText = 'Read more';
      }
    }
  }

  function initFlexslider() {
    var $flexsliderBg = $('.flexslider.bg');
    var $flexsliderContent = $('.flexslider.content-slides');

    $flexsliderBg.flexslider({
      animation: "slide",
      slideshow: false,
      touch: false
    });

    $flexsliderContent.flexslider({
      animation: "fade",
      slideshow: false,
      touch: false
    });

    var $btnflexsliderBg = $flexsliderBg.find('.flex-direction-nav .flex-next');
    var $btnflexsliderContent = $flexsliderContent.find('.flex-direction-nav .flex-next');

    var interval;
    setIntv();

    $btnflexsliderContent.on('click touchstart', function () {
      $btnflexsliderBg.trigger('click');
      clearInterval(interval);
      setIntv();
    });

    function setIntv() {
      interval = setInterval(function () {
        $btnflexsliderContent.trigger('click');
      }, 7000);
    }
  }

  function initTabs() {
    var wrapper = document.querySelector('.section-tabs');

    if (!wrapper || wrapper.classList.contains('wrapper-processed')) return;

    wrapper.classList.add('wrapper-processed');

    var nav = wrapper.querySelectorAll('.tabs-nav li');
    var content = wrapper.querySelectorAll('.tabs-content .tab-item');

    setActive(0);

    for (var i = 0; i < nav.length; i++) {
      nav[i].querySelector('a').addEventListener('click', function (e) {
        e.preventDefault();
        setActive(this.parentNode);
      });
    }

    function setActive(el) {
      if (el !== undefined && typeof el == 'number') {
        nav[el].classList.add('active');
        content[el].classList.add('active');
        return;
      }

      for (var i = 0; i < nav.length; i++) {
        if (nav[i] == el) {
          nav[i].classList.add('active');
          content[i].classList.add('active');
        } else {
          nav[i].classList.remove('active');
          content[i].classList.remove('active');
        }
      }
    }
  }

  function initShowModal() {
    if (window.location.hash) {
      showModal();
    }

    window.addEventListener('hashchange', function () {
      showModal();
    });

    $('.modal').on('hide.bs.modal', function (e) {
      window.location.hash = '#';
    });

    function showModal() {
      var $hash = $(window.location.hash);

      if ($hash) $hash.modal('toggle');
    }
  }

  function initElmsAnimation() {
    window.sr = new ScrollReveal({
      duration: 1000,
      scale: 1,
      easing: 'ease',
      origin: 'top',
      mobile: false
    });

    //section info
    sr.reveal('.section-info .item', {
      distance: '-20px',
      origin: 'top',
      opacity: 0,
      viewFactor: .9
    });

    sr.reveal('.section-info .btns-wrapper', {
      distance: 0,
      opacity: 0,
      viewFactor: .9
    });

    sr.reveal('.section-info div.img-desktop img', {
      distance: 0,
      opacity: 0
    });

    sr.reveal('.section-info div.img-laptope img', {
      distance: 0,
      opacity: 0,
      delay: 400
    });

    sr.reveal('.section-info div.img-phone img', {
      distance: 0,
      opacity: 0,
      delay: 800
    });

    //section PM
    sr.reveal('.section-pm .sidebar h2', {
      distance: '-20px',
      origin: 'right',
      opacity: 0,
      viewFactor: .9
    });

    sr.reveal('.section-pm .sidebar h3', {
      distance: '-20px',
      origin: 'right',
      opacity: 0,
      viewFactor: .9
    });

    sr.reveal('.section-pm .sidebar .text', {
      distance: '-20px',
      origin: 'right',
      opacity: 0,
      viewFactor: .9
    });

    sr.reveal('.section-pm .sidebar .btn', {
      distance: '-20px',
      origin: 'right',
      opacity: 0,
      viewFactor: .9
    });

    sr.reveal('.section-pm .title', {
      distance: '-20px',
      origin: 'left',
      opacity: 0,
      viewFactor: .9
    });

    //section items
    sr.reveal('.section-items .item:nth-child(1)', {
      distance: '-20px',
      origin: 'bottom',
      opacity: 0,
      viewFactor: .5
    });

    sr.reveal('.section-items .item:nth-child(2)', {
      distance: '-20px',
      origin: 'bottom',
      opacity: 0,
      viewFactor: .5,
      delay: 200
    });

    //sidebar
    sr.reveal('.sidebar div.img-desktop img', {
      distance: 0,
      opacity: 0,
      viewFactor: .9
    });
  }

})(jQuery);