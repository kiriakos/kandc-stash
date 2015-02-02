# A filesystem based image gallery for the mobile web

* Completely file system based, no DB dependencies.
* Automatic image resizing.
* Minimal.
* Expandable.
* Mobile first.
* PHP based.
* Based on a weird configuration based DI container I dreamt
  up one night.
  
## Features:
* Discovers files on a given path.
* Automatically resizes images for best fit on the requesting 
  user agent. This is done at runtime via a javascript 
  directive which measures the viewport's width and requests
  an image with exactly that width.
* The UI is mobile agent oriented and touch friendly.
* The implementation is done in a DI container which I 
  devised one evening just to experiment with interface usage
  patterns. The system should be able to indefinately expand 
  if developers can get their head around the class, 
  dependency, config trinity.

## Usage:
* Load the contents of /app/ up to a web acessible directory 
  (does not need t be a webroot).
* Add files and folders to /app/assets.
* Make sure the apache process can write into /app/images and 
  /app/thumbnails
* Make sure mod_rewrite is enabled

## Notes:
* Use the deploy.sh script only from this directory.
* Use the deploy script only if you are kiriakos.
