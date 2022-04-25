<?php
    use Carbon\Carbon;

    if (!function_exists('GDatim2Date')) {
        /**
         * given format:    yyyy-mm-dd hh-nn-ss (2019-06-14 00:00:00)
         * return:          yyyy-mm-dd (2019-06-14)
         */
        function GDatim2Date(string $datim){
            return substr($datim, 0, -9);
        }
    } // GDatim2Date

    if (!function_exists('GNowDateTime')) {
        /**
         * return the current date time
         */
        function GNowDateTime(int $pDateTime=0){
            if ($pDateTime == 0){
                $pDateTime = Carbon::now();
                // $pDateTime = strtotime('now', GC('timezone', 'app'));
            }
            $datim = GDisplayDate($pDateTime, 1, 1, 'YYYY-MM-DD', 'HH:mm:ss');
            return ($datim);

            // return date('Y-m-d  H:i:s', $pDateTime);
        }
    } // GNowDateTime

    if (!function_exists('GDateDisplay')) {
        /**
         * return the current date time formatted nicely
         */
        function GDateDisplay($pDatetime='', int $showTime=0){
            $vDateFormat = "ddd, Do MMM, YYYY";
            $vTimeFormat = "h:mm A";

            if (empty($pDatetime)){
                $vDateTime = GTimeFromString(GNowDateTime());
            } else{
                $vDateTime = GTimeFromString($pDatetime);
            }

            $vDatim = Carbon::parse($vDateTime);
            if ( ($showTime == 1) ) {
                return ($vDatim->isoFormat($vDateFormat . ' - ' . $vTimeFormat));
            } else {
                return ($vDatim->isoFormat($vDateFormat));
            }
        }
    } // GDateDisplay

    if (!function_exists('GFutureDate')) {
        /**
         * return true if given datim is in future
         */
        function GFutureDate($pDateTime){
            if ($pDateTime >= Carbon::now()){
                return true;
            } else {
                return false;
            }
        }
    } // GDateDisplayShort

    if (!function_exists('GDateDisplayShort')) {
        /**
         * return the current date time formatted nicely
         */
        function GDateDisplayShort($pDateTime='', int $showTime=0, int $showDate=0){
            return (GDisplayDate($pDateTime, $showTime, $showDate, 'ddd, Do MMM, YYYY', 'h:mm A'));
        }
    } // GDateDisplayShort

    if (!function_exists('GDateDisplayTiny')) {
        /**
         * return the current date time formatted nicely
         */
        function GDateDisplayTiny($pDateTime='', int $showTime=0, int $showDate=0, int $formatType=0){
            $formatD = 'D MMM Y';
            $formatT = 'h:mm A';
            if ($formatType == 1){
                $formatD = 'D-MM-YY';
                $formatT = 'H:mm';
            }
            if ($formatType == 2){
                $formatD = 'D-MM-YYYY';
                $formatT = 'H:mm';
            }
            return (GDisplayDate($pDateTime, $showTime, $showDate, $formatD, $formatT));
        }
    } // GDateDisplayTiny

    if (!function_exists('GDisplayDate')) {
        /**
         * return the current date time formatted nicely
         */
        function GDisplayDate($Datetime, int $showTime, int $showDate, string $vDateFormat='', string $vTimeFormat=''){
            if (empty($vDateFormat)){
                $vDateFormat = "D MMM Y";
            }
            if (empty($vTimeFormat)){
                $vTimeFormat = "h:mm A";
            }
                // $vTimeFormat = "g:i A";

            if (empty($Datetime)){
                $Datetime = GNowDateTime();
            }

            $pDateTime = GTimeFromString($Datetime);

            $vDatim = Carbon::parse($pDateTime);
            if ( ($showTime == 1) and ($showDate == 1) ) {
                return ($vDatim->isoFormat($vDateFormat . ' ' . $vTimeFormat));
            }
            if ($showTime == 1) {
                return ($vDatim->isoFormat($vTimeFormat));
            }
            if ($showDate == 1) {
                return ($vDatim->isoFormat($vDateFormat));
            }

            return ($vDatim->isoFormat($vDateFormat . ' ' . $vTimeFormat));
        }
    } // GDisplayDate

    if (!function_exists('GTimeFromString')) {
        /**
         * return the current date time formatted nicely
         */
        function GTimeFromString($Datetime) {
            $datim = new DateTime($Datetime, new DateTimeZone(GC('timezone', 'app')));
            return $datim;
        } // GTimeFromString

    } // GTimeFromString

    if (!function_exists('GDayTimeDiff')) {
        /**
         * return the string value for day / time diff
         */
        function GDayTimeDiff($pFromDatim, $pToDatim) {
            $strDiff = '';
            $datimfrom = date_create($pFromDatim);
            $datimto = date_create($pToDatim);

            $diff = date_diff($datimfrom, $datimto);
            // $diff->format('%y:%m:%d:%h:%i:%s');
            if ($diff->format('%d') != '0'){
                $strDiff .= $diff->format('%d days');
            }
            if ($diff->format('%h') != '0'){
                $strDiff .= ' ' . $diff->format('%h hrs');
            }
            if ($diff->format('%i') != '0'){
                $strDiff .= ' ' . $diff->format('%i mins');
            }
            return(ltrim(' ' . $strDiff));
        } // GDayTimeDiff
    } // GDayTimeDiff

    if (!function_exists('GAllDayEvent')) {
        /**
         * return the true if start date is exactly 24 hours before end date, and start time is 00:00:00
         */
        function GAllDayEvent($fromdatim, $todatim) {
            $datimfrom = GTimeFromString($fromdatim);
            $timefrom = $datimfrom->format('h:i:s A');
            if ($timefrom != '12:00:00 AM') {
                // does not start at midnight
                return false;
            }
            $datimto = GTimeFromString($todatim);
            $interval = date_diff($datimfrom, $datimto);

            if ($interval->format('%y:%m:%d:%h:%i:%s') == "0:0:1:0:0:0") {
                return true;
            }
            return false;
        } // GAllDayEvent
    } // GAllDayEvent
