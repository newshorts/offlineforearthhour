<?php
    // personal
    $config = array(
        'appId'  => '317973431658835',
        'secret' => '48b84c2c44f6310765681e1e51a6aabd',
        'fileUpload' => true
    );

    if(strpos($_SERVER['SERVER_NAME'], "localhost") === false) {    
        // ofeh
        $config = array(
            'appId'  => '442992315782142',
            'secret' => '8a53612e97e70d7096628e1212829cd1',
            'fileUpload' => true
        );
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />

        <title>Facebook post to album</title>

        <meta name="description" content="" />
        <meta name="keywords" value="" />

        <link rel="stylesheet" href="css/style.css" type="text/css" />
    </head>
    <body>
        
        <!-- please include this anywhere on your page, it's invisible -->
        <div id="fb-root"></div>
        
        <div id="wrap">
            <button class="upload">Upload</button>
        </div>

        <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>
            
            window.fbAsyncInit = function() {
                // init the FB JS SDK
                FB.init({
                    appId      : <?php echo $config['appId']; ?>, // App ID from the App Dashboard
                    channelUrl : '//localhost.com/channel.html', // Channel File for x-domain communication
                    status     : true, // check the login status upon init?
                    cookie     : true, // set sessions cookies to allow your server to access the session?
                    xfbml      : true  // parse XFBML tags on this page?
                });
            };

            // Load the SDK's source Asynchronously
            (function(d, debug){
                var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement('script'); js.id = id; js.async = true;
                js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
                ref.parentNode.insertBefore(js, ref);
             }(document, /*debug*/ false));
            
            // init the special function to watch for they .upload button click
            (function($) {
                $(window).load(function() {
                    
                    $('.upload').on('connected', function() {
                        var cwd = window.location.protocol + '//' + window.location.host + window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/'))  
                        
                        setTimeout(function() {
                            $.get(cwd + "/upload/?upload=true", function(data) {
                                console.dir(data);

                                if(data.response == true) {
                                    alert('posted to your facebook profile!');
                                }

                            }, "json");
                        }, 500);
                        
                        console.log('triggered a response of connected')
                    });
                    
                    $('.upload').on('click', function(evt) {
                        
                        FB.getLoginStatus(function(response) {
                            if (response.status === 'connected') {
                                
                                $('.upload').trigger('connected');
                            } else if (response.status === 'not_authorized') {
                               
                                alert("You must authorize this app before we can post to your photo albums.");

                                FB.login(function(response) {
                                    console.log("reponse from login")
                                    console.dir(response)
                                    if (response.authResponse) {
                                        console.log('Welcome!  Fetching your information.... ');
                                        FB.api('/me', function(response) {
                                            console.log('response from /me')
                                            console.dir(response)
                                            console.log('Good to see you, ' + response.name + '.');
                                            $('.upload').trigger('connected');
                                        });
                                    } else {
                                        console.log('User cancelled login or did not fully authorize.');
                                    }
                                }, {scope: 'email,user_likes,publish_actions'});

                            } else {
                            
                                FB.login(function(response) {
                                    console.log("reponse from login")
                                    console.dir(response)
                                    if (response.authResponse) {
                                        console.log('Welcome!  Fetching your information.... ');
                                        FB.api('/me', function(response) {
                                            console.log('response from /me')
                                            console.dir(response)
                                            console.log('Good to see you, ' + response.name + '.');
                                            $('.upload').trigger('connected');
                                        });
                                    } else {
                                        console.log('User cancelled login or did not fully authorize.');
                                    }
                                }, {scope: 'email,user_likes,publish_actions'});

                            }
                            
                            console.dir(response)
                        });
                             
                    });
                });
            })(jQuery);
        </script>
    </body>
</html>

