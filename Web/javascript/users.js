let previousState = "manage";
let states = ["normal","manage"]
let one_year=1000*60*60*24*365;

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

	fetch("family-ajax.php", {
		method: "POST",
		credentials: 'include',
		body: formData
	})
	.then(response => response.json())
	.then(data => {
		let family = data["family"];
		let avatars = data["avatars"]
		addNewMember(container);

		for (let i = 0; i < family.length; i++) {
			addMember(family[i], memberHTML,container,state, avatars);
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
	node.querySelector('a').href = "workshops.php?member=" +member["id"];
	if(state==="manage")
	{
		addManageButton(node,member );
	}

	node.querySelector(".child-name").innerHTML = member["firstname"];
	console.log(member["alert"].length);
	if(member["alert"].length > 0)
	{
		node.querySelector(".child-nbalert").style.display = 'block';
		node.querySelector(".child-nbalert").innerHTML = member["alert"].length;

	}
	else
	{
		node.querySelector(".child-nbalert").style.display = 'none';
	}

	node.querySelector(".child-nbPTS").innerHTML = member["score"] + " points cumulated";

	let count = 0;
	for (const key in member["workshops"]) {
		if (member["workshops"].hasOwnProperty(key)) {
			const element = member["workshops"][key];
			if(element["STATUT"]==2)
			{
				count++;
			}
		}
	}

	node.querySelector(".child-nbWorkshops").innerHTML = count + " workshops completed";

	let birth = new Date(member["birthday"]);
	let today = new Date();
	let age = Math.floor(new Date( today.getTime() - birth.getTime()) / one_year);

	node.querySelector(".child-age").innerHTML = age + " years old";

	container.appendChild(node);
}

const addNewMember = (container) => {
	let divNew = document.createElement('div');
	divNew.setAttribute('class','child-info');

	let aNew = document.createElement('a');
		aNew.href = "users.php?usermode=create";

		let divLogo = document.createElement('div');
			divLogo.setAttribute('class','child-logo');
			divLogo.setAttribute('id','addLogo');

		let h2Name = document.createElement('h2');
			h2Name.innerHTML = "Add Family Member";
			h2Name.setAttribute('class','child-name');


		aNew.appendChild(divLogo);
		aNew.appendChild(h2Name);
	divNew.appendChild(aNew);
	container.appendChild(divNew);
}
const addManageButton = (node,member) => {
	node.querySelector(".child-stateLogo").style = "background-image: url(images/tool.png);";
	node.querySelector("a").href = "users.php?usermode=modify&member=" + member["ID"];

	node.querySelector(".child-stateLogo").style.display = 'block';
}
