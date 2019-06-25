const onPageLoad = () =>
{

}
const loadStars = (workshop,container) => {
	let stars = document.createElement('div');
		stars.setAttribute('class','stars');
		stars.innerHTML = "Difficulty :";

	for (let i = 1; i <= 3; i++) {
		let star = document.createElement('span');
		if(i <= workshop["ID_DIFFICULTY"])
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
const loadMedia = (workshop,container ) => {

	let media = document.createElement("div");
		media.setAttribute('class','media');


		if(workshop["MEDIA_TYPE"] == "mp4")
		{
			let video = document.createElement('video');
				video.width = '100%';
				video.height = '100%';
				video.controls ='controls';
				video.innerHTML = "Your browser does not support the video tag.";

				let source = document.createElement('source');
				source.src = workshop["MEDIA_PATH"];
				source.type = "video/" + workshop["MEDIA_TYPE"];
				video.appendChild(source);

			media.appendChild(video);

		}
		else if(workshop["MEDIA_TYPE"] == "png" ||
				workshop["MEDIA_TYPE"] == "jpg")
		{
			let image = document.createElement('img');
				image.src = workshop["MEDIA_PATH"];

			media.appendChild(image);
		}
		else if(workshop["MEDIA_TYPE"] == "mp3")
		{
			let audio = document.createElement('audio');
			audio.src = workshop["MEDIA_PATH"];
			audio.controls = 'controls';
			audio.innerHTML = "Your browser does not support the audio element.";

			media.appendChild(audio);
		}

	container.appendChild(media);
  }
const hideWorkshop = (container,id) =>
{
	container.previousSibling.style.height = 0;
	container.previousSibling.style.display = "block";

	removeHeightToContainer(container,id);

}
const showWorkshop = (id,element) =>
{
	let previousContainers = document.querySelectorAll(".workshops-info");
	if(previousContainers.length > 0)
	{
		previousContainers.forEach(element => {
			hideWorkshop(element);
		});
	}
	let container = document.createElement('div');
		container.setAttribute('class', "workshops-info col-sm-12");

	container.style.height = 0;
	container.innerHTML = "";
	container.style.display = "block";

	element.parentNode.parentNode.insertBefore(container,element.parentNode.nextSibling);
	container.previousSibling.removeAttribute('onclick');

	let formData = new FormData();
		formData.append('id', id);
		fetch("workshops-ajax.php", {
			method: "POST",
			credentials: 'include', // Pour envoyer les cookies avec la requête!
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			let workshop = data["workshop"];
			let robots =  data["robots"];

			console.log(data);

			let title = document.createElement("h2");
			title.innerHTML = workshop.NAME;

			let robot = document.createElement("h4");
			robot.innerHTML = robots[workshop.ID_ROBOT].NAME;

			let content = document.createElement("p");
			content.innerHTML = workshop.CONTENT;

			container.appendChild(title);
			container.appendChild(robot);
			container.appendChild(content);

			loadStars(workshop,container);
			loadMedia(workshop,container);

			addHeightToContainer(container,id);
		})


}

let searchParams = [];

const deleteSearchParams = () =>
{
	searchParams["difficulty"] = [];
	searchParams["age"] = [];
	searchParams["state"] = [];
	searchParams["robot"] = [];
	let filters = document.querySelectorAll(".card-body ul li");
	filters.forEach(filter => {
		filter.style.border = "none";
	});
	sortAndSearchWorkshops();
}
const setSearchParams = (name, value,node) =>
{
	if(searchParams[name].indexOf(value) > -1)
	{
		searchParams[name].splice(searchParams[name].indexOf(value),1);
		node.style.border = "none";
	}
	else
	{
		searchParams[name].push(value);
		node.style.border = "1px solid black";
	}

	sortAndSearchWorkshops();
}

const sortAndSearchWorkshops = () =>
{
	let select = document.getElementById("sort_select");
	let formData = new FormData();
	formData.append('sort', select.value);
	formData.append('search',true);
	for (const key in searchParams) {
		if (searchParams.hasOwnProperty(key)) {
			const element = searchParams[key];
			if(element.length > 0)
			{
				let json_arr = JSON.stringify(element);
				formData.append(key,json_arr);
			}
		}
	}
	fetch("workshops-ajax.php", {
		method: "POST",
		credentials: 'include', // Pour envoyer les cookies avec la requête!
		body: formData
	})
	.then(response => response.json())
	.then(data => {
		loadWorkshopsList(data["workshops"],data["member_workshops"]);
	});
}

let nbWorkshops = 4;
const loadWorkshopsList = (workshops,memberWorkshops) =>
{

	let divWorkshops = document.getElementById('workshops-list');
	divWorkshops.innerHTML ="";
		let container = document.createElement('div');
			container.setAttribute('class','container');

			let row = document.createElement('div');
				row.setAttribute('class','row');

			for (let i = 0; i < workshops.length; i++) {
				const workshop = workshops[i];
				let divWorkshop = document.createElement('div');
					divWorkshop.setAttribute('class', 'workshop col-sm-'+ 12/nbWorkshops )

					let divType = document.createElement('div');
						divType.setAttribute('class','type');

						let ancien = false;
						for (const key in memberWorkshops) {
							if (memberWorkshops.hasOwnProperty(key)) {
								const m_workshop = memberWorkshops[key];

								if(m_workshop["ID_WORKSHOP"] == workshop["ID"])
								{

									ancien = true;

									switch (m_workshop["STATUT"]) {
										case 0:
											divType.innerHTML = "Not Started";
											break;
										case 1:
											divType.innerHTML = "In Progress";
											break;
										case 2:
											divType.innerHTML = "Complete";
											break;
										default:
											break;
									}
								}
							}
						}
						if(!ancien)
						{
							divType.innerHTML = "New";
						}

					let divTitle = document.createElement('div');
						divTitle.setAttribute('class','title');

						let h2Title = document.createElement('h2');
							h2Title.innerHTML = workshop["NAME"];
						divTitle.appendChild(h2Title);

					divWorkshop.appendChild(divType);
					loadMedia(workshop,divWorkshop);
					divWorkshop.appendChild(divTitle);

				row.appendChild(divWorkshop);
			}

			container.appendChild(row);
		divWorkshops.appendChild(container);
}