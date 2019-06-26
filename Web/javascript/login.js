//FB FUNCtiONS
const onPageLoad = () =>
{
	FB.Event.subscribe('xfbml.render', finished_rendering);

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
		formData.append('password', null);
		formData.append('password_confirm',null);
		formData.append('type', "Facebook");
		formData.append('isLoggedIn', true);
		fetch("login-ajax.php", {
			method: "POST",
			credentials: 'include', // Pour envoyer les cookies avec la requête!
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			if (typeof data === 'string' || data instanceof String)
			{
				console.log(data);
			}
			else
			{
				if(data === true)
				{
					window.location = 'users.php';
				}
				else
				{
					console.log(data);
				}
			}
		})
		});
}
//FACEBOOK FUNCTIONS
var finished_rendering = function() {
	var spinner = document.getElementById("spinner");
	if(spinner.childNodes.length>1)
	{
		spinner.removeAttribute("style");
		spinner.removeChild(spinner.childNodes[0]);
	}
	console.log("finished");
}

//GOOGLE FUNCTIONS

function onSignIn(googleUser) {

	let profile = googleUser.getBasicProfile();

	let formData = new FormData();
	formData.append('name', profile.getName());
	formData.append('email', profile.getEmail());
	formData.append('password', null);
	formData.append('password_confirm',null);
	formData.append('type', "Google");
	formData.append('isLoggedIn', true);

	fetch("login-ajax.php", {
		method: "POST",
		credentials: 'include', // Pour envoyer les cookies avec la requête!
		body: formData
	})
	.then(response => response.json())
	.then(data => {
		if (typeof data === 'string' || data instanceof String)
			{
				console.log(data);
			}
			else
			{
				if(data === true)
				{
					window.location = 'users.php';
				}
				else
				{
					console.log(data);
				}
			}
	})

}