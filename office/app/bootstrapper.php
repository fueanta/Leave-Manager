<?php

  // loading configuration file from: app/_conf MANUALLY
  require_once '_conf/config.php';

  // loading helpers from: app/_helpers MANUALLY
  require_once '_helpers/url_helper.php';
  require_once '_helpers/session_helper.php';
  require_once '_helpers/mail_helper.php';
  require_once '_helpers/file_helper.php';

  // loading libraries from: app/_lib MANUALLY
  require_once '_lib/core.php';
  require_once '_lib/controller.php';
  require_once '_lib/database.php';