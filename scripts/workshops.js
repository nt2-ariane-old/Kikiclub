const onPageLoad = () =>
{

}

let searchParams = [];

const setSearchParams = (name, value) =>
{
	if(searchParams[name].indexOf(value) > -1)
	{
		searchParams[name].splice(searchParams[name].indexOf(value),1);
	}
	else
	{
		searchParams[name].push(value);
	}

	sortAndSearchWorkshops();
}
searchParams["states"] = [];
const deleteSearchParams = () =>
{
	searchParams["difficulties"] = [];
	searchParams["grades"] = [];
	searchParams["robots"] = [];
	let filters = document.querySelectorAll("input[type='checkbox']");
	filters.forEach(filter => {
		filter.checked = false;
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
	fetch("ajax/workshops-ajax.php", {
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
	let isFamilyMember = document.getElementById("isFamilyMember").value;

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
						if(isFamilyMember)
						{
							let divType = document.createElement('div');
							divType.setAttribute('class','type ribbon');
								let spanContent = document.createElement('span');
									spanContent.setAttribute('class','content');
							let ancien = false;
							for (const key in memberWorkshops) {
								if (memberWorkshops.hasOwnProperty(key)) {
									const m_workshop = memberWorkshops[key];

									if(m_workshop["ID_WORKSHOP"] == workshop["ID"])
									{

										ancien = true;
										spanContent.innerHTML = states[m_workshop["ID_STATUT"]]["NAME"];
									}
								}
							}
							if(!ancien)
							{
								spanContent.innerHTML = states[1]["NAME"];
							}
								divType.appendChild(spanContent);
							link.appendChild(divType);

						}


						let divTitle = document.createElement('div');
							divTitle.setAttribute('class','title');

							let h2Title = document.createElement('h2');
								h2Title.innerHTML = workshop["NAME"];
							divTitle.appendChild(h2Title);

						loadMedia(workshop,link);
						link.appendChild(divTitle);

					divWorkshop.appendChild(link);
				row.appendChild(divWorkshop);
			}

			container.appendChild(row);
		divWorkshops.appendChild(container);
}