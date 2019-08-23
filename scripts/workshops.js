const onPageLoad = () =>
{

}

let searchParams = [];
let currentPage = 0;
const setPage = (page) =>
{
	currentPage = page;
	sortAndSearchWorkshops();
}
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
	formData.append('page',currentPage);
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
		let direct_link = false;
		if(data["direct_link"] != null)
		{
			direct_link = true;
		}
		if(data["workshops"].length > 0)
		{
			loadWorkshopsList(data["workshops"],data["nbPages"],direct_link);
		}
		else
		{
			let divWorkshops = document.getElementById('workshops-list');
				divWorkshops.innerHTML = "";
				let h3error = document.createElement('h3');
					h3error.innerHTML = "Aucun Ateliers Disponibles";
				divWorkshops.appendChild(h3error);
			let indexes = document.querySelector('#indexes');
				indexes.innerHTML = "";
		}
	});
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


const openFilters = () =>
{
	let node = document.querySelector('aside');
	node.style.width = "100%";
	node.style.padding = "60px 10px";
}
const closeFilters = () =>
{
	let node = document.querySelector('aside');
	node.style.width = "0";
	node.style.padding = "0";
}

let nbWorkshops = 4;

function openModal() {
	document.getElementById("workshop_modal").style.display = "flex";
  }
  function closeModal() {
	document.getElementById("workshop_modal").style.display = "none";
  }


const loadWorkshopsList = (workshops,nbPage,direct_link) =>
{
	let divWorkshops = document.getElementById('workshops-list');
	divWorkshops.innerHTML ="";
		let container = document.createElement('div');

			container.setAttribute('class','container');

			let row = document.createElement('div');
				row.setAttribute('class','row');

			for (let i = 0; i < workshops.length; i++) {
				const workshop = workshops[i];
				let divCol = document.createElement('div');

					divCol.setAttribute('class', ' col-sm-'+ 12/nbWorkshops )

					divWorkshop = document.createElement('div');
					divWorkshop.setAttribute('class','workshop');
					if(direct_link)
					{
						divWorkshop.onmousedown = () => clicWorkshop(divCol,workshop["id"]);
					}
					else
					{
						divWorkshop.setAttribute('onclick','openModal();openWorkshop('+workshop["id"]+');');
					}

					if(!workshop["deployed"])
					{
						divWorkshop.style.backgroundColor = "red";
					}
					let link = document.createElement('a');

					link.setAttribute('class','link normal');
					

						let divTitle = document.createElement('div');
							divTitle.setAttribute('class','title');

							let h2Title = document.createElement('h2');
								h2Title.innerHTML = workshop["name"];
							divTitle.appendChild(h2Title);

						loadMedia(workshop,link);
						link.appendChild(divTitle);

					divWorkshop.appendChild(link);
					divCol.appendChild(divWorkshop)
				row.appendChild(divCol);
			}

			container.appendChild(row);
		divWorkshops.appendChild(container);

		let indexes = document.querySelector('#indexes');

		indexes.innerHTML = "";

		for (let i = 1; i <= nbPage; i++) {
			let button = document.createElement('button');
				button.onclick = () => setPage(i - 1);
				button.innerHTML = i;
			indexes.appendChild(button);
		}

}
let selected_workshops = [];
const clicWorkshop = (node,id) =>
{

	if (window.event.ctrlKey) {
		let index = selected_workshops.indexOf(id);
		if(index > -1)
		{
			selected_workshops.splice(index, 1);
			node.style = "border:none";
		}
		else
		{
			selected_workshops.push(id);
			node.style = "border:5px solid red;";

		}

	}
	else
	{
		window.location = "workshop-infos.php?workshop_id=" + id;
	}
}
const deleteSelected = () =>
{
	let selected = JSON.stringify(selected_workshops);

	$.ajax({
		type: "POST",
		url:'ajax/workshops-ajax.php',
		data: {
			'selected' : selected,
			'delete_multiple' : true
		},
		dataType: 'json',
		success: function( data ) {
			sortAndSearchWorkshops();
			selected_workshops = [];
		},
		error: function (request, status, error) {
			console.log(request.responseText);
		}
	});
}

const deployed_selected = () =>
{
	let selected = JSON.stringify(selected_workshops);
	$.ajax({
		type: "POST",
		url:'ajax/workshops-ajax.php',
		data: {
			'selected' : selected,
			'deployed_multiple' : true
		},
		dataType: 'json',
		success: function( data ) {
			sortAndSearchWorkshops()
			selected_workshops = [];
		},
		error: function (request, status, error) {
			console.log(request.responseText);
		}
	});

}