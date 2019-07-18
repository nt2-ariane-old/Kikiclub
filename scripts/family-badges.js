const onPageLoad = () =>
{

}

const loadBadgesLine = () =>
{
	let container = document.querySelector("#Badges");
}
const addBadge = () =>
{
	console.log('clic');
	$.ajax({
		type: "POST",
		url:"ajax/badges-ajax.php",
		data: {
			'add':null
		},
		dataType: 'json',
		success: function( data ) {
			let types = data["types"];
			let id = data["id"];
			let container = document.querySelector("#Badges");

				let badge = document.createElement("div");
					badge.setAttribute('class', 'kikiclub-badge col-sm-3');

					inputMedia = document.createElement("div");
					inputMedia.setAttribute('id','drop_' + id);
					inputMedia.setAttribute('class','dropzone');


					inputName = document.createElement("input");
					inputName.setAttribute('type','text');
					inputName.setAttribute('placeholder','Name');
					inputName.onkeyup=function(){updateBadge(id,{"NAME":inputName.value})};


					inputValue = document.createElement("input");
					inputValue.setAttribute('type','number');
					inputValue.setAttribute('placeholder','value needed');
					inputValue.onkeyup=function(){updateBadge(id,{"VALUE_NEEDED":inputValue.value})};
					inputValue.onmouseup=function(){updateBadge(id,{"VALUE_NEEDED":inputValue.value})};

					let selectType = document.createElement("SELECT");
						types.forEach(type => {
							let option = document.createElement('option');
								option.value = type["ID"];
								option.innerHTML = type["NAME"];
							selectType.appendChild(option);
						});
					badge.appendChild(inputMedia);
					badge.appendChild(inputName);
					badge.appendChild(inputValue);
					badge.appendChild(selectType);

			container.appendChild(badge);

			$(function() {
				let dropzone = new Dropzone("div#drop_" + id, { url: "ajax/media-ajax.php.php"});
				dropzone.on("success", function(file,infos) {
					infos = JSON.parse(infos);
						updateBadge(id, {"MEDIA_PATH":infos["PATH"],"MEDIA_TYPE":infos["TYPE"]} );
				});
			})
		}
	});


}

const updateBadge = (id,params) =>
{
	console.log(id);
	$.ajax({
		type: "POST",
		url:"ajax/badges-ajax.php",
		data: {
			'modify':null,
			'id':id,
			'params':params
		},
		dataType: 'json',
		success: function( data ) {
			console.log(data);
		}
	});
}