nanoGALLERY4GS for GetSimple
===========

Image gallery for GetSimple CMS.
A powerful and easy to setup GetSimple plugin for displaying image galleries, with support for pulling in Flickr and Picasa/Google+ photo albums. Mobile-friendly.
Images are shown as clickable thumbnails, which will expand to full view via a modal popup window. Support custom themes.

Key features
--------
- Display image galleries from multiple data sources
- Slideshow
- Quick and easy setup
- Automatic thumbnails
- Display image captions and descriptions
- Breadcrumb for easy navigation in Flickr photosets or Picasa/Google+ albums
- Multiple galleries on one page
- Include pre-built themes, support for custom themes
- Highly customizable 
- Responsive layout - mobile friendly
- Ignore desired albums or photosets (by keyword blacklisting)
- Bootstrap framework compatible
- Possible image sources :
  * Flickr account
  * Picasa/Google+ account

![Screenshot](/nanogallery3/doc/nanoGALLERY4GS_screenshot.png?raw=true "Screenshot")
![Screenshot](/nanogallery3/doc/nanoGALLERY4GS_screenshot3.png?raw=true "Screenshot")
![Screenshot](/nanogallery3/doc/nanoGALLERY4GS_screenshot2.png?raw=true "Screenshot")


Demonstration
-------------

[Go to the demonstration site](http://www.nanogallery4gs.brisbois.fr/)

Usage
-----

To display an image gallery insert a code like this one in a GetSimple page :

``` HTML
(%nanogallery userID=PicasaUserID%)
```

Replace PicasaUserID with your Picasa/Google+ user ID.

Note: syntax is case sensitive.

Example:

``` HTML
(%nanogallery userID1=cbrisbois@gmail.com%)
```


History:
-----

* v4.0.2 - new : 30 thumbnails animated hover effects (combinations possible) / display images faster (thanks to pre-loading) / Boostrap compatible
* v3.1.3 - new : built-in themes
* v3.1.2 - bug fix multiple galleries on one page, new : javascript is now a jQuery plugin
* v3.1.1 - bug fix for IE on Windows Phone (thanks Gregor!), new option to force load jQuery
* v3.1.0 - added support of Flickr
* v3.0.1 - first public release


Installation
-----
* The latest release is available for download on the GetSimple Homepage: [Go to](http://get-simple.info/extend/plugin/nanogallery/630/)
* Download the zip file.
* Extract the content of the zip file into the GetSimple 'plugins' directory.


Syntax and options
------------------
Arguments are separated by ```&```. Following arguments are supported 

### General arguments
* ```displayCaption``` : ```true``` / ```false``` - display or not the title of the images (optional)
* ```thumbnailHeight``` : integer - Height in pixels of the thumbnails (optional)
* ```thumbnailWidth``` : integer - Width in pixels of the thumbnails (optional)
* ```theme``` : name of the theme ```clean``` ```default``` (optional)
* ```thumbnailHoverEffect``` : 
   Possible values: `slideUp`, `slideDown`, `slideLeft`, `slideRight`, `imageSlideUp`, `imageSlideDown`, `imageSlideLeft`, `imageSlideRight`, `labelAppear`, `labelAppear75`, `labelSlideDown`, `labelSlideUp`, `labelOpacity50`, `imageOpacity50`, `borderLighter`, `borderDarker`, `imageInvisible`, `descriptionSlideUp`, `imageScale150`, `imageScale150Outside`, `scale120`, `overScale`, `overScaleOutside`, `scaleLabelOverImage`, `rotateCornerBR`, `rotateCornerBL`, `imageRotateCornerBR`, `imageRotateCornerBL`, `imageFlipHorizontal`, `imageFlipVertical`

### Picasa/Google+ specific arguments
* ```userID``` : user ID of the Picasa/Google+ account (mandatory)
* ```kind``` : ```picasa``` - set the storage type (mandatory)
* ```album``` : album ID - to display only the specified album 
* ```displayBreadcrumb``` : ```true``` / ```false``` - display or not the navigation breadcrumb
* ```blackList``` : list of keywords to ignore - album containing one the keyword in the title will be ignored. Keywords separator is `|`. (optional)
* ```whiteList``` : List of keywords to authorize - albums must contain one of the keywords to be displayed. Keywords separator is `|`. (optional)

### Flickr specific arguments
* ```userID``` : user ID of the Flickr account (mandatory)
* ```kind``` : ```flickr``` - set the storage type (mandatory)
* ```photoset``` : photoset ID - to display only the specified photoset 
* ```displayBreadcrumb``` : ```true``` / ```false``` - display or not the navigation breadcrumb
* ```blackList``` : list of keywords to ignore - photoset containing one the keyword in the title will be ignored. Keywords separator is `|`. (optional)
* ```whiteList``` : List of keywords to authorize - photoset must contain one of the keywords to be displayed. Keywords separator is `|`. (optional)

To retrieve your Flickr user ID, use this page:
```
http://www.flickr.com/services/api/explore/flickr.people.findByUsername
```


### Picasa/Google+ example:

Display albums from the user cbrisbois@gmail.com. Thumbnail size : 300x200 pixels.

```
(%nanogallery userID=cbrisbois@gmail.com&thumbnailWidth=300&thumbnailHeight=200%)
```

Display albums from the user cbrisbois@gmail.com. Thumbnail size : 300x200 pixels. Ignore album containing 'scrapbook' or 'profil' in the title.

```
(%nanogallery userID=cbrisbois@gmail.com&thumbnailWidth=300&thumbnailHeight=200&blackList=scrapbook|profil%)
```



### Flickr example:

Display albums from the user Kris_B (34858669@N00). Thumbnail size : 300x200 pixels.

```
(%nanogallery kind=flickr&userID=34858669@N00&thumbnailWidth=300&thumbnailHeight=200%)
```

Display albums from the user 34858669@N00. Thumbnail size : 300x200 pixels. Ignore album containing 'scrapbook' or 'profil' in the title.

```
(%nanogallery kind=flickr&userID=34858669@N00&thumbnailWidth=300&thumbnailHeight=200&blackList=scrapbook|profil%)
```


Debug mode
----------

To enable the debug mode:

* go to the GetSimple ```plugin``` directory
* rename the file ```nanogallery3_debug.off``` to ```nanogallery3_debug.on```

To disable the debug mode:

* go to the GetSimple ```plugin``` directory
* rename the file ```nanogallery3_debug.on``` to ```nanogallery3_debug.off```


Requirements
------------
* GetSimple CMS version 3.1 or superior
* Javascript must be enabled

Third party tools
-----------------
* jQuery
* fancybox2, credits: Janis Skarnelis


[![githalytics.com alpha](https://cruel-carlota.pagodabox.com/de295d45496c01bb871078aac2bcfcac "githalytics.com")](http://githalytics.com/Kris-B/nanoGALLERY)

