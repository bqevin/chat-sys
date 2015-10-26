var isFacebookConnected = 0;

window.fbAsyncInit = function() {
    FB.init({
      appId      : '1521659114714735', // App ID
      channelUrl : '', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });
    
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            // the user is logged in and has authenticated your
            // app, and response.authResponse supplies
            // the user's ID, a valid access token, a signed
            // request, and the time the access token 
            // and signed request each expire
            
            //userInfo.id = response.authResponse.userID;
            var accessToken = response.authResponse.accessToken;
            isFacebookConnected = 1;
        } else if (response.status === 'not_authorized') {
            // the user is logged in to Facebook, 
            // but has not authenticated your app
            isFacebookConnected = 0;
        } else {
            // the user isn't logged in to Facebook.
            isFacebookConnected = 0;
        }
    });
};

(function(d){
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
}(document));


$(window).load(function () 
{
    $('#LoginFB').click(function() {
        if(isFacebookConnected) {
            FB.api('/me', function(response) {
                userInfo = response;
                _facebook_connect();
            });
        } else {
            FB.login(function(response) {
                isFacebookConnected = 1;
                if (response.status == 'connected') {
                    FB.api('/me', function(response) {
                        userInfo = response;
                        _facebook_connect();
                    });
                    
                }
            }, {scope: 'email'});
        }
        return false;
    });
    
    function _facebook_connect() {
        $.ajax(
        {
            url: '/social_network/facebook/connect.php',
            type: 'POST',
            dataType: 'json',
            data: { 
                'login': userInfo.first_name+' '+userInfo.last_name,
                'email': userInfo.email,
                'facebookId': userInfo.id
            }
        })
        .done(function(data)
        {
            location.reload();
        })
        .fail(function(jqXHR, textStatus)
        {
        });// .ajax()
    }
});