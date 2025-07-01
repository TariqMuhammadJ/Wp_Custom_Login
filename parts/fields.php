<?

echo '<pre>'; print_r($field); echo '</pre>';

if (!$field) {
    echo '<p style="color:red;">Field data missing!</p>';
    return;
}

//$options = get_query_var('args');
//$field = get_query_var('field');
$id = $field['id'];
        $type = $field['type'];
        $value = isset($options[$id]) ? esc_attr($options[$id]) : '';
        if ($type == 'login_logo') {
            echo "<input type='text' id='{$id}' name='custom_login_options[$id]' value='$value' class='regular-text' />";
            echo '<input type="button" class="button select-media-button" value="Select Image" />';
            if ($value) {
                echo '<img src="' . esc_url($value) . '" style="max-height: 80px; margin-left: 10px;">';
            }
        }
        elseif ($type == "bg_image") {
            echo "<input type='text' id='{$id}' name='custom_login_options[$id]' value='$value' class='regular-text' />";
            echo "<input type='button' class='button select-media-button' value='Select Image' />";
            if ($value) {
                echo '<img src="' . esc_url($value) . '" style="max-height:80px; margin-left:10px;" />';
            }
          
        }
        elseif($type == "background-color") {
            // Default input for background color or other fields
            echo "<input type='text' name='custom_login_options[$id]' id='accent_color' value='$value' class='my-color-field' 
            data-default-color='#ff6600' />";
        }
        else{
            echo "<input type='text' name='custom_login_options[$id]' id='{$id}' value='$value' class='regular-text' />";
        }


?>