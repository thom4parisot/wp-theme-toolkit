<?php
require_once dirname(__FILE__).'/functions.php';

abstract class BaseTheme
{
  public static $feed_patterns = array(
    'simple' => '<link rel="%rel%" href="%href%" />',
    'feed' =>   '<link rel="%rel%" title="%title%" type="%type%" href="%href%" />',
  );
  public static $feed_template = array('href' => '', 'rel' => 'alternate', 'type' => null, 'title' => null);
  public static $feed_template_keys = array('%href%', '%rel%', '%title%', '%type%');
  protected static $parent_theme = null;

  public static function getParentTheme()
  {
    return self::$parent_theme;
  }

  public static function getPathToTemplateFile($filename)
  {
    if (null === self::$parent_theme)
    {
      throw new Exception("No parent theme has been setup.");
    }
    
    return get_theme_root().'/'.self::$parent_theme.'/'.$filename;
  }
  
  /**
   * Generates title for the page
   *
   * @static
   * @author oncletom
   * @return string title
   */
  public function getTitle()
  {
    $title = wp_title('', false);

    return $title
      ? sprintf('%s - %s', $title, get_bloginfo())
      : get_bloginfo().' : '.get_bloginfo('description');
  }

  /**
   * Displays feeds
   *
   * Usual feeds can be displayed with
   * `automatic_feed_links(false);`
   * `automatic_feed_links(true);`
   *
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
  
  public static function setParentTheme($folder_name)
  {
    self::$parent_theme = $folder_name ? $folder_name : null;
  }
}