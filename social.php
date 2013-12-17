<section class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <div class="col-xs-4 col-sm-7 col-md-6 col-lg-6">
            <?php
// in here goes the jetpack plugin thing
if (function_exists('sharing_display')) {
    echo sharing_display();
}
?>
        </div>
        <div class="col-xs-6 col-sm-5 col-md-6 col-lg-6 sharing_buttons">
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=116601128380327";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <div class="fb-like" data-href="https://www.facebook.com/jonathansblog" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
            <a href="https://twitter.com/jonathans_blog" class="twitter-follow-button" data-show-count="true" data-show-screen-name="false">Follow @jonathans_blog</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-size="medium" data-href="https://plus.google.com/+JonathansblogCoUk"></div>
            <!-- Place this tag after the last +1 button tag. -->
            <script type="text/javascript">
              window.___gcfg = {lang: 'en-GB'};
            
              (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.google.com/js/platform.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
              })();
            </script>
        </div>
    </div>
</section>