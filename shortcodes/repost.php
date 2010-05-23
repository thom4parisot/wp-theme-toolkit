<?php

/**
 *
 * @return
 * @param $attributes Object
 * @param $value Object[optional]
 */
function shortcode_repost($attributes, $value = null)
{
  extract(
    shortcode_atts(
      array(
        'from' => '',
        'sitename' => '',
        'sitename_prefix' => 'le blog de',
        'siteurl' => 'auto',
        'textpattern' => 'Ce billet a été initialement publié sur %sitename_prefix% <cite><a href="%siteurl%" rel="external">%sitename%</a></cite> dans <q><a href="%from%" rel="external">%title%</a></q>',
        'title' => '',
      ),
      $attributes
    )
  );

  /*
   * Site URL calculation
   */
  if ($siteurl == 'auto')
  {
    $siteurl = sprintf('http://%s/', parse_url($from, PHP_URL_HOST));
  }

  if (is_feed() || !$from || !$title || !$sitename || !$textpattern || !$siteurl || $siteurl == 'http:///')
  {
    return '';
  }

  $class = sanitize_title_with_dashes($sitename);

  return
    '<p class="repost '.$class.'">'.
      str_replace(
        array(
          '%from%',
          '%sitename%',
          '%sitename_prefix%',
          '%siteurl%',
          '%title%',
        ),
        array(
          $from,
          $sitename,
          $sitename_prefix,
          $siteurl,
          $title,
        ),
        $textpattern
      ).
    '</p>';
}


