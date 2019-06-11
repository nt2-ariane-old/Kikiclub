//FB FUNCtiONS

const checkLoginState = () =>
{
	FB.getLoginStatus((response) => {
		statusChangeCallback(response);
	});
}

const statusChangeCallback = response => {
    if (response.status === 'connected') {
      signInFacebook();
    }
}

let finished_rendering = function() {
  let spinner = document.getElementById("spinner");
  spinner.removeAttribute("style");
  spinner.removeChild(spinner.childNodes[0]);
}

function signInFacebook() {

	FB.api('/me',  { locale: 'tr_TR', fields: 'name, email' },
	 response => {
		let formData = new FormData();
		formData.append('name', response.name);
		formData.append('email', response.email);
		formData.append('isLoggedIn', true);
		console.log(response);
		fetch("login-ajax.php", {
			method: "POST",
			credentials: 'include', // Pour envoyer les cookies avec la requête!
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			console.log(data);
			if(data == true)
			{
				window.location = "users.php";
			}
		})
    });
}
//GOOGLE FUNCTIONS

function onSignIn(googleUser) {

	let profile = googleUser.getBasicProfile();
	console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.

	let formData = new FormData();
	formData.append('name', profile.getName());
	formData.append('email', profile.getEmail());
	formData.append('isLoggedIn', true);

	fetch("login-ajax.php", {
		method: "POST",
		credentials: 'include', // Pour envoyer les cookies avec la requête!
		body: formData
	})
	.then(response => response.json())
	.then(data => {
		console.log(data);
		if(data == true)
		{
			window.location = "users.php";
		}
	})

}