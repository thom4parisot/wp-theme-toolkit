<?php
abstract class BaseThemeAction
{
  /**
   * Enqueue javascripts for the theme
   *
   * Use as `add_action('wp', array('ThemeAction', 'loadJavascripts'));`
   *
   * @static
   * @author oncletom
   */
  public static function loadJavascripts()
  {
    //JS for threaded comments
    if (is_singular())
    {
      wp_enqueue_script('comment-reply');
    }
  }

  /**
   * Enqueue stylesheets for the theme
   *
   * Use as `add_action('wp', array('ThemeAction', 'loadStylesheets'));`
   *
   * @static
   * @author oncletom
   */
  public static function loadStylesheets()
  {
  }
}