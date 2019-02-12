var tablet_width = 950;
var is_mobile = (/iPhone|iPod|iPad|Android|BlackBerry/).test(navigator.userAgent);
var scroll = false;

var $container = false;
if (outspoken.masonry == '1') $container = jQuery('#masonry-container');

function fullHeight(el) {
	return el.height() + parseInt(el.css('padding-top')) + parseInt(el.css('padding-bottom'))
		+ parseInt(el.css('border-top-width')) + parseInt(el.css('border-bottom-width'));
}

function fixLinks(items) {
	items.each(function() {
		var item = jQuery(this);
		var img = item.find('img');
		if (img.length === 1) {
			item.addClass('image_link');
		}
	});
}

function fixProtectedPosts() {
	jQuery('.post-password-required input[type="password"]').attr('placeholder', 'Type & Hit Enter');
}

function initGalleries(items) {
	var data = false;
	items.find('.outspoken_js').each(function() {
		data = jQuery.parseJSON(jQuery(this).text());
		if (data.type == 'gallery') {
			var options = {};
			if (data.bullets != undefined) {
				options.bullets = true;
				options.bullets_selector = '#full_width_bullets > div';
			}
			jQuery(data.selector).wpShowerSlider(options);
		}
	});
}

(function($) {
	$('.entry-video').wpShowerResponsiveVideos();

	/**
	 * Search
	 */
	$('#search-toggle .icon').click(function() {
		var search_form = $('.site-header .searchform');
		var pointer = $('#search-toggle .pointer');
		if (parseInt(search_form.css('max-height')) == 0) {
			search_form.css('max-height', '80px').css('overflow', 'visible');
			pointer.css('top', '-20px');
			search_form.find('input[type="text"]').focus();
		}
		else {
			search_form.css('max-height', '0').css('overflow', 'hidden');
			pointer.css('top', '-30px');
		}
	});

	/**
	 * Enables menu toggle for small screens.
	 */
	function enableMenu(nav, button) {
		var menu = nav.find('.nav-menu');

		// Hide button if menu is missing or empty.
		if (!menu || !menu.children().length) {
			button.hide();
			return;
		}

		button.on('click', function() {
			nav.toggleClass('toggled-on');
			button.toggleClass('toggled-on');
		});
	}
	enableMenu($('#site-navigation'), $('#navbar .menu-toggle'));
	enableMenu($('#section-navigation'), $('#section-toggle'));

	/**
	 * Responsive sections menu
	 */
	var section = {
		el: $('#section-navigation'),
		height: 55,
		font: 24,
		font_min: 16,
		init: function() {
			this.process();
			$(window).on('resize', section.process);
		},
		process: function() {
			section.font = 24;
			section.el.find('> div > ul > li > a').css('font-size', section.font + 'px');
			while (section.el.height() != section.height
				&& section.font >= section.font_min
				&& window.innerWidth > tablet_width
			) {
				section.font--;
				section.el.find('a').css('font-size', section.font + 'px');
			}
		}
	};
	section.init();

	/**
	 * Post navigation links
	 */
	var post_navigation = {
		margin: -29,
		arrow_margin: 2,
		init: function() {
			$('.post-navigation .nav-previous a, .post-navigation .nav-next a')
				.on('mouseenter', this.enter)
				.on('mouseleave', this.leave);
		},
		enter: function() {
			var margin = Math.floor(-1 * $(this).parent().height() / 2);
			$(this).parent().css('margin-top', margin);
			$(this).find('.arrow').css('margin-top', post_navigation.arrow_margin + post_navigation.margin - margin);
		},
		leave: function() {
			$(this).parent().css('margin-top', post_navigation.margin);
			$(this).find('.arrow').css('margin-top', post_navigation.arrow_margin);
		}
	};
	post_navigation.init();

	$(function() {
		// Masonry
		if ($container != false) {
			$container.imagesLoaded(function() {
				$container.masonry({
					columnWidth: '.masonry-sizer',
					itemSelector: '.masonry-sizer',
					gutter: '.masonry-gutter',
					transitionDuration: 0
				});
				if (scroll != false) scroll.loadMore();
			});
		}

		// Load More
		if ('load-more' == outspoken.navigation) {
			$('.load-more').on('click', 'a', function(e) {
				e.preventDefault();
				var link = $(this);
				link.parent().addClass('active');
				$.ajax({
					type: 'GET',
					url: link.attr('href') + '#content',
					dataType: 'html',
					success: function(out) {
						nextLink = $(out).find('.load-more a').attr('href');
						var nav = $('#load-more-button');
						var items = false;
						if ($container != false) {
							items = $(out).find('#content .masonry-sizer');
							items.addClass('not-loaded');
							$container.append(items);
							items.find('.entry-video').wpShowerResponsiveVideos();
							items.find('audio,video').mediaelementplayer();
							initGalleries(items);
							$container.imagesLoaded(function() {
								items.removeClass('not-loaded');
								$container.masonry('appended', items).masonry();
								if (scroll != false) scroll.loadMore();
							});
						}
						else {
							items = $(out).find('#content .hentry');
							items.each(function() {
								$(this).insertBefore(nav);
								$(this).find('.entry-video').wpShowerResponsiveVideos();
							});
							items.find('audio,video').mediaelementplayer();
							initGalleries(items);
						}
						fixLinks(items.find('a'));
						if (undefined != nextLink) {
							link.attr('href', nextLink).parent().removeClass('active');
						} else {
							nav.remove();
						}

						if (scroll != false) scroll.loadMore();
					}
				});
			});
		}

		initGalleries($('#main'));
		fixLinks($('.entry-content a, .entry-summary a'));
		fixProtectedPosts();

		/**
		 * Share submenus for mobile devices
		 */
		$('.share-content').on('touchstart', function() {
			var item = $(this).parent();
			if (item.hasClass('hover')) item.removeClass('hover');
			else item.addClass('hover');
		});

		/**
		 * Footer always at the bottom
		 */
		var container = $('#page');
		var footer = $('#colophon');
		container.css('padding-bottom', fullHeight(footer));
		footer.css({
			position: 'absolute',
			bottom: 0,
			width: container.width() + 'px'
		});
		$(window).resize(function() {
			container.css('padding-bottom', fullHeight(footer));
			footer.css('width', container.width() + 'px');
		});

		/**
		 * Floating menu && sidebar zone
		 */
		var menu = {
			el: $('#section-navigation'),
			enabled: false,
			fixed: false,
			height: 0,
			offset: 0,
			float: function() {
				this.fixed = true;
				this.el.css('top', scroll.fixed_top).addClass('floating');
				scroll.updateHeight();
				zone.fixes();
			},
			unfloat: function() {
				this.fixed = false;
				this.el.removeClass('floating');
				scroll.updateHeight();
				zone.fixes();
			},
			zoneFix: function() {
				if (this.enabled && this.fixed) return this.height;
				return 0;
			}
		};
		var zone = {
			el: $('#sidebar-floating'),
			enabled: false,
			fixed: false,
			height: 0,
			offset: 0,
			footer: $('#colophon'),
			footer_widgets: $('#footer-widgets'),
			footer_height: 0,
			footer_offset: 0,
			fixes: function() {
				if (this.enabled) {
					if (this.fixed === false) {
						this.offset = this.el.offset().top - scroll.fixed_top - menu.zoneFix();
					}
					this.footer_height = fullHeight(this.footer) + fullHeight(this.footer_widgets);
					this.footer_offset = scroll.page_height - this.footer_height - this.height - menu.zoneFix();
					if (this.fixed == 'absolute') {
						this.el.css('top', this.footer_offset + menu.zoneFix());
					}
				}
			},
			float: function() {
				var absolute = scroll.top > this.footer_offset ? true : false;
				if (this.fixed === false || (this.fixed === 'absolute' && !absolute)) {
					this.fixed = 'floating';
					this.el.css('top', scroll.fixed_top + menu.zoneFix()).addClass('floating').removeClass('absolute');
					this.height = fullHeight(this.el);
					this.fixes();
					absolute = scroll.top > this.footer_offset ? true : false;
				}
				if (this.fixed == 'floating' && absolute) {
					this.fixed = 'absolute';
					this.el.css('top', this.footer_offset + menu.zoneFix()).addClass('absolute');
					this.height = fullHeight(this.el);
				}
			},
			unfloat: function() {
				this.fixed = false;
				this.el.removeClass('floating').removeClass('absolute');
				this.height = fullHeight(this.el);
				scroll.updateHeight();
				this.fixes();
			}
		};
		var share = {
			el: $('.share-side'),
			el_helper: $('.share-side-helper'),
			enabled: false,
			fixed: false,
			top: 0,
			left: 0,
			offset: 0,
			fixes: function() {
				if (this.fixed) {
					this.el.css('left', this.el_helper.offset().left);
				}
			},
			float: function() {
				this.fixed = true;
				this.el.css('top', scroll.fixed_top).css('left', this.el_helper.offset().left).addClass('floating');
			},
			unfloat: function() {
				this.fixed = false;
				this.el.css('top', this.top).css('left', this.left).removeClass('floating');
			}
		};
		if (!is_mobile && outspoken.floating_menu == '1') {
			menu.enabled = true;
			menu.height = fullHeight(menu.el);
			menu.offset = menu.el.offset().top;
		}
		if (!is_mobile && zone.el.children().length > 0 && $('#primary').height() > $('#tertiary').height()) {
			zone.enabled = true;
			zone.height = fullHeight(zone.el);
			zone.offset = zone.el.offset().top;
		}
		if (!is_mobile && share.el.length == 1) {
			share.enabled = true;
			share.top = parseInt(share.el.css('top'));
			share.left = parseInt(share.el.css('left'));
			share.offset = share.el.offset().top;
		}
		if (menu.enabled || zone.enabled || share.enabled) {
			scroll = {
				enabled: false,
				window: $(window),
				window_width: 0,
				page: $('#page'),
				page_height: 0,
				top: 0,
				fixed_top: 0,
				updateWidth: function() {
					this.window_width = window.innerWidth;
				},
				updateHeight: function() {
					this.page_height = this.page.height();
				},
				init: function() {
					this.updateWidth();
					this.updateHeight();

					if ($('#wpadminbar').length != 0) {
						this.fixed_top = $('#wpadminbar').height();
						if (menu.enabled) menu.offset -= this.fixed_top;
						zone.fixes();
						if (share.enabled) share.offset -= this.fixed_top;
					}

					if (this.window_width > tablet_width) this.enable();

					$(window).on('resize load', scroll.process);
				},
				process: function() {
					scroll.updateWidth();
					scroll.updateHeight();
					zone.fixes();
					share.fixes();
					if (scroll.window_width <= tablet_width) {
						if (scroll.enabled) scroll.disable();
					}
					else if (!scroll.enabled) scroll.enable();
				},
				loadMore: function() {
					this.process();
					this.updateScroll();
				},
				updateScroll: function() {
					scroll.top = $(window).scrollTop();
					if (scroll.page_height != scroll.page.height()) scroll.process();
					if (menu.enabled) {
						if (scroll.top > menu.offset && scroll.window_width > tablet_width) {
							if (!menu.fixed) menu.float();
						}
						else if (menu.fixed) menu.unfloat();
					}
					if (zone.enabled) {
						if (scroll.top > zone.offset && scroll.window_width > tablet_width) {
							zone.float();
						}
						else if (zone.fixed !== false) zone.unfloat();
					}
					if (share.enabled) {
						if (scroll.top > share.offset && scroll.window_width > tablet_width) {
							share.float();
						}
						else if (share.fixed !== false) share.unfloat();
					}
				},
				enable: function() {
					this.enabled = true;
					this.window.on('scroll', scroll.updateScroll);
				},
				disable: function() {
					this.enabled = false;
					if (menu.enabled && menu.fixed) menu.unfloat();
					if (zone.enabled && zone.fixed !== false) zone.unfloat();
					if (share.enabled && share.fixed) share.unfloat();
					this.window.off('scroll');
				}
			};

			scroll.init();
		}
	});

	/**
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
	$(window).on('hashchange.outspoken', function() {
		var element = document.getElementById(location.hash.substring(1));

		if (element) {
			if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName))
				element.tabIndex = -1;

			element.focus();
		}
	});
})(jQuery);
