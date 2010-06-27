<?php
/*
Plugin Name: Software Quotes Plugin
Plugin URI: http://softwarequotes.com/
Description: Random software, programming and computer quotes plugin that will display quotations on your wordpress blog.
Version: 1.0
Author: Hakon Agustsson
Author URI: http://www.SoftwareQuotes.com
*/
/*  Copyright 2010  Hakon Agustsson  (email : HakonAgustsson@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

error_reporting(E_ALL);

if (!class_exists("softwarequotes_widget")) {

   class softwarequotes_widget {
      public function softwarequotes_widget() { //constructor
      }

      public function control(){
         echo 'softwarequotes.com widget control panel';
      }

      public function widget($args){
         echo $args['before_widget'];
         echo $args['before_title'] . 'Software Quotes' . $args['after_title'];
         echo '<noscript>Your browser needs to support javascript to view Softwarequotes</noscript><div id=\'softwarequotes_quote\'>?</div><div id=\'softwarequotes_author\'>?</div>';
         echo $args['after_widget'];
      }

      public function softwarequotesjs ( ) {
/*          wp_enqueue_script( 'softwarequotesjs', path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )."/js/softwarequotes.js") );*/
        echo  '
<script type="text/javascript">
    function fnc(obj) {
       eval(\'var v=\'+obj.d);

       if (!v.Quote) 
          v.Quote = "?";

       if (!v.Author)
          v.Author = "?";

       document.getElementById(\'softwarequotes_quote\').innerHTML = v.Quote;
       document.getElementById(\'softwarequotes_author\').innerHTML = v.Author;

       document.getElementById(\'softwarequotes_author\').innerHTML = "<a href=\"http://www.softwarequotes.com/showquotes.aspx?id=" + v.Id + "\">- " + v.Author + "</a>"

    }
 </script>  
 <script type="text/javascript" src="http://api.softwarequotes.com/photoquotes.asmx/PhotoQuoteGetJson?callback=fnc"></script>';
      }

      public function register(){
         register_sidebar_widget('softwarequotes_widget', array(&$this, 'widget'));
         // callback is softwarequotes_widget::widget
         register_widget_control('softwarequotes_widget', array(&$this, 'control'));
         // callback is softwarequotes_widget::control
      }

   } // end class

}

if (class_exists("softwarequotes_widget")) {
   $softwarequotes_plugin = new softwarequotes_widget();
}

if (isset($softwarequotes_plugin)) {
   // Actions
   add_action('widgets_init', array(&$softwarequotes_plugin, 'register'));
   add_action('wp_footer', array(&$softwarequotes_plugin, 'softwarequotesjs'));

}

?>