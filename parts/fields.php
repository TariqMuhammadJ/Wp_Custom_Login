<?

/*echo '<pre>'; print_r($field); echo '</pre>';
echo print_r($options);
*/

if (!$field) {
    echo '<p style="color:red;">Field data missing!</p>';
    return;
}


$id = $field['id'];
$type = $field['type'];
$title = $field['title'];
$value = isset($options[$id]) ? esc_attr($options[$id]) : '';

switch($type){
    case 'login_logo' : 
        echo "<p class='setting_title'>$title</p>";
        echo "<input type='text' id='{$id}' name='{$field['option_name']}[$id]' value='$value' class='regular-text' />";
        echo '<input type="button" class="button select-media-button" value="Select Image" />';
        if ($value) {
            echo '<img src="' . esc_url($value) . '" style="max-height: 80px; margin-left: 10px;">';
        }
        break;
    case 'bg_image' : 
        echo "<p class='setting_title'>$title</p>";
        echo "<input type='text' id='{$id}' name='{$field['option_name']}[$id]' value='$value' class='regular-text' />";
        echo "<input type='button' class='button select-media-button' value='Select Image' />";
        if ($value) {
            echo '<img src="' . esc_url($value) . '" style="max-height:80px; margin-left:10px;" />';
        }
        break;
    case 'background-color' :
    case 'form_color':
        echo "<p class='setting_title'>$title</p>";
        echo "<input type='text' name='{$field['option_name']}[$id]' id='accent_color' value='$value' class='my-color-field' 
        data-default-color='#ff6600' />";
        break;
    
    case 'recaptcha_secret_key' :
    case 'recaptcha_key':
         echo "<input type='text' name='{$field['option_name']}[$id]' id='{$id}' value='$value' class='regular-text' />";
         break;

    /*default:
        echo "Hello World";
        */





}

/*elseif ($field['type'] === 'form_color') {
        echo "<p class='setting_title'>$title</p>";
        echo "<select name='form_color_options[$id]' id='{$id}'>";
        $colors = [
            '' => 'Select Color',
            '#ffffff' => 'White',
            '#f1f1f1' => 'Light Gray',
            '#000000' => 'Black',
            '#0073aa' => 'WordPress Blue',
            '#ff6600' => 'Orange',
        ];
        foreach ($colors as $color_value => $label) {
            $selected = selected($value, $color_value, false);
            echo "<option value='" . esc_attr($color_value) . "' $selected>$label</option>";
        }
        echo "</select>";
    }
    */
    