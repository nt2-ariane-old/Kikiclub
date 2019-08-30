const onPageLoad = () =>
{

}

let selected_badges = [];
const clicBadge = (node,badge) =>
{

	id = badge.id;
	if (window.event.ctrlKey) {
		let index = selected_badges.indexOf(id);
		if(index > -1)
		{
			selected_badges.splice(index, 1);
			node.style = "border:3px solid green";
		}
		else
		{
			selected_badges.push(id);
			node.style = "border:5px solid red;";
		}

	}
	else if(window.event.altKey)
	{
		if(node.querySelector("#update_" + id) != null)
		{
			node.innerHTML ="";
			node.style.height = "200px";
				let title = document.createElement('h5')
					title.innerHTML = badge.name;
				node.appendChild(title);
				loadMedia(badge,node);
		}
		else
		{
			node.innerHTML = "";
			node.style.height = "400px";

			inputMedia = document.createElement("div");
			inputMedia.setAttribute('id','drop_' + id);
			inputMedia.setAttribute('class','dropzone');
			loadMedia(badge,node)
			node.querySelector(".media").style = "height: 20%;min-height: 0;";
			inputName = document.createElement("input");
			inputName.setAttribute('type','text');
			inputName.setAttribute('placeholder','Name');
			inputName.value = badge.name;
			inputName.onkeyup=function(){updateBadge(id,{"name":inputName.value})};


			inputValue = document.createElement("input");
			inputValue.setAttribute('type','number');
			inputValue.setAttribute('placeholder','value needed');
			inputValue.value = badge.value_needed;
			inputValue.onkeyup=function(){updateBadge(id,{"value_needed":inputValue.value})};
			inputValue.onmouseup=function(){updateBadge(id,{"value_needed":inputValue.value})};

			inputHidden = document.createElement('input');
			inputHidden.setAttribute('type','hidden');
			inputHidden.setAttribute('id','update_' + badge.id);
			let selectType = document.createElement("SELECT");
			// types.forEach(type => {
				// 	let option = document.createElement('option');
				// 		option.value = type["id"];
				// 		option.innerHTML = type["name"];
				// 		selectType.appendChild(option);
				// 	});
				node.appendChild(inputMedia);
				node.appendChild(inputName);
				node.appendChild(inputValue);
				node.appendChild(selectType);
				node.appendChild(inputHidden);

				$(function() {
					let dropzone = new Dropzone("div#drop_" + id, {
						url: "ajax/media-ajax.php",
						params: {
							dir: "images/uploads/badges"
						 }
					});
					dropzone.on("success", function(file,infos) {
						infos = JSON.parse(infos);
							updateBadge(id, {"media_path":infos["path"],"media_type":infos["type"]} );
					});
				})
			}

				//window.location = "badges.php?workshop_id=" + id;
	}
}
const deleteBadges = () =>
{

	$.ajax({
		type: "POST",
		url:"ajax/badges-ajax.php",
		data: {
			'delete':null,
			'selected':JSON.stringify(selected_badges)

		},
		dataType: 'json',
		success: function( data ) {
			window.location = "badges.php";
		}
	})

}
const addBadge = () =>
{
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
					inputName.onkeyup=function(){updateBadge(id,{"name":inputName.value})};


					inputValue = document.createElement("input");
					inputValue.setAttribute('type','number');
					inputValue.setAttribute('placeholder','value needed');
					inputValue.onkeyup=function(){updateBadge(id,{"value_needed":inputValue.value})};
					inputValue.onmouseup=function(){updateBadge(id,{"value_needed":inputValue.value})};

					let selectType = document.createElement("SELECT");
						types.forEach(type => {
							let option = document.createElement('option');
								option.value = type["id"];
								option.innerHTML = type["name"];
							selectType.appendChild(option);
						});
					badge.appendChild(inputMedia);
					badge.appendChild(inputName);
					badge.appendChild(inputValue);
					badge.appendChild(selectType);

			container.appendChild(badge);

			$(function() {
				let dropzone = new Dropzone("div#drop_" + id, {
					url: "ajax/media-ajax.php",
					params: {
						dir: "images/uploads/badges"
				 	}
				});
				dropzone.on("success", function(file,infos) {
					infos = JSON.parse(infos);
						updateBadge(id, {"media_path":infos["path"],"media_type":infos["type"]} );
				});
			})
		}
	});


}

const updateBadge = (id,params) =>
{

	$.ajax({
		type: "POST",
		url:"ajax/badges-ajax.php",
		data: {
			'update':null,
			'id':id,
			'params':params
		},
		dataType: 'json',
		success: function( data ) {
		}
	});
}