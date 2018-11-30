<?php
/**
 * TemplateView.php
 *
 * Objektklasse, um Anzeigeelemente zu kodieren.
 *
 * @author     Andreas Martin
 */
class TemplateView {

    public static function noHTML($input, $bEncodeAll = true, $encoding = "UTF-8")
    {
        if($bEncodeAll)
            return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, $encoding);
    }
}