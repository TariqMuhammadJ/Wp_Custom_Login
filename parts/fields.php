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
    case 'bg_image':
    case 'form_bg':
        echo "<p class='setting_title'>$title</p>";
        echo "<input type='text' id='{$id}' name='{$field['option_name']}[$id]' value='$value' class='regular-text' />";
        echo '<input type="button" class="button select-media-button" value="Select Image" />';
          echo '<input type="button" class="button remove-media-button" value="Remove" style="margin-left:10px;" onclick="document.getElementById(\''.$id.'\').value=\'\'; this.nextElementSibling?.remove();">';
        if ($value) {
            echo '<img src="' . esc_url($value) . '" style="max-height: 80px; margin-left: 10px;">';
        }
        break;
 

    case 'background-color' :
    case 'form_color':
    case 'Input-Font-Color':
    case 'Label-User-Login' :
    case 'Button-Bg-Color' :
    case 'Bottom-Links':
        echo "<p class='setting_title'>$title</p>";
        echo "<input type='text' name='{$field['option_name']}[$id]' id='accent_color' value='$value' class='my-color-field' 
        data-default-color='' />";
        break;
    
    case 'recaptcha_secret_key' :
    case 'recaptcha_key':
         echo "<input type='text' name='{$field['option_name']}[$id]' id='{$id}' value='$value' class='regular-text' />";
         break;
    
    case 'font_size' : 
    case 'form_border':
        error_log($title);
        echo "<p class='setting_title'>{$title}</p>";
        echo "<input class='SliderInput' type='range' name='{$field['option_name']}[$id]' id='{$id}' min='1' max='100' value='{$value}'>";
        echo "<span id='SliderValueFont' data-for='{$id}'>{$value}</span>px";
        break;

    default:
        echo "<p class='setting_title'>$title</p>";
        echo "<input type='text' name='{$field['option_name']}[$id]' id='{$id}' value='$value' class='regular-text' />";
        break;
       





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
    