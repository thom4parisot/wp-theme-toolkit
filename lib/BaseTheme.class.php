<?php
/**
 * Base theme class
 *
 * You just need to inherit from it to build your own themes easily
 *
 * @abstract
 * @author oncletom
 */
abstract class BaseTheme
{
  public static $feed_patterns = array(
    'simple' => '<link rel="%rel%" href="%href%" />',
    'feed' =>   '<link rel="%rel%" title="%title%" type="%type%" href="%href%" />',
  );
  public static $feed_template = array('href' => '', 'rel' => 'alternate', 'type' => null, 'title' => null);
  public static $feed_template_keys = array('%href%', '%rel%', '%title%', '%type%');
  protected $action, $filter;

  /**
   * Class factory
   *
   * @todo  instanciate Action and Filter through configuration
   * @static
   * @param string $name Name of the class to call
   * @param array $options
   */
  public static function createInstance($name = 'Theme', array $options = array())
  {
    $instance = new $name($options);

    return $instance;
  }

  /**
   * Retrieves the action class
   *
   * @return BaseThemeAction
   */
  public function getAction()
  {
    return $this->action;
  }

  /**
   * Retrieves the filter class
   *
   * @return BaseThemeFilter
   */
  public function getFilter()
  {
    return $this->filter;
  }

  /**
   * Displays feeds
   *
   * Usual feeds can be displayed with
   * `automatic_feed_links(false);`
   * `automatic_feed_links(true);`
   *
   * @todo move this in filter
   * @static
   * @author oncletom
   * @uses filter::get_feeds
   */
  public static function registerFeeds()
  {
    /*
     * Basic feeds
     */
    $feeds = array(
      array(
        'href' =>   get_bloginfo('pingback_url'),
        'rel' =>    'pingback',
      ),
      array(
        'href' =>   get_stylesheet_directory_uri().'/images/favicon.png',
        'rel' =>    'shortcut icon',
        'type' =>   'image/png',
      )
    );

    ksort(self::$feed_template_keys);
    foreach (apply_filters('get_feeds', $feeds) as $feed)
    {
      $feed = array_merge(self::$feed_template, $feed);
      ksort($feed);

      /*
       * Determining feed pattern
       */
      $type = 'feed';
      if (is_null($feed['title']) && is_null($feed['type']))
      {
        $type = 'simple';
      }

      echo str_replace(self::$feed_template_keys, $feed, self::$feed_patterns[$type])."\n";
    }
  }

  /**
   * Registers the ThemeAction class
   *
   * @param BaseThemeAction $instance
   */
  public function setThemeAction(BaseThemeAction $instance)
  {
    $this->action = $instance;
    $this->action->dispatch();
  }

  /**
   * Registers the ThemeFilter class
   *
   * @param BaseThemeFilter $instance
   */
  public function setThemeFilter(BaseThemeFilter $instance)
  {
    $this->filter = $instance;
    $this->filter->dispatch();
  }
}