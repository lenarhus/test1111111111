var suggest_count = 0;
var query = '';
var suggest_selected = 0;

$(window).load(function(){
	// читаем ввод с клавиатуры
	$("#search_box").keyup(function(I){
		// определяем какие действия нужно делать при нажатии на клавиатуру
		switch(I.keyCode) {
			// игнорируем нажатия на эти клавишы
			case 13:  // enter
			case 27:  // escape
			case 38:  // стрелка вверх
			case 40:  // стрелка вниз
			break;

			default:
				// производим поиск только при вводе более 2х символов
				if($(this).val().length>2){
					query = $(this).val();
					$.ajax({
					    type: "post",
					    url: '/main/stooltips',
					    data:{
					      "query" : query
					    },
					    success: function(data){
							var result = JSON.parse(data);
							// перед показом слоя подсказки, его обнуляем
							$("#search_advice_wrapper").html("").show();
							for(var res in result){
								suggest_count++;
								if(result[res] != ''){
									// добавляем слою позиции
									$('#search_advice_wrapper').append('<div class="advice_variant">'+result[res]+'</div>');
								}
							}
					    }
					});
				}
			break;
		}
	});

	//считываем нажатие клавишь, уже после вывода подсказки
	$("#search_box").keydown(function(I){
		console.log(I.keyCode);
		switch(I.keyCode) {
			// по нажатию клавишь прячем подсказку
			case 13: // enter
			case 27: // escape
				$('#search_advice_wrapper').hide();
				return false;
			break;
			// делаем переход по подсказке стрелочками клавиатуры
			case 38: // стрелка вверх
			case 40: // стрелка вниз
				I.preventDefault();
				//if(suggest_count){
					//делаем выделение пунктов в слое, переход по стрелочкам
					key_activate( I.keyCode-39 );
				//}
			break;
		}
	});

	// делаем обработку клика по подсказке
	$(document).on('click', '.advice_variant', function(){
		console.log($(this).text());
		// ставим текст в input поиска
		$('#search_box').val($(this).text());
		// прячем слой подсказки
		$('#search_advice_wrapper').fadeOut(350).html('');
	});

	// если кликаем в любом месте сайта, нужно спрятать подсказку
	$('html').click(function(){
		$('#search_advice_wrapper').hide();
	});
	// если кликаем на поле input и есть пункты подсказки, то показываем скрытый слой
	$('#search_box').click(function(event){
		//alert(suggest_count);
		if(suggest_count)
			$('#search_advice_wrapper').show();
		event.stopPropagation();
	});
});

function key_activate(n){
	$('#search_advice_wrapper div').eq(suggest_selected-1).removeClass('active');

	if(n == 1 && suggest_selected < suggest_count){
		suggest_selected++;
	}else if(n == -1 && suggest_selected > 0){
		suggest_selected--;
	}

	if( suggest_selected > 0){
		$('#search_advice_wrapper div').eq(suggest_selected-1).addClass('active');
		$("#search_box").val( $('#search_advice_wrapper div').eq(suggest_selected-1).text() );
	} else {
		$("#search_box").val( query );
	}
}