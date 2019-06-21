const loadModules = () =>
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
     js.src = "https://connect.facebook.net/en_US/sdk.js?version=v3.3";
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
		appId      : '670117443417077',
		cookie     : true,
		xfbml      : true,
		version    : 'v3.3'
	});
	FB.AppEvents.logPageView();

	$( "#datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1900:2019",
		dateFormat: 'dd/mm/yy'
	  });
}

const openTab = (evt, tab) => {

	let tabcontent = document.querySelectorAll(".tabcontent");
	for ( let i = 0; i < tabcontent.length; i++) {
	  tabcontent[i].style.display = "none";
	}

	let tablinks = document.querySelectorAll(".tablinks");
	for ( let i = 0; i < tablinks.length; i++) {
	  tablinks[i].className = tablinks[i].className.replace(" active", "");
	}

	document.getElementById(tab).style.display = "block";
	evt.currentTarget.classList.add("active");

}
let closeProfilesBox = () =>
{
	let box = document.querySelector("#profile-box");
	box.style.display = "none";
}

let post = (path, params, method='post') => {
  const form = document.createElement('form');
  form.method = method;
  form.action = path;

  for (let key in params) {
    if (params.hasOwnProperty(key)) {
      const hiddenField = document.createElement('input');
      hiddenField.type = 'hidden';
      hiddenField.name = key;
      hiddenField.value = params[key];

      form.appendChild(hiddenField);
    }
  }

  document.body.appendChild(form);
  form.submit();
}

let clicked;
const openConfirmBox = (form) =>
{
	let confirmBox = document.createElement('div');
			confirmBox.setAttribute('class','alert alert-warning');
			confirmBox.setAttribute('id','confirm-box');

	let text = document.createElement('p');
			text.innerHTML = 'Are you sure you want to do this?';

	let yesBtn = document.createElement('button');
			yesBtn.onclick = () => {accept(form)};
			yesBtn.setAttribute('class','btn btn-success');
			yesBtn.innerHTML = "Yes";
			console.log(form);

	let noBtn = document.createElement('button');
			noBtn.setAttribute('onclick','refuse()');
			noBtn.setAttribute('class','btn btn-danger');
			noBtn.innerHTML = "No";

		confirmBox.appendChild(text);
		confirmBox.appendChild(yesBtn);
		confirmBox.appendChild(noBtn);

	document.getElementById("box").appendChild(confirmBox);

	return false;
}

const accept = (form) =>
{
	let typeInput = document.createElement('input');
			typeInput.type = 'hidden';
			typeInput.name = clicked;

	form.appendChild(typeInput)

	form.onsubmit = 'return true';
	form.submit();
}
const refuse = () =>
{
	let confirmBox = document.getElementById('confirm-box');
	confirmBox.parentElement.removeChild(confirmBox);

	return false;
}

const showProfiles = () =>
{
		 let node = document.getElementById("profile-box");
		 console.log(node);
		 node.style.display = "block";
}
function signOut() {
	let auth2 = gapi.auth2.getAuthInstance();
	auth2.signOut().then(function () {
	});

	if(FB.getLoginStatus() == 'connected')
	{
		FB.logout(function(response) {
			// Person is now logged out
		 });
	}

	window.location = "index.php?logout=true";

}



const sortingTable = (tableName,n) => {
  let table = document.getElementById(tableName);

	let switching = true;

  while (switching) {
		switching = false;

		tableRows = table.rows;


		for (let i = 1; i < tableRows.length - 1; i++) {
			const row1 = tableRows[i].querySelectorAll("TD")[n];
			const row2 = tableRows[i+1].querySelectorAll("TD")[n];

			if(row1.innerHTML.toLowerCase() > row2.innerHTML.toLowerCase())
			{
				tableRows[i].parentNode.insertBefore(tableRows[i + 1], tableRows[i]);
				switching = true;

			}
		}
	}
}