/**
*	Site-specific configuration settings for Highslide JS
*/
hs.graphicsDir = 'themes/grin/javascript/highslide/graphics/';
hs.outlineType = 'custom';
hs.fadeInOut = true;
hs.align = 'center';
hs.useBox = true;
hs.width = 760;
hs.height = 760;
hs.captionEval = 'this.a.title';


// Add the slideshow controller
hs.addSlideshow({
	slideshowGroup: 'group1',
	interval: 3000,
	repeat: false,
	useControls: true,
	fixedControls: 'fit',
	overlayOptions: {
		className: 'large-dark',
		opacity: '0.6',
		position: 'bottom center',
		offsetX: '0',
		offsetY: '-15',
		hideOnMouseOut: true
	},
	thumbstrip: {
		mode: 'horizontal',
		position: 'above',
		relativeTo: 'image'
	}

});

// Russian language strings
hs.lang = {
cssDirection: 'ltr',
loadingText: 'Загрузка ...',
loadingTitle: 'Нажмите для отмены',
focusTitle: 'Нажмите чтобы переместить на передний план',
fullExpandTitle: 'Раскрыть к оригинальному размеру',
creditsText:'',
creditsTitle: 'Посетить домашнюю страницу Highslide JS',
previousText: 'предыдущий',
nextText: 'следующий',
moveText: 'Переместить',
closeText: 'Закрыть',
closeTitle: 'Закрыть (esc)',
resizeTitle: 'Изменить размер',
playText: 'Слайдшоу',
playTitle: 'Начать слайдшоу (пробел)',
pauseText: 'Пауза',
pauseTitle: 'Приостановить слайдшоу (пробел)',
previousTitle: 'предыдущий (стрелка влево)',
nextTitle: 'Следующее (стрелка справа)',
moveTitle: 'Переместить',
fullExpandText: 'Исходный размер',
number: 'Изображение %1 из %2',
restoreTitle: 'Нажмите кнопку мыши, чтобы закрыть изображение, нажмите и перетащите для изменения расположения. Для просмотра изображений пользуйтесь стрелками. '
};

// gallery config object
var config1 = {
	slideshowGroup: 'group1',
	thumbnailId: 'thumb1',
	numberPosition: 'caption',
	transitions: ['expand', 'crossfade']
};
