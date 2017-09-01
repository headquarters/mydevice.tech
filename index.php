<?php
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>My Machine Info</title>
    <style>
      [v-cloak] {
        display: none;
      }
    </style>
  </head>

  <body>
    <div id="app" v-cloak>
      <p>IP Address: <?php echo (!empty($_SERVER['HTTP_CLIENT_IP'])) ? 
                              $_SERVER['HTTP_CLIENT_IP'] : 
                              (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? 
                              $_SERVER['HTTP_X_FORWARDED_FOR'] : 
                              (!empty($_SERVER['REMOTE_ADDR']) ? 
                              $_SERVER['REMOTE_ADDR'] : '')) ?>
      <p>Full screen width: {{ fullScreenWidth }}</p>
      <p>Full screen height: {{ fullScreenHeight }}</p>
      <p>Current screen width: {{ screenWidth }}</p>
      <p>Current screen height: {{ screenHeight }}</p>
      <p>Battery: <battery></battery></p>
    </div>

    <script src="https://unpkg.com/vue@2.4.2/dist/vue.js"></script>
    <script>
      // Vue.component('battery', function(resolve, reject) {
      //   navigator.getBattery()
      //     .then(function(battery) {
      //       resolve({
      //         template: '{{ battery.charging }}'
      //       });
      //     });
      // });

      new Vue({
        el: '#app',
        data: {
          screenWidth: window.innerWidth,
          screenHeight: window.innerHeight,
          fullScreenWidth: screen.width,
          fullScreenHeight: screen.height,          
          cookiesEnabled: navigator.cookieEnabled,
          userAgent: navigator.userAgent
        },
        components: {
          battery: function(resolve, reject) {
            navigator.getBattery()
              .then(function(battery) {
                resolve({
                  data: function() {
                    return {
                      charging: battery.charging ? 'charging' : 'not charging',
                      level: Number(battery.level) * 100
                    };
                  },
                  template: '<span>{{ level }}% charged ({{ charging }})</span>'
                });
              },
              function(err) {
                reject(err);
              });
          }
          // 'battery': {
          //   template: '<div>blah</div>'
          // }
        }
      });     

    </script>
  </body>
</html>