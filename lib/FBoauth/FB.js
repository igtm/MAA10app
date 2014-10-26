// JavaScript Document
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '784572941604163',
	  cookie     : true,
      xfbml      : true,
      version    : 'v2.1'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/ja_JP/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
     // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      login();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
    console.log('not_authorized');
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
    console.log('not logged into Facebook');
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }
function login() {
    console.log('ログイン成功');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
    });
  }
FB.getLoginStatus(function(response) {
  	statusChangeCallback(response);
});
