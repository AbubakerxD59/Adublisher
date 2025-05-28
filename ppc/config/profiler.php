<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Profiler Sections
| -------------------------------------------------------------------------
| This file lets you determine whether or not various sections of Profiler
| data are displayed when the Profiler is enabled.
| Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/profiling.html
|
*/

$config['benchmarks']            = TRUE;        // Elapsed time of Benchmark points and total execution time.
$config['config']                = FALSE;        // CodeIgniter Config variables.
$config['controller_info']        = FALSE;        // The Controller class and method requested.
$config['get']                    = FALSE;        // Any GET data passed in the request.
$config['http_headers']            = FALSE;        // The HTTP headers for the current request.
$config['memory_usage']            = TRUE;        // Amount of memory consumed by the current request, in bytes.
$config['post']                    = FALSE;        // Any POST data passed in the request.
$config['queries']                = TRUE;        // Listing of all database queries executed, including execution time.
$config['uri_string']            = FALSE;        // The URI of the current request.
$config['session_data']         = FALSE;     // Data stored in the current session.
$config['query_toggle_count']    = 5;        // The number of queries after which the query block will default to hidden.