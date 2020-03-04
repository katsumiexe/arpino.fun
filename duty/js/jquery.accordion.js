/* =============================================================================
	jQuery Accordion ver3.0.0
	Copyright(c) 2015, ShanaBrian
	Dual licensed under the MIT and GPL licenses.
============================================================================= */
(function($) {

	$.fn.accordion = function(options) {
		if ($(this).length > 0) {
			if ($(this).length > 1) {
				$.each(this, function() {
					$(this).accordion(options);
				});
				return this;
			}

			var settings            = {},
				$element            = this,
				$action             = this,
				$items              = null,
				$changeClassElement = null;

			// 初期実行
			var init = function() {
				/*
					actionElement        : アクションを起こす対象の要素 [ jQuery Object | Element Name ]
					openAndCcloseElement : 展開をする要素 [ jQuery Object | Element Name ]
					addClassElement      : 開閉したときのCSSクラス名を適用する要素 [ this | parent | jQuery Object | Element Name ]
					actionEvent          : アクションイベント
					startOpenIndex       : 読み込み時に最初に表示する要素のインデックス番号（-1で無効）
					closedClassName      : 閉じている状態のCSSクラス名
					openedClassName      : 開いている状態のCSSクラス名
					animationMode        : アニメーションモード [ true | false ]
					animetionSpeed       : アニメーションの速度
					animetionEasing      : アニメーションのイージング
					autoClose            : 開いた要素以外の要素を自動的に閉じるかどうか [ true | false ]
					openedCloseMode      : アクションを起こした要素の開閉する要素が開いている場合に閉じるかどうか [ true | false ]
				*/
				settings = $.extend({
					actionElement        : '',
					openAndCcloseElement : '',
					addClassElement      : 'this',
					actionEvent          : 'click',
					startOpenIndex       : -1,
					openedClassName      : 'opened',
					closedClassName      : 'closed',
					animationMode        : true,
					animetionSpeed       : 300,
					animetionEasing      : 'swing',
					autoClose            : true,
					openedCloseMode      : true
				}, options);

				if ($(settings.actionElement).length > 0 && $(settings.openAndCcloseElement).length > 0) {
					setup();
				}

			};

			// セットアップ
			var setup = function() {

				$action = $(settings.actionElement);
				$items  = $(settings.openAndCcloseElement);

				$items.hide();

				if (settings.addClassElement === 'this') {
					$changeClassElement = $items;
				} else if (settings.addClassElement === 'parent') {
					$changeClassElement = $items.parent();
				} else if ($(settings.addClassElement).length > 0) {
					$changeClassElement = $(settings.addClassElement);
				}

				$action.on(settings.actionEvent + '.accordion', function() {
					var index = $action.index(this);
					$element.accChange(index);
					return false;
				});

				var stockAnimationMode = settings.animationMode;

				settings.animationMode = false;

				$.each($action, function() {
					var index = $action.index(this);
					if ($action.eq(index).data('data-accordion-status') === 'opened' || index === settings.startOpenIndex) {
						$element.accOpen(index);
					} else {
						$element.accClose(index);
					}
					changeClass(index);
				});

				settings.animationMode = stockAnimationMode;
			};

			// クラス名切り替え
			var changeClass = function(index) {
				if ($changeClassElement && $changeClassElement.length > 0) {
					if ($action.eq(index).data('data-accordion-status') === 'opened') {
						$changeClassElement.eq(index).addClass(settings.openedClassName).removeClass(settings.closedClassName);
					} else {
						$changeClassElement.eq(index).removeClass(settings.openedClassName).addClass(settings.closedClassName);
					}
				}
			};

			// 開閉
			$element.accChange = function(index, callback) {

				if ($action.eq(index).data('data-accordion-status') === 'opened') {
					if (settings.openedCloseMode) {
						$element.accClose(index, callback);
					}
				} else {
					$element.accOpen(index, callback);

					if (settings.autoClose) {
						$.each($action, function() {
							var aIndex = $action.index(this);
							if (aIndex !== index) {
								$element.accClose(aIndex);
								changeClass(aIndex);
							}
						});
					}
				}
				changeClass(index);
				return false;
			};

			// 開く
			$element.accOpen = function(index, callback) {
				var $item         = $items;
				var $targetAction = $action;

				if (index || index === 0) {
					$item         = $items.eq(index);
					$targetAction = $action.eq(index);
				}

				if (settings.animationMode) {
					$item.stop(false, true).slideDown(settings.animetionSpeed, settings.animetionEasing, function() {
						if (callback) {
							callback();
						}
					});
				} else {
					$item.show();
					if (callback) {
						callback();
					}
				}
				$targetAction.data('data-accordion-status', 'opened');

				return false;
			};

			// 閉じる
			$element.accClose = function(index, callback) {
				var $item         = $items;
				var $targetAction = $action;

				if (index || index === 0) {
					$item         = $items.eq(index);
					$targetAction = $action.eq(index);
				}

				if (settings.animationMode) {
					$item.stop(false, true).slideUp(settings.animetionSpeed, settings.animetionEasing, function() {
						if (callback) {
							callback();
						}
					});
				} else {
					$item.hide();
					if (callback) {
						callback();
					}
				}
				$targetAction.data('data-accordion-status', 'closed');

				return false;
			};


			init();
		}

		return this;
	};
})(jQuery);