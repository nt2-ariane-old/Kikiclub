const onPageLoad = () =>
{

}

let previousState = "manage";
let states = ["normal","manage"]

const loadMembers = () => {
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
	let memberHTML = document.querySelector("#member-template").innerHTML;
	let container = document.getElementById("family");
	container.innerHTML = "";
	let formData = new FormData();

	fetch("ajax/family-ajax.php", {
		method: "POST",
		credentials: 'include',
		body: formData
	})
	.then(response => response.json())
	.then(data => {
		let family = data["family"];
		let avatars = data["avatars"]
		let length = 0;
		if(family != undefined)
		{
			length =  family.length;
		}
		for (let i=-1; i < length; i++) {
			let divCarouselItem;
				divCarouselItem = document.createElement('div');
				divCarouselItem.setAttribute('class','item');


						if(i==-1)
						{
							let divNewMember = document.createElement('div');
								divNewMember.setAttribute('class','member');
								addNewMember(divNewMember);
							divCarouselItem.appendChild(divNewMember);
						}
						else
						{
							let divMember = document.createElement('div');
								divMember.setAttribute('class','member');
								addMember(family[i], memberHTML,divMember,state, avatars);

							divCarouselItem.appendChild(divMember);
						}
				container.appendChild(divCarouselItem);
		}
		$('#family-carousel').multislider({
			interval:0,
		});

	})

}
const addMember = (member, memberHTML, container, state ,avatars) =>
{
	let node = document.createElement("div");
	node.innerHTML = memberHTML;
	let id_logo =  member["id_avatar"];
	node.querySelector(".member-logo").setAttribute('style', "background-image : url('" + avatars[id_logo]["media_path"] +"');");

	node.querySelector('.member-logo').setAttribute("onclick",'change_page("member-home.php",{"member_id":'+member["id"]+'})');


	node.querySelector('.member-stateLogo').setAttribute("onclick",'change_page("manage-member.php",{"member_id":'+member["id"]+',"members_action":"update"})');

	node.querySelector(".member-name").innerHTML = member["firstname"];
	if(member["alert"].length > 0)
	{
		node.querySelector(".member-nbalert").style.display = 'block';
		node.querySelector(".member-nbalert").innerHTML = member["alert"].length;

	}
	else
	{
		node.querySelector(".member-nbalert").style.display = 'none';
	}

	
	let count = 0;
	for (const key in member["workshops"]) {
		if (member["workshops"].hasOwnProperty(key)) {
			const element = member["workshops"][key];
			if(element["id_statut"]==3)
			{
				count++;
			}
		}
	}
	
	node.querySelector(".member-nbWorkshops").innerHTML = count + " " + read("users","nbWorkshops");
	node.querySelector(".member-nbPTS").innerHTML = member["score"] + " " + read("users","nbPts");
	
	container.appendChild(node);
}

const addNewMember = (container) => {
	let divNew = document.createElement('div');
	divNew.setAttribute('class','member-info');

	let linkNew = document.createElement('button');
		linkNew.setAttribute("onclick",'change_page("manage-member.php",{"members_action":"create"})');


		let divLogo = document.createElement('div');
			divLogo.setAttribute('class','member-logo');
			divLogo.setAttribute('id','addLogo');

		let h2Name = document.createElement('h2');
			h2Name.innerHTML = read("users","new");
			h2Name.setAttribute('class','member-name');


		linkNew.appendChild(divLogo);
		linkNew.appendChild(h2Name);
	divNew.appendChild(linkNew);
	container.appendChild(divNew);
}

const setManage = () => {
	let nodes = document.querySelectorAll(".member-stateLogo");

	nodes.forEach(node => {
		let type = node.style.display;
		if(type == "block")
		{
			node.style = "display:hidden;"
		}
		else
		{
			node.style.display = 'block';
		}
	});
}
