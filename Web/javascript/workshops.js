const onPageLoad = () =>
{

}

let searchParams = [];

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
		loadWorkshopsList(data["workshops"],data["member_workshops"],data["states"]);
	});
}

let nbWorkshops = 4;
const loadWorkshopsList = (workshops,memberWorkshops,states) =>
{
	console.log(states);
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
					let link = document.createElement('a');
					link.href = "workshop-infos.php?workshop=" + workshop["ID"];
					link.setAttribute('class','link normal');
						let divType = document.createElement('div');
							divType.setAttribute('class','type');

							let ancien = false;
							for (const key in memberWorkshops) {
								if (memberWorkshops.hasOwnProperty(key)) {
									const m_workshop = memberWorkshops[key];

									if(m_workshop["ID_WORKSHOP"] == workshop["ID"])
									{

										ancien = true;
										console.log(m_workshop["STATUT"]);
										divType.innerHTML = states[m_workshop["STATUT"]]["NAME"];
									}
								}
							}
							if(!ancien)
							{
								divType.innerHTML = states[1]["NAME"];
							}

						let divTitle = document.createElement('div');
							divTitle.setAttribute('class','title');

							let h2Title = document.createElement('h2');
								h2Title.innerHTML = workshop["NAME"];
							divTitle.appendChild(h2Title);

						link.appendChild(divType);
						loadMedia(workshop,link);
						link.appendChild(divTitle);

					divWorkshop.appendChild(link);
				row.appendChild(divWorkshop);
			}

			container.appendChild(row);
		divWorkshops.appendChild(container);
}