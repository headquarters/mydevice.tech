# mydevice.tech

A simple [Svelte](https://svelte.technology) app that takes browser info and places it on screen. The single file is a PHP script but only uses PHP for getting 
the user's IP address. Client-side JavaScript gets info on screen size, browser size, battery level, and so on.

CSS grid is used for the layout with a media query to break the grid down into a single column on smaller devices. 

Everything is "inline" in a single file to minimize HTTP requests (except for pulling in App.js).  

TODO:
* Add Google Analytics
* Small ad? Google or Carbon
* Git push for publishing to Webfaction