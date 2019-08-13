const onPageLoad = () =>
{
	$('#mixedSlider_badges').multislider({
		interval:0,
	});
}

const show = (id,link) =>
{
	let node = document.getElementById(id);
	if(node != null)
	{
		if(node.offsetHeight > 180)
		{
			node.style = "height:180px;"
			link.innerHTML = "Afficher plus";
		}
		else
		{
			node.style = "height:auto;"
			link.innerHTML = "Afficher moins";

		}
	}
	else
	{
		console.log("no node");
	}
}


function openModal() {
	document.getElementById("member_modal").style.display = "block";
  }
  function closeModal() {
	document.getElementById("member_modal").style.display = "none";
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
			console.log(filters);

			let node = document.getElementById('modal_content');
				node.innerHTML = "";
				let workshop_div = document.createElement('div');
					workshop_div.setAttribute('class','workshop-infos');

					loadMedia(workshop,workshop_div);
					let strings = []
					console.log(filters["difficulty"]);
					for (const keyf in filters) {
						if (filters.hasOwnProperty(keyf)) {
							const filter = filters[keyf];
							strings[keyf] = "";
							let i = 0;
							for (const keyi in filter) {
								if (filter.hasOwnProperty(keyi)) {
									const element = filter[keyi];
									console.log(element);
									if(i > 0)
									{
										strings[keyf] += ", "
									}
									strings[keyf] += element["filter"] ;
									i++;
								}
							}
						}
					}



					let name = document.createElement('h2');
					name.innerHTML = workshop['name'];

					let botsh4 = document.createElement('h4');
						if( strings["robot"] != null)
							botsh4.innerHTML = "Robots : " + strings["robot"];
					let gradesh4 = document.createElement('h4');
						if( strings["grade"] != null)
							gradesh4.innerHTML = "Grades Recommanded : " + strings["grade"];
					let diffsh4 = document.createElement('h4');
						if( strings["difficulty"] != null)
							diffsh4.innerHTML = "Difficulties : " + strings["difficulty"];

					let content = document.createElement('p');
						content.innerHTML = workshop['content'];

					workshop_div.appendChild(name);
					workshop_div.appendChild(botsh4);
					workshop_div.appendChild(gradesh4);
					workshop_div.appendChild(diffsh4);
					workshop_div.appendChild(content);
				node.appendChild(workshop_div);
		},

	});
}

const openBadge = ($id) =>
{
	$.ajax({
		type: "POST",
		url:'ajax/badges-ajax.php',
		data:
		 {
			'id':$id
		 },
		dataType: 'json',
		success: function( data ) {
			badge = data["badge"];
			console.log(badge);

			let node = document.getElementById('modal_content');
				node.innerHTML = "";
				let badge_div = document.createElement('div');
					badge_div.setAttribute('class','badges-infos');

					loadMedia(badge,badge_div);

					let name = document.createElement('h2');
						name.innerHTML = badge['name'];



						badge_div.appendChild(name);
				node.appendChild(badge_div);
		},

	});
}