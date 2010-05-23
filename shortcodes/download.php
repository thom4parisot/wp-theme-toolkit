<?php

/**
 * Download shortcode
 *
 * @author oncletom
 * @return string HTML representation of the shortcode
 * @param $attributes array
 * @param $value string[optional]
 */
function shortcode_download($attributes, $value = null)
{
  extract(
    shortcode_atts(
      array(
        'align' => 'center',
        'url' =>    '',
      ),
      $attributes
    )
  );

  if (is_feed() || !$value || !$url)
  {
    return '';
  }

  return str_replace(
    array(
      '%align%',
      '%url%',
      '%value%',
    ),
    array(
      $align,
      $url,
      $value,
    ),
    '<a href="%url%" class="download-link align%align%"><span>%value%</span></a>'
  );
}
