#This is the readme.txt for multiloquent theme v7

[![Build Status](https://travis-ci.org/localhost8080/multiloquent.svg?branch=master)](https://travis-ci.org/localhost8080/multiloquent)

##Multiloquent html5 / bootstrap theme - 
 - a wordpress theme with 10 dynamic sidebars in various locations
 - using twitter bootstrap complete with yaarp related posts theme, 
 - dynamic top10 front page featured posts, fontawesome icons, 
 - category index page template, 
 - tag index page template and 4 post templates. 
 - Version 6.1.0 adds wordpress theme customisation API for theme colours and text colours. 
 - Version 6.4.0 adds support for custom header images
 - Version 7.0.0 adds support for bootswatch themes via the customisation panel
 - Version 7.1.0 adds a selector to switch between tags and excerpts in archives and the featured posts display

Multiloquent is responsive and uses bootstrap for interface elements.

 - Multiloquent is available [here](http://wordpress.org/themes/multiloquent)
 - Multiloquent has a [github repo](https://github.com/localhost8080/multiloquent)
 - Support questions should be submitted in the wordpress [multiloquent theme support site](http://wordpress.org/support/theme/multiloquent)

For the latest news / information on multiloquent theme, please check the [multiloquent blog](http://jonathansblog.co.uk/multiloquent-wordpress-theme)


##Multiloquent has support for custom header image
they are used as the post header image unless a featured image has been set against that post, in which case, the featured image is used

##Multiloquent now has a theme selector - as of v7.0.0
Using the wordpress customisation panel you can select between all of the themes from [bootswatch.com](bootswatch.com) 
and they will be applied to your site (aswell as the multiloqent theme and berebones bootstrap too)


##This theme has 10 widget areas:

1. sidebar top
2. mobile specific advert
3. non-mobile specific advert
4. sidebar middle
5. sidebar bottom
6. footer top left
7. footer top right
8. social media
9. footer bottom left
10. footer bottom right

##Wordpress menu:
Multiloquent has a slide-out sidebar with a built in search form and a wordpress menu 
(assigned in admin > appearance > menu) there are also 3 widget areas in this sidebar.

##Post tags:
These are bootstrap 'label' style buttons and will have different colours based on the total number 
of times the tag has been used across all posts / pages on your site.

##Customisation:
- Version 6.1.0 adds support for wordpress theme customisation API.
- Currently supports changing background, text and border colours of the main theme elements.
- Version 6.2 adds support for the main background colours and the slide-out sidebar menu.

##Featured Posts on homepage
The main slider on the homepage will use your top five posts (by views) if you have the [top10 plugin](http://wordpress.org/extend/plugins/top-10/) installed
otherwise it will use your 5 most recent as a fallback.

Multiloqient gets the image from the 'featured image' against the post if it exists, if it doesnt then it uses a default image.

##Category index page
category-index.php is a page template incase someone wants to make a page that displays 'all available categories in hierarchical order' 
- sort of a 'top level category page' - it only contains links to category archives.
to activate, simply make a page in your system and assign the category or tag template.

##Tag index page
tag-index.php is a page template incase someone wants to make a page that displays 'all available tags in alphabetical order' 
- sort of a 'top level tag page' - it only displays links to tag archives
to activate, simply make a page in your system and assign the category or tag template.

##Featured Images
Posts with a featured image display the featured image in the header of the site.

##Posts pages
Version 6.2 adds a 'featured posts' area under the main header that is shown on the posts.  
This shows 4 posts from the same data as the homepage slider.

##YARRP
Multiloquent has a theme for TW Recent Posts Widget '[yarpp](http://wordpress.org/extend/plugins/yet-another-related-posts-plugin/)' - yet another related posts plugin.
It will auto include the related posts in the post page if its installed.
[I suggest that you pick multiples of 3 for the number of related posts to show - 3 will be one row, 6 will be two rows]


##Jetpack sharing
Multiloquent has support for [jetpack](http://wordpress.org/extend/plugins/jetpack/) sharing plugins. 
[and puts them in the correct position in your post if you have it installed].

##There are 4 post template files included 
if you use [custom post template](http://wordpress.org/extend/plugins/custom-post-template/)

1. Default with comments at the right hand side in desktop (under the post in mobile)
2. Full width post with comments underneath
3. Adventures: this auto inserts a google map if your post is titled 'placeA to placeB'
  - eg 'Glasgow to London' will insert a google map with a route pre-selected - comments are disabled on this post template.
4. Full width post with no header image or footer
  - useful for creating these one-page full-width layouts


- Multiloquent is licenced under the GPLv3 - please see the included LICENCE file
- Multiloquent uses [bootstrap](http://getbootstrap.com) v3.0.4 - [Apache-20 Licence](http://www.apache.org/licenses/LICENSE-2.0)
- Multiloquent uses [font-awesome](http://fontawesome.io) - [SiL Open Font Licence](http://scripts.sil.org/OFL)
- Multiloquent uses styles from [bootswatch](http://bootswatch.com) - [MIT Licence](https://github.com/thomaspark/bootswatch/blob/gh-pages/LICENSE)