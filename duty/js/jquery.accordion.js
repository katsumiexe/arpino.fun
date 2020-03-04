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

			// �������s
			var init = function() {
				/*
					actionElement        : �A�N�V�������N�����Ώۂ̗v�f [ jQuery Object | Element Name ]
					openAndCcloseElement : �W�J������v�f [ jQuery Object | Element Name ]
					addClassElement      : �J�����Ƃ���CSS�N���X����K�p����v�f [ this | parent | jQuery Object | Element Name ]
					actionEvent          : �A�N�V�����C�x���g
					startOpenIndex       : �ǂݍ��ݎ��ɍŏ��ɕ\������v�f�̃C���f�b�N�X�ԍ��i-1�Ŗ����j
					closedClassName      : ���Ă����Ԃ�CSS�N���X��
					openedClassName      : �J���Ă����Ԃ�CSS�N���X��
					animationMode        : �A�j���[�V�������[�h [ true | false ]
					animetionSpeed       : �A�j���[�V�����̑��x
					animetionEasing      : �A�j���[�V�����̃C�[�W���O
					autoClose            : �J�����v�f�ȊO�̗v�f�������I�ɕ��邩�ǂ��� [ true | false ]
					openedCloseMode      : �A�N�V�������N�������v�f�̊J����v�f���J���Ă���ꍇ�ɕ��邩�ǂ��� [ true | false ]
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

			// �Z�b�g�A�b�v
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

			// �N���X���؂�ւ�
			var changeClass = function(index) {
				if ($changeClassElement && $changeClassElement.length > 0) {
					if ($action.eq(index).data('data-accordion-status') === 'opened') {
						$changeClassElement.eq(index).addClass(settings.openedClassName).removeClass(settings.closedClassName);
					} else {
						$changeClassElement.eq(index).removeClass(settings.openedClassName).addClass(settings.closedClassName);
					}
				}
			};

			// �J��
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

			// �J��
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

			// ����
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