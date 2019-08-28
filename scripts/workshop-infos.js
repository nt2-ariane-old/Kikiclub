const onPageLoad = () =>
{

}

let params = [];
params["difficulties"] = [];
params["grades"] = [];
params["robots"] = [];

const setParams = (type,value) =>
{
	if(params[type].indexOf(value) > -1)
	{
		params[type].splice(params[type].indexOf(value),1);
	}
	else
	{
		params[type].push(value);
	}

	applyParams();
}

const plusMinusSign = (node) =>
{
	let allSigns = document.querySelectorAll(".buttonSign");
	allSigns.forEach(sign => {
			sign.innerHTML = "+";
	});
	let sign = node.querySelector(".buttonSign");
	let nodeParent = node.parentNode;
		let card = nodeParent.querySelector(".collapse");		
		let opened = card.classList.contains("show");
		if(!opened)
		{
			sign.innerHTML = "-";
		}
}

const deleteParams = () =>
{
	params["difficulties"] = [];
	params["grades"] = [];
	params["robots"] = [];
	let filters = document.querySelectorAll("input[type='checkbox']");
	filters.forEach(filter => {
		filter.checked = false;
	});
	applyParams();
}

const applyParams = () =>
{
	let div = document.querySelector("#params");
	div.innerHTML = "";

	Object.keys(params).forEach(function(key){
		let value = params[key];
		value.forEach(element => {
			let input = document.createElement('input');
				input.setAttribute('type','hidden');
				input.setAttribute('name',key+"[]");
				input.setAttribute('value',element);
			div.appendChild(input);
		});
	 });

}

const assignAllUsers = () =>
{
	let loadingPage = document.querySelector('#loading-page');
		loadingPage.style = "display:block;";
		loadingPage.innerHTML = "";


		$.ajax({
			xhr: function()
			{
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(evt){
					if (evt.lengthComputable) {
				var percentComplete = (evt.loaded / evt.total) * 100 ;
				//Do something with upload progress
				let loadingBar = document.createElement('div');
				loadingBar.setAttribute('class','loading-bar');

				loadingPage.appendChild(loadingBar);

				loadingBar.innerHTML = percentComplete + "%";

				let load = document.createElement('div');
				load.setAttribute('class','loading-percentage');
				load.innerHTML = percentComplete + "%";

					load.style = "width:" + percentComplete + "%;";

					loadingBar.appendChild(load);

				}
			}, false);
			//Download progress
			xhr.addEventListener("progress", function(evt){
				if (evt.lengthComputable) {
					var percentComplete = (evt.loaded / evt.total) * 100 ;
					//Do something with download progress
					let loadingBar = document.createElement('div');
						loadingBar.setAttribute('class','loading-bar download');

					loadingPage.appendChild(loadingBar);
					loadingBar.innerHTML = percentComplete + "%";
					let load = document.createElement('div');
					load.setAttribute('class','loading-percentage');
					load.innerHTML = percentComplete + "%";

					load.style = "width:" + percentComplete + "%;";

				loadingBar.appendChild(load);
			}
		  }, false);
		  return xhr;
		},
		type: 'POST',
		url: "ajax/workshops-ajax.php",
		data: {
			"assign-all":true,
		},
		success: function(data){
		  //Do something success-ish
		  loadingPage.style = "display:none;";
		}
	  });
}