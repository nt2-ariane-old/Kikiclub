
   //import wixUsers from 'wix-users-backend';
   //import wixUsers from 'wix-users';
window.onload = () =>
{
  let Url = 'https://kikinumerique.wixsite.com/kikiclubsandbox';
  let titleList = $.getJSON(Url);
  console.log(titleList);
}
const test = () => {

  console.log(testInfo)
}

function jsonp(url, params, callback){
  let script = document.createElement("script");
  script.setAttribute("src", url+'?'+params+'&callback='+callback);
  script.setAttribute("type","text/javascript");
  document.body.appendChild(script);
 }

const validateForm = () => {
  let form = document.forms["login"];
  let email = form["email"].value;
  let password = form["password"].value;


  //let email = $w("#email");
  //let password = $w("#password");

  wixUsers.login(email, password)
    .then( () => {
      console.log("User is logged in");
    } )
    .catch( (err) => {
      console.log(err);
    } );
}
