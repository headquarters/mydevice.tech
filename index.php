<!doctype html>
<html lang="en">
  <head>
    <title>My Device Info</title>
    <meta name="description" content="View your device's IP address, screen size, browser size, and battery information.">
    <style>
      [v-cloak] {
        display: none;
      }

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
        grid-column: span 3;
      }

      @media (min-width: 760px) {
       #app {
          display: grid;
          grid-template-columns: 33% 33% 33%;
          grid-template-rows: auto;
          grid-gap: 20px;
          justify-content: space-around;
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

    <main id="app" v-cloak>
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
      <section>
        <h1>Screen Size</h1>
        <p>
          {{ fullScreenWidth }}px by {{ fullScreenHeight }}px
        </p>
      </section>
      <section>
        <h1>Browser Size</h1>
        <p>
          {{ screenWidth }}px by {{ screenHeight }}px
        </p>
      </section>
      <section>
        <h1>Battery</h1>
        <battery></battery>
      </section>
    </main>

    <footer>
      A simple <a href="https://vuejs.org/">Vue.js</a> app by <a href="http://michaelehead.com">Michael Head</a>
    </footer>

    <script src="https://unpkg.com/vue@2.4.2/dist/vue.min.js"></script>
    <script>
      new Vue({
        el: '#app',
        data: {
          screenWidth: document.documentElement.clientWidth,
          screenHeight: document.documentElement.clientHeight,
          fullScreenWidth: screen.width,
          fullScreenHeight: screen.height,          
          cookiesEnabled: navigator.cookieEnabled,
          userAgent: navigator.userAgent
        },
        created: function() {
          this.$nextTick(function() {
            window.addEventListener('resize', this.getWindowWidth);
            window.addEventListener('resize', this.getWindowHeight);
          });
        },
        methods: {
          getWindowWidth(event) {
            this.screenWidth = document.documentElement.clientWidth;
          },

          getWindowHeight(event) {
            this.screenHeight = document.documentElement.clientHeight;
          }
        },
        components: {
          battery: function(resolve, reject) {
            if ("getBattery" in navigator) {
              navigator.getBattery()
              .then(function(battery) {
                resolve({
                  data: function() {
                    return {
                      charging: battery.charging ? 'yes' : 'no',
                      level: Number(battery.level) * 100
                    };
                  },
                  template: '<p>Charged: {{ level }}% <br /> Charging: {{ charging }}</span></p>'
                });
              },
              function(err) {
                reject(err);
              });
            } else {
              resolve({
                  template: '<p>Getting battery information is not supported in this browser.</p>'
                });
            }
            
          }
        }
      });     

    </script>
  </body>
</html>