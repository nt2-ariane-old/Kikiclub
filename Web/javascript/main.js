window.onload = () =>
{
	gapi.load('auth2', function(){
        auth2 = gapi.auth2.init({
            client_id: '704832246976-9gtrh525ke8s7p8kp9vatgals73l22ud.apps.googleusercontent.com'
						//client_id: '704832246976-7qoem5fnkn8um3566973uoeg7pmpp3pv.apps.googleusercontent.com'
				});

        // Attach the click handler to the sign-in button
        auth2.attachClickHandler('signin-button', {}, null, null);
	});
	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "https://connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

}


const limitText = (limitField, limitNum) => {
	let node = document.getElementById("countdown");
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		let value =  (limitNum - limitField.value.length);
		node.innerHTML = value + "";
	}
}

window.fbAsyncInit = function() {
	FB.init({
		appId      : 670117443417077,
		cookie     : true,
		xfbml      : true,
		version    : 3.3
	});
	FB.AppEvents.logPageView();
}

const openTab = (evt, tab) => {

	let tabcontent = document.querySelectorAll(".tabcontent");
	for ( let i = 0; i < tabcontent.length; i++) {
	  tabcontent[i].style.display = "none";
	  console.log(tabcontent[i])
	}

	let tablinks = document.querySelectorAll(".tablinks");
	for ( let i = 0; i < tablinks.length; i++) {
	  tablinks[i].className = tablinks[i].className.replace(" active", "");
	  console.log(tablinks[i])
	}

	document.getElementById(tab).style.display = "block";
	evt.currentTarget.classList.add("active");

}

const signOut = () =>
{
	if(FB.getLoginStatus() == 'connected')
	{
		FB.logout(function(response) {
			// Person is now logged out
		 });
	}

	//will not work from localhost
	if(gapi.auth2 != null)
	{
		let auth2 = gapi.auth2.getAuthInstance();
		auth2.signOut().then( () => {
			auth2.disconnect();
		});
	}

	window.location = "index.php?logout=true";
}