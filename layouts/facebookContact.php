 <!-- Load Facebook SDK for JavaScript -->
 <div id="fb-root"></div>
 <script>
   window.fbAsyncInit = function() {
     FB.init({
       xfbml: true,
       version: 'v4.0'
     });
   };

   (function(d, s, id) {
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) return;
     js = d.createElement(s);
     js.id = id;
     js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
 </script>

 <!-- Your customer chat code -->
 <div 
 class="fb-customerchat" 
 attribution=setup_tool 
 page_id="100996911286297" 
 logged_in_greeting="Hi! You Can Chat With Our Support Team Using Your Facebook Account." 
 logged_out_greeting="Hi! Please Log Into Your Facebook Account To Get Live Support." 
 greeting_dialog_display="hide" 
 theme_color="#009385">
 </div>