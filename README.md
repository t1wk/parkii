# Parkii
**This commit is just the structural PHP for WordPress templating. No layout has been coded yet**

## How this works
This Github commits only the theme developped for Parkii. This version doesn't include the plugins yet. You need to download this theme in the wp-contents folder.

## Requirements
### WordPress
You need to have a clean installation of WorpPress in a local environment. 
After installation, change the value of line 80 to true of the file wp-config.php, as following:
```
define('WP_DEBUG', true);
```
It would serve development CSS and Js files, along with the Coming Soon page.

### Root files
This project uses classes that are required to be hosted at the root of the server. 
1. Copy the ```_root``` folder to the root of your local server (directly in the ```htdocs```)
2. Rename the folder ```_php```

### LESS CSS
This project uses LESS CSS through the LESSPHP class. No need to install a LESS Js Dependency

### Offline
A loop will be created soon to help you develop while being offline if needed (I see you, MTA)

## Usage
You need to be logged in to access the website. Use ```localhost/thenameofparkiidirectory/wp-admin```
