<!doctype html>
<html lang="en">
  <head>
    <title>My Machine Info</title>
    <style>
      [v-cloak] {
        display: none;
      }
      body {
        margin: 1.25rem;
        font-family: sans-serif;
      }

      h1 {
        margin: 0.25rem 0;
      }

      section {
        padding: 1.25rem;
        margin: 1rem 0;
        border: 2px solid lightgreen;
        background-color: palegreen;
      }

      footer {
        text-align: center;
        font-size: 0.8rem;
        color: #777;
      }
    </style>
  </head>

  <body>
    <header>
      <h1>My Machine Info</h1>
    </header>
    <main id="app" v-cloak>
      <section>
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
        <h1>Screen</h1>
        <p>
          Full screen width: {{ fullScreenWidth }}px <br />
          Full screen height: {{ fullScreenHeight }}px
        </p>
        <p>
          Current screen width: {{ screenWidth }}px <br />
          Current screen height: {{ screenHeight }}px
        </p>
      </section>
      <section>
        <h1>Battery</h1>
        <battery></battery>
      </section>
    </main>
    <footer>
      A simple <a href="https://vuejs.org/">VueJS</a> app by <a href="http://michaelehead.com">Michael Head</a>
    </footer>

    <script src="https://unpkg.com/vue@2.4.2/dist/vue.js"></script>
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
            navigator.getBattery()
              .then(function(battery) {
                resolve({
                  data: function() {
                    return {
                      charging: battery.charging ? 'yes' : 'no',
                      level: Number(battery.level) * 100
                    };
                  },
                  template: '<p>Charged: {{ level }}% <br /> Charging: {{ charging }}</span>'
                });
              },
              function(err) {
                reject(err);
              });
          }
        }
      });     

    </script>
  </body>
</html>