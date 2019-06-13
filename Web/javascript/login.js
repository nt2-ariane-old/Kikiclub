//FB FUNCtiONS
const onPageLoad = () =>
{

}
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

function signInFacebook() {

	FB.api('/me',  { locale: 'tr_TR', fields: 'name, email' },
	 response => {
		let formData = new FormData();
		formData.append('name', response.name);
		formData.append('email', response.email);
		formData.append('isLoggedIn', true);
		fetch("login-ajax.php", {
			method: "POST",
			credentials: 'include', // Pour envoyer les cookies avec la requête!
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			if(data == true)
			{
				window.location = "users.php";
			}
		})
		});
		FB.Event.subscribe('xfbml.render', finished_rendering);

}
//FACEBOOK FUNCTIONS
var finished_rendering = function() {
  var spinner = document.getElementById("spinner");
  spinner.removeAttribute("style");
  spinner.removeChild(spinner.childNodes[0]);
}

//GOOGLE FUNCTIONS

function onSignIn(googleUser) {

	let profile = googleUser.getBasicProfile();

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
		if(data == true)
		{
			window.location = "users.php";
		}
	})

}