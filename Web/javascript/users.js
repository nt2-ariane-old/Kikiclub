const onPageLoad = () =>
{
	$( "#datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1900:2019",
		dateFormat: 'dd/mm/yy'
	  });
}

const loadChildren = (state = "normal") => {

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
			node.querySelector(".child-nbalert").style.display = 'none';

			node.querySelector(".child-nbPTS").innerHTML = family[i]["score"] + " points cumulated";

			let count = 0;
			console.log( )
			for (const key in family[i]["workshops"]) {
				if (family[i]["workshops"].hasOwnProperty(key)) {
					const element = family[i]["workshops"][key];
					if(element["STATUT"]==2)
					{
						count++;
						console.log(count);
					}
				}
			}

			node.querySelector(".child-nbWorkshops").innerHTML = count + " workshops completed";

			let birth = new Date(family[i]["birthday"]);
			let today = new Date();
			let age = Math.floor(new Date( today.getTime() - birth.getTime()) / one_year);

			node.querySelector(".child-age").innerHTML = age + " years old";

			document.getElementById("family").appendChild(node);

			console.log();
		}
	})

}

const addManageButton = (node,member) => {
	node.querySelector(".child-stateLogo").style = "background-image: url(images/tool.png);";
	node.querySelector("a").href = "?mode=modify&member=" + member["ID"];

	node.querySelector(".child-stateLogo").style.display = 'block';
}
