window.onload = () =>
{
	gapi.load('auth2', function(){
        /**
         * Retrieve the singleton for the GoogleAuth library and set up the
         * client.
         */
        auth2 = gapi.auth2.init({
            client_id: '704832246976-9gtrh525ke8s7p8kp9vatgals73l22ud.apps.googleusercontent.com'
        });

        // Attach the click handler to the sign-in button
        auth2.attachClickHandler('signin-button', {}, null, null);
	});


}
const signOut = () =>
{
	if(FB.getLoginStatus() == 'connected')
	{
		FB.logout(function(response) {
			// Person is now logged out
		 });
	}

	let auth2 = gapi.auth2.getAuthInstance();
	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			if (FB.getAccessToken() != null) {

				FB.logout(function(response) {

				});
			}
		}
	});

	//will not work from localhost
    auth2.signOut().then( () => {
		auth2.disconnect();
    });
	window.location = "index.php?logout=true";

}