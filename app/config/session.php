<?php

if (!session_id()) @session_start();

if (empty($_SESSION['csrfToken'])) {
  $random_token = bin2hex(random_bytes(32));
  $_SESSION['csrfToken'] = $random_token;
}