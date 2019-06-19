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
	let childHTML = document.querySelector("#child-template").innerHTML;
	let parent = document.getElementById("family");
	parent.innerHTML = "";
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
		if(state==="manage")
		{
			addNewMember(parent);
		}
		for (let i = 0; i < family.length; i++) {

			let one_year=1000*60*60*24*365;
			let node = document.createElement("div");
			node.innerHTML = childHTML;
			let id_logo =  family[i]["id_avatar"];
			for (x in avatars)
			{
				if(x == id_logo)
				{
					node.querySelector(".child-logo").style = "background-image: url(" + avatars[x]["PATH"] +");";
				}
			}
			node.querySelector('a').href = "workshops.php?member=" +family[i]["id"];
			if(state==="manage")
			{
				addManageButton(node,family[i] );
			}

			node.querySelector(".child-name").innerHTML = family[i]["firstname"];
			console.log(family[i]["alert"].length);
			if(family[i]["alert"].length > 0)
			{
				node.querySelector(".child-nbalert").style.display = 'block';
				node.querySelector(".child-nbalert").innerHTML = family[i]["alert"].length;

			}
			else
			{
				node.querySelector(".child-nbalert").style.display = 'none';
			}

			node.querySelector(".child-nbPTS").innerHTML = family[i]["score"] + " points cumulated";

			let count = 0;
			for (const key in family[i]["workshops"]) {
				if (family[i]["workshops"].hasOwnProperty(key)) {
					const element = family[i]["workshops"][key];
					if(element["STATUT"]==2)
					{
						count++;
					}
				}
			}

			node.querySelector(".child-nbWorkshops").innerHTML = count + " workshops completed";

			let birth = new Date(family[i]["birthday"]);
			let today = new Date();
			let age = Math.floor(new Date( today.getTime() - birth.getTime()) / one_year);

			node.querySelector(".child-age").innerHTML = age + " years old";

			parent.appendChild(node);
		}
	})

}

const addNewMember = (parent) => {
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
		aNew.appendChild(divLogo);
	divNew.appendChild(aNew);
	parent.appendChild(divNew);
}
const addManageButton = (node,member) => {
	node.querySelector(".child-stateLogo").style = "background-image: url(images/tool.png);";
	node.querySelector("a").href = "users.php?usermode=modify&member=" + member["ID"];

	node.querySelector(".child-stateLogo").style.display = 'block';
}
