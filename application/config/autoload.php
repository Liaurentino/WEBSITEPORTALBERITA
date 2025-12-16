<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  AUTO-LOADER YANG BENAR
| -------------------------------------------------------------------
*/

// 1. Load Libraries
$autoload['libraries'] = array('database', 'session', 'form_validation', 'upload');

// 2. Load Helpers
$autoload['helper'] = array('url', 'form', 'text', 'string', 'security', 'file');

// 3. Sisanya biarkan array kosong
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array();

// JANGAN ADA KODE LAIN DI BAWAH SINI