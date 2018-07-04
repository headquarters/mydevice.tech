# mydevice.tech

A simple [Svelte](https://svelte.technology) app that takes browser info and places it on screen. 
The single file is an index.html file served via nginx with server-side includes turned on for gathering the user's IP.
Client-side JavaScript gets info on screen size, browser size, battery level, and so on.

CSS grid is used for the layout with a media query to break the grid down into a single column on smaller devices. 

Everything is "inline" in a single file to minimize HTTP requests (except for pulling in App.js).  

## Building and running the Docker container
`docker build -t mysite .`

`docker run -p 80:80 -d mysite`

TODO:
* Add Google Analytics
* Small ad? Google or Carbon
* Git push for publishing to Webfaction