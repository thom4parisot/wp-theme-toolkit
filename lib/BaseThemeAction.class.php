<?php
/**
 * Base theme action class
 *
 * @abstract
 * @author oncletom
 */
abstract class BaseThemeAction
{
  protected $theme;
  public abstract function dispatch();

  /**
   * Enqueue javascripts for the theme
   *
   * Use as `add_action('wp', array('ThemeAction', 'loadJavascripts'));`
   *
   * @todo   update documentation, static call is not used anymore
   * @author oncletom
   */
  public function loadJavascripts()
  {
    //JS for threaded comments
    if (is_singular())
    {
      wp_enqueue_script('comment-reply');
    }
  }
}