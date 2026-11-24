<?php
/* Module 4 - Matrimony settings. Database credentials are NOT here: they come from matrimoney/config.php. */

const MAT_MODULE   = 'matrimony';   // module_key used in packages / transactions / user_packages
const MAT_MIN_AGE  = 18;
const MAT_MAX_AGE  = 80;
const MAT_NOTIFY_TYPE = 'matrimony'; // user_notifications.type for matrimony events

// Frontend base URL of the matrimony pages, derived from the dashboard URL (…/peoplelink/matrimoney/ -> …/peoplelink/module-4/Frontend/pages/)
define('MAT_URL', preg_replace('#matrimoney/$#', 'module-4/Frontend/pages/', DASHBOARD_URL));
