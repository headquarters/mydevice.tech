<!doctype html>
<html lang="en">
  <head>
    <title>My Device Info</title>
    <meta name="description" content="View your device's IP address, screen size, browser size, and battery information.">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
      body {
        margin: 1.25rem;
        font-family: sans-serif;
      }

      h1 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: normal;
      }

      p {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
        overflow-wrap: break-word;
      }

      section {
        padding: 1.25rem;
        border: 1px solid #ccc;
        margin-bottom: 20px;
      }

      footer {
        text-align: center;
        font-size: 0.8rem;
        color: #777;
        margin-top: 20px;
      }

      .header {
        text-align: center;
        margin-bottom: 20px;
      }

      .header__title {
        margin: 0;
        font-weight: bold;
      }

      .full-section { 
        margin-bottom: 20px;
      }

      @media (min-width: 760px) {
       #svelte-app {
          display: grid;
          grid-template-columns: 32% 32% 32%;
          grid-template-rows: auto;
          justify-content: space-between;
        }

        section {
          margin: 0;
        }
      }
    </style>
  </head>

  <body>
    <header class="header">
      <h1 class="header__title">My Device Info</h1>
    </header>

    <main id="app">
      <section class="full-section">
        <h1>IP Address</h1>
        <p>  
            <?php 
              echo (!empty($_SERVER['HTTP_CLIENT_IP'])) ? 
                $_SERVER['HTTP_CLIENT_IP'] : 
                (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? 
                $_SERVER['HTTP_X_FORWARDED_FOR'] : 
                (!empty($_SERVER['REMOTE_ADDR']) ? 
                $_SERVER['REMOTE_ADDR'] : ''));
            ?>
        </p>
      </section>
      <div id="svelte-app"></div>
    </main>

    <footer>
      A simple <a href="https://svelte.technology">svelte</a> app by <a href="http://michaelehead.com">Michael Head</a>
    </footer>

    <script src="./App.js"></script>
    <script>
      // https://davidwalsh.name/javascript-debounce-function
      function debounce(func, wait, immediate) {
        var timeout;
        return function() {
          var context = this, args = arguments;
          var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
          };
          var callNow = immediate && !timeout;
          clearTimeout(timeout);
          timeout = setTimeout(later, wait);
          if (callNow) func.apply(context, args);
        };
      };      

      var app = new App({
        target: document.querySelector('#svelte-app'),
        data: {
          screenWidth: document.documentElement.clientWidth,
          screenHeight: document.documentElement.clientHeight,
          fullScreenWidth: screen.width,
          fullScreenHeight: screen.height,          
          cookiesEnabled: navigator.cookieEnabled,
          userAgent: navigator.userAgent
        }
      });
      
      var getWindowWidth = debounce(function() {
        var screenWidth = document.documentElement.clientWidth;

        app.set({
          screenWidth: screenWidth
        });
      }, 100);
      
      var getWindowHeight = debounce(function() {
        var screenHeight = document.documentElement.clientHeight;

        app.set({
          screenHeight: screenHeight
        });
      }, 100);

      window.addEventListener('resize', getWindowWidth);
      window.addEventListener('resize', getWindowHeight);

      if ("getBattery" in navigator) {
        navigator.getBattery()
          .then(function(battery) {
            var batteryMessage = 'Charged: ' + Math.floor(Number(battery.level) * 100) + '<br /> Charging: ' + (battery.charging ? 'yes' : 'no');

            app.set({
              batteryMessage: batteryMessage
            });
          });
      } else {
        app.set({
          batteryMessage: 'Getting battery information is not supported in this browser.'
        });
      }   
    </script>
  </body>
</html>