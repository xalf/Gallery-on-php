/*
	события для главной страницы
*/
window.onload = function()
{
	/****************событие колёсика мыши**************/
	var elem = document.getElementsByTagName('body')[0];
	
	//плавный скроллинг
	function scroll(min)
	{
		var destination = window.innerHeight;
		$('body').animate( { scrollTop: $(window).scrollTop()+min*destination }, 600,'linear' );
	}
	
	/********************событие кнопок вверх-вниз********************/
	document.getElementsByTagName('body')[0].onkeydown=function()
	{
		if(event.keyCode==38){
			scroll(-1);
		}
		if(event.keyCode==40){
			scroll(1);
		}
	}
	
	/*******************вешаем обработчик области скроллинга вниз******************/
	var downField = document.getElementsByClassName('down-scroll'); 

	for(var i=0;i<downField.length;i++){
		$(downField[i]).click(function(){
			event.preventDefault();
			scroll(1);
		});
	}

	/**************оформление выезжающего меню*************/
	function abs(){
		$('.menu').toggleClass('abs');
	}
	function mobileMenuAction(){
		if($('.menu').hasClass('abs')) {
			abs();
			$('.mobile-menu').toggleClass('mobile-menu-z-index');
		}
		else {
			$('.menu').toggleClass('abs');
			setTimeout(function(){$('.mobile-menu').toggleClass('mobile-menu-z-index');},300);
		}
	}
	$('.menu-button').click(mobileMenuAction);
	
	 /****  Регистрация и вход  *****/


	 $('#loginsubmit').click(function(){
	 	event.preventDefault();

		var form = document.forms.loginform;
		var formData = new FormData(form); 
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "testreg.php");
		xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if(xhr.status == 200) {
                    data = xhr.responseText;
                    console.log(data);
                    if(data == "1") {
						location.reload();
                    }
                    else{
                    	$('#loginform .modal-body').append('<div class="alert alert-danger">Что-то пошло не так, попробуйте снова</div>');
                    }
                }
            }
        };
        xhr.send(formData);
	 });

	 $('#regsubmit').click(function(){
	 	event.preventDefault();

		var form = document.forms.regform;
		var formData = new FormData(form); 
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "save_user.php");
		xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if(xhr.status == 200) {
                    data = xhr.responseText;
                    console.log(data);
                    if(data == "1") {
						location.reload();
                    }
                    else{
                    	$('#regform .modal-body').append('<div class="alert alert-danger">Что-то пошло не так, попробуйте снова</div>');
                    }
                }
            }
        };
        xhr.send(formData);
	 });
}