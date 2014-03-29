#This is the readme.txt for multiloquent theme v6

Multiloquent is responsive.

##This theme has 10 widget areas:

    1 sidebar top
    2 mobile specific advert
    3 non-mobile specific advert
    4 sidebar middle
    5 sidebar bottom
    6 footer top left
    7 footer top right
    8 social media
    9 footer bottom left
    10 footer bottom right

##Wordpress menu:
    Multiloquent has a slide-out sidebar with a built in search form and a wordpress menu 
    (assigned in admin > appearance > menu) there are also 3 widget areas in this sidebar.

##Post tags:
    These are bootstrap 'label' style buttons and will have different colours based on the total number 
    of times the tag has been used across all posts / pages on your site.

##Customisation:
    Version 6.1.0 adds support for wordpress theme customisation API.
    Currently supports changing background, text and border colours of the main theme elements.
    Version 6.2 adds support for the main background colours and the slide-out sidebar menu.

##Featured Posts on homepage
    The main slider on the homepage will use your top five posts (by views) if you have the top10 plugin installed
    otherwise it will use your 5 most recent as a fallback.
    http://wordpress.org/extend/plugins/top-10/
    Multiloqient gets the image from the 'featured image' against the post if it exists,
    if it doesnt then it uses a default image.

##Category index page
    category-index.php is a page template incase someone wants to make a page that displays 
    'all available categories in hierarchical order' - sort of a 'top level category page' 
    - it only contains links to category archives.

##Tag index page
    tag-index.php is a page template incase someone wants to make a page that displays 
    'all available tags in alphabetical order' - sort of a 'top level tag page' - it only displays links to tag archives
    to activate these, simply make a page in your system and assign the category or tag template.

##Featured Images
    Posts with a featured image display the featured image in the header of the site.

##Posts pages
    Version 6.2 adds a 'featured posts' area under the main header that is shown on the posts. 
    This shows 4 posts from the same data as the homepage slider.

##YARRP
    Multiloquent has a theme for TW Recent Posts Widget 'yarpp' - yet another related posts plugin.
    It will auto include the related posts in the post page if its installed.
    [I suggest that you pick multiples of 3 for the number of related posts to show - 3 will be one row, 6 will be two rows]
    http://wordpress.org/extend/plugins/yet-another-related-posts-plugin/

##Jetpack sharing
    Multiloquent has support for jetpack sharing plugins. 
    [and puts them in the correct position in your post if you have it installed].
    http://wordpress.org/extend/plugins/jetpack/

##There are 3 post template files included if you use http://wordpress.org/extend/plugins/custom-post-template/
    1 Default with comments at the right hand side in desktop (under the post in mobile)
    2 Full width post with comments underneath
    3 Adventures: this auto inserts a google map if your post is titled 'placeA to placeB'
        eg 'Glasgow to London' will insert a google map with a route pre-selected - comments are disabled on this post template.


Multiloquent is licenced under the GPLv3 - please see the included LICENCE file
Multiloquent uses bootstrap: http://getbootstrap.com v3.0.4 - Apache-20 Licence http://www.apache.org/licenses/LICENSE-2.0
Multiloquent uses font-awesome: http://fontawesome.io - SiL Open Font Licence http://scripts.sil.org/OFL
