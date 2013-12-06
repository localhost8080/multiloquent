<script type="text/javascript">

/*function loadStyleSheet( path, fn, scope , media) {
   var head = document.getElementsByTagName( 'head' )[0], // reference to document.head for appending/ removing link nodes
       link = document.createElement( 'link' );           // create the link node
   link.setAttribute( 'href', path );
   link.setAttribute( 'rel', 'stylesheet' );
   link.setAttribute( 'type', 'text/css' );
   link.setAttribute('media', media)

   var sheet, cssRules;
// get the correct properties to check for depending on the browser
   if ( 'sheet' in link ) {
      sheet = 'sheet'; cssRules = 'cssRules';
   }
   else {
      sheet = 'styleSheet'; cssRules = 'rules';
   }

   var interval_id = setInterval( function() {                    // start checking whether the style sheet has successfully loaded
          try {
             if ( link[sheet] && link[sheet][cssRules].length ) { // SUCCESS! our style sheet has loaded
                clearInterval( interval_id );                     // clear the counters
                clearTimeout( timeout_id );
                fn.call( scope || window, true, link );           // fire the callback with success == true
             }
          } catch( e ) {} finally {}
       }, 10 ),                                                   // how often to check if the stylesheet is loaded
      timeout_id = setTimeout( function() {       // start counting down till fail
          clearInterval( interval_id );            // clear the counters
          clearTimeout( timeout_id );
          head.removeChild( link );                // since the style sheet didn't load, remove the link node from the DOM
          fn.call( scope || window, false, link ); // fire the callback with success == false
       }, 15000 );                                // how long to wait before failing

   head.appendChild( link );  // insert the link node into the DOM and start loading the style sheet

   return link; // return the link node;
}*/

/*function fire_the_css(){
	//loadStyleSheet( '<?php echo  get_template_directory_uri()  ; ?>/bootstrap/css/metro-bootstrap.css?v=<?php echo version();?>', '', this,'screen' );
	loadStyleSheet( '<?php echo  get_template_directory_uri()  ; ?>/styles/print.css', '', this,'print' );
	loadStyleSheet( '//fonts.googleapis.com/css?family=Abel', '', this, 'screen' );
}*/

var dfLoadStatus = 0;
var dfLoadFiles = [
      ["//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"],
      ["<?php echo get_template_directory_uri() ; ?>/bootstrap/js/bootstrap.min.js"]
     ];

function loadjs() {
    if (!dfLoadFiles.length) return;

    var dfGroup = dfLoadFiles.shift();
    dfLoadStatus = 0;

    for(var i = 0; i<dfGroup.length; i++) {
        dfLoadStatus++;
        var element = document.createElement('script');
        element.src = dfGroup[i];
        element.onload = element.onreadystatechange = function() {
        if ( ! this.readyState || 
               this.readyState == 'loaded' || 
               this.readyState == 'complete') {
            dfLoadStatus--;
            if (dfLoadStatus==0) loadjs();
        }
    };
    document.body.appendChild(element);
    
  }
  /*$("<link>")
	  .appendTo($('head'))
	  .attr({type : 'text/css', rel : 'stylesheet', media : 'screen'})
	  .attr('href', '<?php echo  get_template_directory_uri()  ; ?>/bootstrap/css/metro-bootstrap.css?v=<?php echo version();?>');
	
	$("<link>")
	  .appendTo($('head'))
	  .attr({type : 'text/css', rel : 'stylesheet', media : 'print'})
	  .attr('href', '<?php echo  get_template_directory_uri()  ; ?>/styles/print.css');
	
	$("<link>")
	  .appendTo($('head'))
	  .attr({type : 'text/css', rel : 'stylesheet'})
	  .attr('href', 'http://fonts.googleapis.com/css?family=Abel');
*/
}

if (window.addEventListener){
	//window.addEventListener("load", fire_the_css, false);
    window.addEventListener("load", loadjs, false);
}
else if (window.attachEvent){
	//window.attachEvent("onload", fire_the_css);
    window.attachEvent("onload", loadjs);
}
else {
	//window.onload = fire_the_css;
	window.onload = loadjs;
}
</script>
