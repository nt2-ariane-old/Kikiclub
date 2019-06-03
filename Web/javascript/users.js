import wixUsers from 'wix-users';

let email = $w("#email");
let password = $w("#password");

wixUsers.login(email, password)
  .then( () => {
    console.log("User is logged in");
  } )
  .catch( (err) => {
    console.log(err);
  } );