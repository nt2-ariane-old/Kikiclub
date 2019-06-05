window.onload = () =>
{
	//isLoggedIn();
}

const loadChildren = () => {

	document.getElementById("container").innerHTML = "";

	let childHTML = document.querySelector("#child-template").innerHTML;
	let formData = new FormData();
	fetch("family-ajax.php", {
		method: "POST",
		credentials: 'include', // Pour envoyer les cookies avec la requête!
		body: formData
	  })
	  .then(response => {
		response.json()
		.then(function(data) {
			console.log(data);
			for (let i = 0; i < data.length; i++) {
				console.log(data[i]);
				let node = document.createElement("div");
				node.innerHTML = childHTML;

				node.querySelector(".child-name").innerHTML = data[i]["NAME"];
				node.querySelector(".child-score").innerHTML = data[i]["SCORE"];

				document.getElementById("container").appendChild(node);
			}
		});


	  }
	  )

}
//

const logIn = () => {
	let url = "https://kikinumerique.wixsite.com/kikiclubsandbox/_functions/loginUser"
	let formData = new FormData();
	formData.append('email', document.querySelector("#email").value);
	formData.append('password', document.querySelector("#password").value);
	let valide = false
	fetch(url, {
		async: true,
		crossDomain: true,
		method: "POST",
		credentials: 'include',
		mode: 'no-cors',
		body: formData,
		headers: {
			"Content-Type": "application/x-www-form-urlencoded",
			"Accept": "*/*",
			"Cache-Control": "no-cache",
			"Host": "kikinumerique.wixsite.com",
			"accept-encoding": "gzip, deflate",
			"cache-control": "no-cache"
		}
	})
	.then(data => {
		console.log(data)
	})
	.catch(function (err) {
		console.log(err);
	  });

	return valide;
}



const isLoggedIn = () => {
	let url = "https://kikinumerique.wixsite.com/kikiclubsandbox/_functions/isLoggedIn"
	let valide = false
	fetch(url, {
		async: true,
		crossDomain: true,
		method: "POST",
		credentials: 'include',
		mode: 'no-cors',
		headers: {
			"Content-Type": "application/json",
			"Accept": "*/*",
			"Cache-Control": "no-cache",
			"Host": "kikinumerique.wixsite.com",
			"accept-encoding": "gzip, deflate",
			"content-length": "101",
			"Connection": "keep-alive",
			"cache-control": "no-cache"
		}
	})
	.then(data => {
		console.log(data)
	})
	.catch(function (err) {
		console.log(err);
	  });

	return valide;
}
