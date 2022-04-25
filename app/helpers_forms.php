<?php

    if (!function_exists('GFormOpen')){
        function GFormOpen($action, $method="POST", $options=[]) {
            $attributes = ' ';
            foreach ($options as $key => $val) {
                $attributes .= " " . $key . "=\"" . $val . "\"";
            }
            $html = "<form method=\"" . $method . "\" action=\"" . $action . "\"" . $attributes . " enctype=\"multipart/form-data\">\n";
            return $html;
        }
    } // GFormOpen

    if (!function_exists('GFormClose')){
        function GFormClose() {
            $html = "</form>\n";
            return $html;
        }
    } // GFormClose

    if (!function_exists('GFormSelectList')){
        function GFormSelectList($name, $listItems=[], $select="", $options=[]) {
            $select = GFormFieldValue($name, $select);
            $attributes = "";
            foreach ($options as $key => $val) {
                $attributes .= " " . $key . "=\"" . $val . "\"";
            }
            $html = "<select name=\"" . $name . "\" id=\"" . $name . "\"" . $attributes . ">\n";
            $selected = "";
            foreach ($listItems as $key => $val) {
                $selected = "";
                // force this as a string to compare apples with apples
                if ('x' . $select === 'x' . $key){
                    $selected = " selected";
                } else {
                    if ('x' . $select == 'x' and 'x' . $key == 'x' ) {
                        $selected = " selected";
                    }
                }
                $html .= "<option value=\"" . $key . "\" " . $selected . ">" . $val . "</option>\n";
            }
            $html .= "</select>\n";
            return $html;
        }
    } // GFormSelectList

    if (!function_exists('GFormCheckBox')){
        function GFormCheckBox($name, $checked=0, $options=[]) {
            // $checked = GFormFieldValue($name, $checked);
            $attributes = ' ';
            foreach ($options as $key => $val) {
                $attributes .= " " . $key . "=\"" . $val . "\"";
            }
            $html = "<input type=\"checkbox\" id=\"" . $name . "\" name=\"" . $name . "\"" . $attributes . ($checked?" checked":" ") . ">";
            return $html;
        }
    } // GFormCheckBox

    if (!function_exists('GFormFile')){
        function GFormFile($name, $options=[]) {
            $attributes = ' ';
            foreach ($options as $key => $val) {
                $attributes .= " " . $key . "=\"" . $val . "\"";
            }
            $html = "<input type=\"file\" id=\"" . $name . "\" name=\"" . $name . "\"" . $attributes . ">\n";
            $html .= "<script>\n";
            $html .= "$(\"#" . $name . "\" ).on(\"change\", function() {\n";
            $html .= "  var fileName = $(this).val().split(\"\\\\\").pop();\n";
            $html .= "  $(\"#label__" . $name . "\").addClass(\"selected\").html(fileName);\n";
            $html .= "});\n";
            $html .= "</script>\n";

            return $html;
        }
    } // GFormFile

    if (!function_exists('GFormText')){
        function GFormText($name, $value="", $options=[]) {
            return GFormInput($name, $value, "text", $options);
        }
    } // GFormText

    if (!function_exists('GFormTextArea')){
        function GFormTextArea($name, $value="", $options=[]) {
            $value = GFormFieldValue($name, $value);
            $attributes = "";

            foreach ($options as $key => $val) {
                $attributes .= " " . $key . "=\"" . $val . "\"";
            }

            $html = "<textarea name=\"" . $name . "\" id=\"" . $name . "\"" . $attributes . " cols=\"50\" rows=\"10\">" . $value . "</textarea>\n";
            return $html;
        }
    } // GFormTextArea

    if (!function_exists('GFormHidden')){
        function GFormHidden($name, $value="", $options=[]) {
            return GFormInput($name, $value, "hidden", $options);
        }
    } // GFormHidden

    if (!function_exists('GFormPassword')){
        function GFormPassword($name, $options=[]) {
            return GFormInput($name, "", "password", $options);
        }
    } // GFormPassword

    if (!function_exists('GFormSubmit')){
        function GFormSubmit($value, $options=[]) {
            $attributes = "";

            foreach ($options as $key => $val) {
                $attributes .= " " . $key . "=\"" . $val . "\"";
            }

            $html = "<button type=\"submit\" name=\"submit\" id=\"submit\" " . $attributes . ">" . $value . "</button>\n";
            return $html;
        }
    } // GFormSubmit

    if (!function_exists('GFormDelete')){
        function GFormDelete($value, $options=[]) {
            $attributes = "";
            foreach ($options as $key => $val) {
                $attributes .= " " . $key . "=\"" . $val . "\"";
            }
            $html = "<input type=\"submit\" name=\"delete\" id=\"delete\" value=\"" . $value . "\" " . $attributes . " onclick=\"return ConfirmDelete()\">\n";
            return $html;
        }
    } // GFormDelete

    if (!function_exists('GFormLabel')){
        function GFormLabel($name, $value="", $options=[]) {
            $attributes = "";
            foreach ($options as $key => $val) {
                $attributes .= " " . $key . "=\"" . $val . "\"";
            }
            $html = "<label id=\"label__" . $name . "\" for=\"" . $name . "\"" . $attributes . ">" . $value . "</label>\n";
            return $html;
        }
    } // GFormLabel

    if (!function_exists('GFormInput')){
        function GFormInput($name, $value="", $type="text", $options=[]) {
            $attributes = "";
            $value = GFormFieldValue($name, $value);

            foreach ($options as $key => $val) {
                $attributes .= " " . $key . "=\"" . $val . "\"";
            }
            if ($type == "password"){
                $vValue = "";
            } else {
                $vValue = " value=\"" . $value . "\"";
            }
            $html = "<input type=\"" . $type . "\" name=\"" . $name . "\" id=\"" . $name . "\" " . $vValue . $attributes . ">\n";
            return $html;
        }
    } // GFormInput

    if (!function_exists('GFormDateTimePicker')){
        function GFormDateTimePicker($name, $date_only=0) {
            $html  = "\n<script>\n";
            $html .= "  $( function() {\n";
            $html .= "    $( \"#" . $name . "\" ).datetimepicker({\n";
            if ($date_only){
                // date only (no time)
                $html .= "      timepicker:false,\n";
            }
            $html .= "      step: 15,\n";
            if ($date_only){
                $html .= "      format:'" . GC('DATEPICKER_FORMAT') . "',\n";
            } else {
                $html .= "      format:'" . GC('TIMEPICKER_FORMAT') . "',\n";
            }
            $html .= "    });\n";
            $html .= "  });\n";
            $html .= "</script>\n";
            return ($html);
        }
    } // GFormDateTimePicker

    if (!function_exists('GFormFieldValue')){
        function GFormFieldValue($name, $value) {
            if (empty($value) and ($value !== '0')){
                $value = old($name);
            }

            return ($value);
        }
    } // GFormFieldValue
