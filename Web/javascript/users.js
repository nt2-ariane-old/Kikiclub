window.onload = () =>
{
	$( "#datepicker" ).datepicker();
}


const loadChildren = () => {

	let childHTML = document.querySelector("#child-template").innerHTML;
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
		for (let i = 0; i < family.length; i++) {

			console.log(family[i]);
			let node = document.createElement("div");
			node.innerHTML = childHTML;
			let id_logo =  family[i]["id_avatar"];
			for (x in avatars)
			{
				if(x == id_logo)
				{
					console.log(avatars[x])
					node.querySelector(".child-logo").style = "background-image: url(" + avatars[x]["PATH"] +");";
				}
			}


			node.querySelector(".child-name").innerHTML = family[i]["firstname"];
			node.querySelector(".child-nbalert").style.display = 'none';

			node.querySelector(".child-nbPTS").innerHTML = family[i]["score"] + " points cumulated";
			let birth = new Date(family[i]["birthday"]);
			let today = new Date();
			let age = (today-birth).getFullYear();

			node.querySelector(".child-age").innerHTML =age ;

			document.getElementById("family").appendChild(node);
		}
	})

}

const loadChildrenManage = () => {

	let childHTML = document.querySelector("#child-template").innerHTML;
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
		for (let i = 0; i < family.length; i++) {

			let one_day=1000*60*60*24;
			console.log(family[i]);
			let node = document.createElement("div");
			node.innerHTML = childHTML;
			let id_logo =  family[i]["id_avatar"];
			for (x in avatars)
			{
				if(x == id_logo)
				{
					console.log(avatars[x])
					node.querySelector(".child-logo").style = "background-image: url(" + avatars[x]["PATH"] +");";
				}
			}


			node.querySelector(".child-name").innerHTML = family[i]["firstname"];
			node.querySelector(".child-nbalert").style.display = 'none';

			node.querySelector(".child-nbPTS").innerHTML = family[i]["score"] + " points cumulated";
			let birth = new Date(family[i]["birthday"]);
			let today = new Date();
			let age = new Date(birth.getTime() - today.getTime());

			node.querySelector(".child-age").innerHTML =age ;

			document.getElementById("family").appendChild(node);
		}
	})

}