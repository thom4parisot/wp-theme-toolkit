<?php
abstract class BaseThemeFilter
{
  /**
   * Removes pages from search
   *
   * @author oncletom
   * @return null
   * @param WP_Query $query
   */
  public static function refineSearchToPost(WP_Query $query)
  {
    if (!!$query->is_search)
    {
      $query->query_vars['post_type'] = 'post';
    }
  }

  /**
   * Generates a slug from a string, using iconv if possible
   *
   * @static
   * @author oncletom
   * @param string $string
   * @return string
   */
  public static function generateSlugFromString($string)
  {
    $string = strtolower($string);
    static $is_locale_set;

    if (!isset($is_locale_set) || !$is_locale_set)
    {
      setlocale(LC_CTYPE, 'fr_FR.utf-8', 'fr_FR', 'fr', 'french');
      $is_locale_set = true;
    }

    if (function_exists('iconv'))
    {
      $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
    }

    $string = preg_replace('#\W#U', ' ', $string);

    $string = trim($string);
    $string = str_replace(array('  ', ' '), '-', $string);

    return $string;
  }
}