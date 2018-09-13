<?php

/* - WPML compatibility - */
if(defined('ICL_SITEPRESS_VERSION') && defined('ICL_LANGUAGE_CODE')) 
{
	if(!function_exists('pacz_wpml_language_switch'))
	{
		function pacz_wpml_language_switch()
		{
			$languages = icl_get_languages('skip_missing=0&orderby=id');
			$output = "";
			
			if(is_array($languages))
			{
				
	       		$output .= '<div class="pacz-language-nav"><a href="#"><i class="pacz-icon-globe"></i>'. esc_html__('Languages', 'classiadspro').'</a>';
				$output .= '<div class="pacz-language-nav-sub-wrapper"><div class="pacz-language-nav-sub">';
				$output .= "<ul class='pacz-language-navigation'>";	
				foreach($languages as $lang)
				{
					$output .= "<li class='language_".$lang['language_code']."'><a href='".$lang['url']."'>";
					$output .= "<span class='pacz-lang-flag'><img title='".$lang['native_name']."' src='".$lang['country_flag_url']."' /></span>";
					$output .= "<span class='pacz-lang-name'>".$lang['translated_name']."</span>";
					$output .= "</a></li>";
				}
				
				$output .= "</ul></div></div></div>";
			}
			
			echo '<div>'.$output.'</div>';
		}
	}	
}

