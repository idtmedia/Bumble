<?php
$abspath = dirname(dirname(dirname(dirname(__FILE__))));
require_once($abspath.'/wp-config.php');
require_once(ABSPATH . 'wp-settings.php');

if ( !is_user_logged_in() )
{
	exit;
}
if(!class_exists('DHVCFormQuery')){
	require_once (DHVC_FORM_DIR.'/includes/db.php');
}
if(!function_exists('dhvc_form_is_xhr')){
	require_once (DHVC_FORM_DIR.'/includes/functions.php') ;
}

function outputCSV($data) {
	$outputBuffer = fopen("php://output", 'w');
	foreach($data as $val) 
	{
		fputcsv($outputBuffer, $val);
	}
	fclose($outputBuffer);
}

if ( isset($_GET['form_id']) && $_GET['form_id'] != '0' )
{
	$form_id = addslashes($_GET['form_id']);
	$forms = get_posts(array(
		'p'=>$form_id,
		'post_type'=>'dhvcform'
	));
	
	if (empty($forms))
	{
		echo "No submissions to export";
		exit;
	}
	
	global $dhvcform_db;
	foreach ($forms as $form){
		$form_control = get_post_meta($form->ID,'_form_control',true);
		if($form_control){
			$form_control_arr = $form_control;
			$entries = $dhvcform_db->get_entries($form->ID,'submitted','desc',0);
			$data_export_line=array();
			$data_export_title= array();
			$i=0;
			foreach ($entries as $i=>$entry){
				$entry_data = (array) maybe_unserialize($entry->entry_data);
				$j=0;
				$data_row=array();
				foreach ($form_control_arr as $control){
					if ($control['control_name'] !='' && $control['tag'] !='dhvc_form_recaptcha' && $control['tag'] != 'dhvc_form_captcha' && $control['tag'] != 'dhvc_form_submit_button'){
						$control_label = !empty($control['control_label']) ? $control['control_label'] : $control['control_name'];
						if(!in_array($control_label, $data_export_title)){
							$data_export_title[] = $control_label;
						}
						if(isset($entry_data[$control['control_name']])){
							$data_row[$j] = $entry_data[$control['control_name']];
						}else{
							$data_row[$j] = '';
						}
						$j++;
					}
				}
				array_unshift($data_row,$entry->form_url,mysql2date( 'd M Y (H:i)',$entry->submitted,true ));
				$data_export_line[$i] = $data_row;
				$i++;
			}
			array_unshift($data_export_title,'Location','Submitted');
			//export
			$data_export = $data_export_line;
			array_unshift($data_export,$data_export_title);
			$line = $data_export;
			$header = 'Form Submission Data';
			$file_name= sanitize_file_name(get_the_title($form->ID).'-Submissions.csv');
			header("content-type: text/csv;charset=UTF-8");
			header("Content-Disposition: attachment; filename=".$file_name);
			header("Pragma: no-cache");
			header("Expires: 0");
			$line = outputCSV($line);
		}
	}
}
?>