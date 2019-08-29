let classicEditor;
Dropzone.autoDiscover = false;
const loadModules = () =>
{

	editor = document.querySelector('#editor');
	if(editor != null)
	{
		ClassicEditor
		.create( editor, {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editorCK => {
			classicEditor = editorCK;

			let editable = document.querySelector('.ck-editor__editable');
			editable.addEventListener('keydown',function(event)
			{
				limitText(editable,512);

			})
			limitText(editable,512);
			window.editor = classicEditor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
	}

	if(document.querySelector('.carousel') != null)
	{
		$('.carousel').carousel({
			interval: false
		});
	}

}

const openWorkshop = ($id) =>
{
	$.ajax({
		type: "POST",
		url:'ajax/workshops-ajax.php',
		data:
		 {
			'id':$id
		 },
		dataType: 'json',
		success: function( data ) {
			workshop = data["workshop"];
			filters = data["filters"];

			let node = document.getElementById('modal_content');
				node.innerHTML = "";
				
				let workshop_div = document.createElement('div');
					workshop_div.setAttribute('class','workshop-infos');

					loadMedia(workshop,workshop_div);
					let infos_div = document.createElement('div');
						infos_div.setAttribute('class','infos');
					
						let name = document.createElement('h3');
							name.innerHTML = workshop['name'];
						infos_div.appendChild(name);
						let content = document.createElement('div');
							content.innerHTML = workshop['content'];
						infos_div.appendChild(content);

						for (const keyf in filters) {
							if (filters.hasOwnProperty(keyf)) {
								const filter = filters[keyf];
								let filterB = document.createElement('b');
									filterB.innerHTML = read('workshops',keyf) + " : ";
									let ul = document.createElement('ul');

										for (const keyi in filter) {
											if (filter.hasOwnProperty(keyi)) {
												const element = filter[keyi];
												let li = document.createElement('li');
													li.innerHTML =element["filter"];
												ul.appendChild(li);											
											}
										}
									filterB.appendChild(ul);
								infos_div.appendChild(filterB);
							}
						}		
						
						

					workshop_div.appendChild(infos_div);
				node.appendChild(workshop_div);
		},

	});
}
const limitText = (textarea, limitNum) => {

	let node = document.getElementById("countdown");
	let textValue = textarea.innerHTML;
	if (textValue.length > limitNum) {
		classicEditor.setData(textValue.substring(0, limitNum))
		setCursorToEnd();
	} else {
		let value =  (limitNum - textarea.innerHTML.length);
		node.innerHTML = value + "";
	}
}

const openTab = (evt, tab) => {

	let tabcontent = document.querySelectorAll(".tabcontent");
	for ( let i = 0; i < tabcontent.length; i++) {
	  tabcontent[i].style.display = "none";
	}

	let tablinks = document.querySelectorAll(".tablinks");
	for ( let i = 0; i < tablinks.length; i++) {
	  tablinks[i].className = tablinks[i].className.replace(" active", "");
	}

	document.getElementById(tab).style.display = "block";
	evt.currentTarget.classList.add("active");

}
let closeProfilesBox = () =>
{
	let box = document.querySelector("#profile-box");
	box.style.display = "none";
}


let change_page = (path, params) => {
  set_value(params,() => { redirect(path)});
}
let redirect = (path) =>
{
	window.location = path;
}
let post = (path, params, method='post') => {

  const form = document.createElement('form');
  form.method = method;
  form.action = path;

  for (let key in params) {
    if (params.hasOwnProperty(key)) {
      const hiddenField = document.createElement('input');
      hiddenField.type = 'hidden';
      hiddenField.name = key;
      hiddenField.value = params[key];

      form.appendChild(hiddenField);
    }
  }

  document.body.appendChild(form);
  form.submit();
}

const read = (page, node) => {
	value = "TEXT_NOT_FOUND";
	if(page in langData)
	{
		if (node in langData[page])
		{
			value = langData[page][node];
		}
	}

	return value;
}
const loadStars = (object,container) => {
	let stars = document.createElement('div');
		stars.setAttribute('class','stars');
		stars.innerHTML = read('workshops','difficulty') + " : ";

	for (let i = 1; i <= 3; i++) {
		let star = document.createElement('span');
		if(i <= object["ID_DIFFICULTY"])
		{
			star.setAttribute('class','fa fa-star checked');
		}
		else
		{
			star.setAttribute('class','fa fa-star');
		}
		stars.appendChild(star);
	}
	container.appendChild(stars);
}
const loadMedia = (object,container ) => {

	let media = document.createElement("div");
		media.setAttribute('class','media');

		if(object["media_type"] == "mp4" ||
			object["media_type"] == "mov" ||
			object["media_type"] == "flv" ||
			object["media_type"] == "avi" ||
			object["media_type"] == "wmv")
		{
			let video = document.createElement('video');
				video.width = '100%';
				video.height = '100%';
				video.controls ='controls';
				video.innerHTML = "Your browser does not support the video tag.";

				let source = document.createElement('source');
				source.src = object["media_path"];
				source.type = "video/" + object["media_type"];
				video.appendChild(source);

			media.appendChild(video);

		}
		else if(object["media_type"] == "png" ||
				object["media_type"] == "jpg" ||
				object["media_type"] == "jpeg" ||
				object["media_type"] == "bmp" ||
				object["media_type"] == "tiff" ||
				object["media_type"] == "gif")
		{

			media.style = "background-image:url('" +object['media_path'] +"');";
			// let image = document.createElement('img');
			// 	image.src = object["media_path"];

			// media.appendChild(image);
		}
		else if(object["media_type"] == "mp3")
		{
			let audio = document.createElement('audio');
			audio.src = object["media_path"];
			audio.controls = 'controls';
			audio.innerHTML = "Your browser does not support the audio element.";

			media.appendChild(audio);
		}

	container.appendChild(media);
	}

let clicked;
const openConfirmBox = (form,params) =>
{
	let confirmBox = document.createElement('div');
			confirmBox.setAttribute('class','alert alert-warning');
			confirmBox.setAttribute('id','confirm-box');

	let text = document.createElement('p');
			text.innerHTML = 'Are you sure you want to do this?';

	let yesBtn = document.createElement('button');
			yesBtn.onclick = () => {accept(form,params)};
			yesBtn.setAttribute('class','btn btn-success');
			yesBtn.innerHTML = "Yes";

	let noBtn = document.createElement('button');
			noBtn.setAttribute('onclick','refuse()');
			noBtn.setAttribute('class','btn btn-danger');
			noBtn.innerHTML = "No";

		confirmBox.appendChild(text);
		confirmBox.appendChild(yesBtn);
		confirmBox.appendChild(noBtn);

	document.getElementById("box").appendChild(confirmBox);

	return false;
}

const accept = (form,params) =>
{
	if(params.type == 'form')
	{
		let typeInput = document.createElement('input');
		typeInput.type = 'hidden';
		typeInput.name = clicked;

		form.appendChild(typeInput)

		form.onsubmit = 'return true';
		form.submit();
	}
	else if(params.type == 'post')
	{
		post(params.path,params.params);
	}
	else if(params.type == 'ajax')
	{
		$.ajax({
			type: "POST",
			url:params.path,
			data: params.params,
			dataType: 'json',
			success: function( data ) {

				if(data["type"] == "deployed")
				{
					if(data["state"] == "true")
					{
						//sendEmail(data["workshop"]);
					}
				}
			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		});
		let box = document.querySelector('#confirm-box');
		box.remove();

	}
	else if(params.type == 'function')
	{
		params.function();
		let box = document.querySelector('#confirm-box');
		box.remove();
	}

}
const refuse = () =>
{
	let confirmBox = document.getElementById('confirm-box');
	confirmBox.parentElement.removeChild(confirmBox);

	return false;
}

const set_value = (values,callback) =>
{
	if(isDict(values))
	{
		values['set_value'] = null;
		$.ajax({
			type: "POST",
			url:'ajax/basic-ajax.php',
			data:values,
			dataType: 'json',
			success: function( data ) {
				callback();
			},

		});
	}
}

const showProfiles = () =>
{
		 let node = document.getElementById("profile-box");
		 node.style.display = "block";
}

const isDict = (v) => {
    return typeof v==='object' && v!==null && !(v instanceof Array) && !(v instanceof Date);
}

const sortingTable = (tableName,n) => {
  let table = document.getElementById(tableName);

	let switching = true;

  while (switching) {
		switching = false;

		tableRows = table.rows;


		for (let i = 1; i < tableRows.length - 1; i++) {
			const row1 = tableRows[i].querySelectorAll("TD")[n];
			const row2 = tableRows[i+1].querySelectorAll("TD")[n];

			if(row1.innerHTML.toLowerCase() > row2.innerHTML.toLowerCase())
			{
				tableRows[i].parentNode.insertBefore(tableRows[i + 1], tableRows[i]);
				switching = true;

			}
		}
	}
}