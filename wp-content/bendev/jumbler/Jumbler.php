<?php

include_once realpath(__DIR__ . "/../utils/PageUtils.php");

class Jumbler
{
    /**
     * Builds and returns the jumbler table
     *
     * @param $text
     * @param $setAry
     * @param $wordCountMax
     * @param $msgAry
     */
    public static function jumblerAction(&$text, &$setAry, &$wordCountMax, &$msgAry)
    {
        $text = strtolower(trim($_POST['text']));
        $setCount = $_POST['setCount'];
        $wordCount = $_POST['wordCount'];
        $lengthFrom = $_POST['lengthFrom'];
        $lengthTo = $_POST['lengthTo'];
        $useAlliteration = (isset($_POST['useAlliteration']) ? $_POST['useAlliteration'] : false);
        // Adjust the text so that there are no white space characters
        // Or could explode on white space
        //$words = preg_split('/\s+/', $text);
        $text = str_replace(array('.', ',', ':', '\'', ';', '/', '\\', '#', '[', ']', '(', ')', '"', '!', '£', '$', '%', "\n", "\r", "\t"), '', $text);
        // Remove all sequences of multiple spaces, down to a single space
        while (($adjText = str_replace(array('  '), ' ', $text)) != $text) $text = $adjText;
        $words = explode(' ', $text);
        $len = count($words);
        if ($len < 3) {
            $msgAry[] = 'Please enter more than 2 words';
        } elseif ($lengthFrom > $lengthTo) {
            $msgAry[] = 'Length From must be less than or equal to length To';
        } else {
            // Randomize the seed to make it more interesting
            srand();
            for ($i = 0; $i < $setCount; $i++) {
                $setSoFar = array();
                while (true) {
                    self::findNext($words, $setSoFar, $lengthFrom, $lengthTo, $useAlliteration);
                    // Check if we are using a random number of words
                    $wordCountValue = $wordCount;
                    if ($wordCountValue == -1) {
                        $wordCountValue = rand(1, $wordCountMax);
                    }
                    if (count($setSoFar) >= $wordCountValue) {
                        $setAry[] = $setSoFar;
                        break;
                    }
                }
            }
        }
    }

    /**
     * Analyses the input text and finds the next word, updating setSoFar
     *
     * @param $words
     * @param $setSoFar
     * @param $lengthFrom
     * @param $lengthTo
     * @param $useAlliteration
     */
    private static function findNext($words, &$setSoFar, $lengthFrom, $lengthTo, $useAlliteration)
    {
        $loopCount = 0;
        $len = count($words);
        while (true) {
            $next = rand(0, ($len - 1));
            $loopCount++;
            if ($loopCount>10000) {	// Prevent infinite loop
                if ($useAlliteration) {
                    // Could not find an alliterative match
                    $setSoFar[] = '***';
                } else {
                    // Just accept the duplicate
                    $setSoFar[] = $words[$next];
                }
                break;
            }

            if (in_array($words[$next], $setSoFar)) {
                continue;
            }

            $wordLength = strlen($words[$next]);
            if ($wordLength < $lengthFrom || $wordLength > $lengthTo) {
                continue;
            }

            if ($useAlliteration) {
                $firstLetter = ($setSoFar ? $setSoFar[0][0]: null);
                if ($firstLetter) {
                    if ($firstLetter == $words[$next][0]) {
                        // The second word starts with the same character as the first
                        $setSoFar[] = $words[$next];
                        break;
                    } else {
                        // Try again
                    }
                } else {
                    // Just accept the first word
                    $setSoFar[] = $words[$next];
                    break;
                }
            } else {
                // Accept the new word
                $setSoFar[] = $words[$next];
                break;
            }
        }
    }

    /**
     * Builds and returns the jumbler table
     *
     * @param $text
     * @param $setAry
     * @param $useAlliteration
     * @param $lengthFrom
     * @param $lengthTo
     * @param $lengthMax
     * @param $wordCount
     * @param $wordCountMax
     * @param $setCount
     * @param $setCountMax
     * @param $msgAry
     * @return string
     */
    public static function getJumblerForm($text, $setAry, $useAlliteration, $lengthFrom, $lengthTo, $lengthMax,
                                          $wordCount, $wordCountMax, $setCount, $setCountMax, $msgAry
    ) {
        $html = '';

        $html .= '<small>';
        $html .= '<form id="frm" name="frm" method="post" action="">';
        $html .= '<table border="0" cellpadding="0" cellspacing="0" width="480" height="200" style="font-size:0.9em;margin:5px 0 0 40px;">';
        $html .= '<tr>';
        $html .= '<td colspan="2" style="text-align:left;font-weight:normal;font-size:0.8em;">';
        $html .= 'Enter the text below, that you want jumbled, and then click <i>Enter</i>.<br>';
        $html .= 'You will then see a number of sets of randomly chosen words listed.</td>';
        $html .= '</tr>';

        if ($msgAry) {
            foreach ($msgAry as $msg) {
                $html .= '<tr valign="top">';
                $html .= '<td colspan="2" style="text-align:left;font-weight:normal;font-size:0.9em;color:#c40000;">' . $msg . '</td>';
                $html .= '</tr>';
            }
        }

        $html .= '<tr valign="top">';
        $html .= '<td style="width:24%;">How many sets?: </td>';
        $html .= '<td>';
        $html .= '<select id="setCount" name="setCount">';
        for ($i=1; $i<=$setCountMax; $i++) {
            $html .= '<option value="' . $i . '" ' . (($setCount==$i) ? 'selected': '') . '>' . $i . '</option>';
        }

        $html .= '</select>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr valign="top">';
        $html .= '<td style="width:24%;">How many words?: </td>';
        $html .= '<td>';
        $html .= '<select id="wordCount" name="wordCount">';
        for ($i=1; $i<=$wordCountMax; $i++) {
            $html .= '<option value="' . $i . '" ' . (($wordCount==$i) ? 'selected': '') . '>' . $i . '</option>';
        }

        $html .= '<option value="-1" ' . (($wordCount==-1) ? 'selected': '') . '>rand</option>';
        $html .= '</select>';

        $html .= '</td>';
        $html .= '</tr>';
        $html .= '<tr valign="top">';
        $html .= '<td style="width:24%;">Word length?: </td>';
        $html .= '<td NOWRAP>From:';
        $html .= '<select id="lengthFrom" name="lengthFrom">';
        for ($i=1; $i<=$lengthMax; $i++) {
            $html .= '<option value="' . $i . '" ' . (($lengthFrom == $i) ? 'selected' : '') . '>' . $i . '</option>';
        }

        $html .= '</select>';
        $html .= '&nbsp;&nbsp;To:';
        $html .= '<select id="lengthTo" name="lengthTo">';
        for ($i=1; $i<=$lengthMax; $i++) {
            $html .= '<option value="' . $i . '" ' . (($lengthTo == $i) ? 'selected' : '') . '>' . $i . '</option>';
        }

        $html .= '</select>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '<tr valign="top">';
        $html .= '<td style="width:24%;">Use alliteration?: </td>';
        $html .= '<td>';
        $html .= '<input type="checkbox" name="useAlliteration" value="1" ' . (($useAlliteration == '1') ? 'checked' : '') . '/>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td colspan="2" style="text-align:right;"><input type="submit" value="Enter"></td>';
        $html .= '</tr>';
        $html .= '</table>';

        if ($setAry) {
            $html .= '<table border="0" cellpadding="0" cellspacing="0" width="480" height="200" style="font-size:0.9em;margin:5px 0 0 40px;">';
            $i = 1;
            foreach ($setAry as $set) {
                $html .= '<tr valign="top">';
                $html .= '<td style="width:20%;text-align:right;font-weight:bold;font-size:0.9em;">' . $i . '&nbsp;&nbsp;</td>';
                $html .= '<td style="width:80%;text-align:left;font-weight:bold;font-size:0.9em;">' . implode(' ', $set) . '</td>';
                $html .= '</tr>';

                $i++;
            }
            $html .= '</table>';
        }

        $html .= '<table border="0" cellpadding="0" cellspacing="0" width="480" height="200" style="font-size:0.9em;margin:5px 0 0 40px;">';
        $html .= '<tr valign="top">';
        $html .= '<td style="width:20%;">Text:</td>';
        $html .= '<td style="width:80%;"><textarea id="text" name="text" rows="6" cols="54">' . $text . '</textarea></td>';
        $html .= '</tr>';
        $html .= '</table>';

        $html .= '</form>';
        $html .= '</small>';

        return $html;
    }
}
