# mydevice.tech

_This branch represents the original version of the app that was launched with Vue.js. The app has since been
rewritten to use [svelte](https://svelte.technology) for performance_

A simple Vue.js app that takes browser info and places it on screen. The single file is a PHP script but only uses PHP for getting 
the user's IP address. Client-side JavaScript gets info on screen size, browser size, battery level, and so on.

CSS grid is used for the layout with a media query to break the grid down into a single column on smaller devices. 

Everything is "inline" in a single file to minimize HTTP requests (except for pulling in Vue.js from a CDN).  

TODO:
* Add Google Analytics
* Small ad? Google or Carbon
* Git push for publishing to Webfaction