window.onload = function(){
	$('#addalbumbutton').click(function(){
		event.preventDefault();

		var form = document.forms.addalbumform;
		var formData = new FormData(form); 
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "admin.php");
		xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if(xhr.status == 200) {
                    data = xhr.responseText;
                    console.log(data);
                    if(data == "1") {
						location.reload();
                    }
                    else{
                    	$('#addalbumform .modal-body').append('<div class="alert alert-danger">Что-то пошло не так, попробуйте снова</div>');
                    }
                }
            }
        };
        xhr.send(formData);
	});

	$('.deletealbum').click(function(){
		event.preventDefault();
		$.get(event.target.href, ajaxDeleteAlbum);
		return false;
	});

	function ajaxDeleteAlbum(data)
	{
		var parse = JSON.parse(data);
		if(parse[0] == 1){
			console.log($.trim($('.panel-body h2').text()));
			console.log(parse[1]);
			console.log();
			if(parse[1] == $.trim($('.panel-body h2').text()))
				location.reload();
			var $li = $('.panel-group .list-group li .go-in-album'); 
			for (var i = 0; i < $li.length; i++) {
				if($($li[i]).text() == parse[1])
					$($li[i]).parent().remove();
			};
		}
	}

	$('.delete-img').click(function(){
		event.preventDefault();
		$.get(event.target.href, ajaxDeleteImage);
		return false;
	});

	function ajaxDeleteImage(data){
		var parse = JSON.parse(data);
		if(parse[0] == 1){
			var $foto = $('.foto img'); 
			for (var i = 0; i < $foto.length; i++) {
				if($($foto[i]).attr('src') == 'images/'+parse[1])
					$($foto[i]).parent().remove();
			};
		}
	}

	$('#editalbumbutton').click(function(){
		event.preventDefault();

		var form = document.forms.editalbumform;
		var formData = new FormData(form); 
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "admin.php");
		xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if(xhr.status == 200) {
                    data = xhr.responseText;
                    console.log(data);
                    var parse = JSON.parse(data);
                    if(parse[0] == 1) {
						$('.bigfoto img').attr('src', 'images/'+parse[1]);
                    }
                    
                }
            }
        };
        xhr.send(formData);
	});

	$('#addimagebutton').click(function(){
		event.preventDefault();

		var form = document.forms.addimageform;
		var formData = new FormData(form); 
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "admin.php");
		xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if(xhr.status == 200) {
                    data = xhr.responseText;
                    console.log(data);
                    var parse = JSON.parse(data);
                    if(parse[0] == 1) {
                    	var newFoto='<div class="col-xs-6 col-md-3 col-sm-4 foto">'
                    	newFoto+='<img src="images/'+parse[1]+'" alt="" class="img-responsive">';
						newFoto+='<a href="admin.php?method=deleteimage&image='+parse[3]+'&album='+parse[2]+'" class="glyphicon glyphicon-trash delete-img"></a>'
						newFoto+='</div>';
                    	$('.col-md-9 .panel-default .panel-body').append(newFoto);
                    	$('.delete-img').off('click');
				    	$('.delete-img').click(function(){
							event.preventDefault();
							$.get(event.target.href, ajaxDeleteImage);
							return false;
						});
                    }
                    
                }
            }
        };
        xhr.send(formData);
	});

	$('.go-in-album').click(function(){
		event.preventDefault();
		$.get(event.target.href, ajaxGetAlbum);
		return false;
	});

	function ajaxGetAlbum(data){
		console.log(data);
		var parse = JSON.parse(data);
		var id = parse[0];
		var name = parse[1];
		var image = parse[2];
		var crop_x = parse[3];
		var crop_y = parse[4];
		var imagearray = parse[5];

		$('.bigfoto img').attr('src', 'images/' + image);
		var html = name + '<a href="admin.php?method=deletealbum&amp;album='+id+'" class="glyphicon glyphicon-trash deletealbum" id="deletealbumbutton"></a>'
		$('.bigfoto+h2').html(html);
    	$('#deletealbumbutton').click(function(){
    		event.preventDefault();
			$.get(event.target.href, ajaxDeleteAlbum);
			return false;
    	});
    	$('#editalbumindex').val(id);
    	$('#addimageindex').val(id);
    	$('.foto:not(.bigfoto)').remove();
    	html = '';
    	for (var i = 0; i < imagearray.length; i++) {
    		html += '<div class="col-xs-6 col-md-3 col-sm-4 foto">';
			html += '<img src="images/' + imagearray[i][1] + '" alt="" class="img-responsive">';
			html += '<a href="admin.php?method=deleteimage&image=' + imagearray[i][0] + '&album=' + id + '" class="glyphicon glyphicon-trash delete-img"></a>';
			html += '</div>';
    	};
    	$('.col-md-9 .panel-default .panel-body').append(html);
    	$('.delete-img').off('click');
    	$('.delete-img').click(function(){
			event.preventDefault();
			$.get(event.target.href, ajaxDeleteImage);
			return false;
		});
	}
}