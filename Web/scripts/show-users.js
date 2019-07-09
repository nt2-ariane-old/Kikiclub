let previousState = "manage";
let states = ["normal","manage"]

const loadChildren = () => {

	let state;
	for (let i = 0; i < states.length; i++) {
		const element = states[i];
		if(element == previousState)
		{
			if(i == states.length - 1)
			{
				state = states[0];
				break;
			}
			else
			{
				state = states[i+1];
				break;
			}
		}
	}


	previousState = state;
	let memberHTML = document.querySelector("#child-template").innerHTML;
	let container = document.getElementById("family");
	container.innerHTML = "";
	let formData = new FormData();

	let nbMembers = 4;
	fetch("family-ajax.php", {
		method: "POST",
		credentials: 'include',
		body: formData
	})
	.then(response => response.json())
	.then(data => {
		let family = data["family"];
		let avatars = data["avatars"]

		for (let i=-1; i < family.length; i++) {
			let divCarouselItem = document.createElement('div');
			if(i==-1)
			{
				divCarouselItem.setAttribute('class','carousel-item active');
			}
			else
			{
				divCarouselItem.setAttribute('class','carousel-item');
			}
				let divContainer = document.createElement('div');
					divContainer.setAttribute('class','container');

					let divRow = document.createElement('div');
						divRow.setAttribute('class','row');

					let min = i;
					let max = i + nbMembers;

					for (let j = min; j < max && j < family.length; j++)
					{
						if(j==-1)
						{
							let divNewMember = document.createElement('div');
								divNewMember.setAttribute('class','col-sm-' + 12/nbMembers);
								addNewMember(divNewMember);
							divRow.appendChild(divNewMember);
						}
						else
						{
							let divMember = document.createElement('div');
								divMember.setAttribute('class','col-sm-' + 12/nbMembers);
								addMember(family[j], memberHTML,divMember,state, avatars);

							divRow.appendChild(divMember);
						}
						i = j;
					}
					divContainer.appendChild(divRow);
				divCarouselItem.appendChild(divContainer);
			container.appendChild(divCarouselItem);
		}

	})

}
const addMember = (member, memberHTML, container, state ,avatars) =>
{
	let node = document.createElement("div");
	node.innerHTML = memberHTML;
	let id_logo =  member["id_avatar"];
	for (x in avatars)
	{
		if(x == id_logo)
		{
			node.querySelector(".child-logo").style = "background-image: url(" + avatars[x]["PATH"] +");";
		}
	}
	node.querySelector('a').setAttribute("onclick",'post("member-home.php",{"member":'+member["id"]+'})');

	if(state==="manage")
	{
		addManageButton(node,member );
	}

	node.querySelector(".child-name").innerHTML = member["firstname"];
	if(member["alert"].length > 0)
	{
		node.querySelector(".child-nbalert").style.display = 'block';
		node.querySelector(".child-nbalert").innerHTML = member["alert"].length;

	}
	else
	{
		node.querySelector(".child-nbalert").style.display = 'none';
	}

	node.querySelector(".child-nbPTS").innerHTML = member["score"] + read("users","nbPts");

	let count = 0;
	for (const key in member["workshops"]) {
		if (member["workshops"].hasOwnProperty(key)) {
			const element = member["workshops"][key];
			if(element["STATUT"]==4)
			{
				count++;
			}
		}
	}

	node.querySelector(".child-nbWorkshops").innerHTML = count + read("users","nbWorkshops");

	let birth = new Date(member["birthday"]);
	let today = new Date();


	container.appendChild(node);
}

const addNewMember = (container) => {
	let divNew = document.createElement('div');
	divNew.setAttribute('class','child-info');

	let aNew = document.createElement('a');
		aNew.setAttribute("onclick",'post("users.php",{"action":"create"})');


		let divLogo = document.createElement('div');
			divLogo.setAttribute('class','child-logo');
			divLogo.setAttribute('id','addLogo');

		let h2Name = document.createElement('h2');
			h2Name.innerHTML = read("users","new");
			h2Name.setAttribute('class','child-name');


		aNew.appendChild(divLogo);
		aNew.appendChild(h2Name);
	divNew.appendChild(aNew);
	container.appendChild(divNew);
}
const addManageButton = (node,member) => {
	node.querySelector(".child-stateLogo").style = "background-image: url(images/tool.png);";
	node.querySelector('a').setAttribute("onclick",'post("users.php",{"member":'+member["id"]+',"action":"modify"})');
	node.querySelector(".child-stateLogo").style.display = 'block';
}
